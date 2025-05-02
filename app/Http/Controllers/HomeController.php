<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\State;
use App\Models\Proposal;
use App\Models\PaymentMilestone;
use App\Models\PaymentRequest;
use App\Models\VendorBankAccount;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use App\Mail\VendorRegistration;
use App\Mail\AdminVendorRegistration;
use Illuminate\Support\Facades\Mail;
use App\Models\Campus;
use App\Models\Category;
use App\Models\FinancialYear;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Numbers_Words;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if (Auth::user()->isvendor()) {
            if (Auth::user()->vendor_status == null) {
                return redirect()->route('registration');
            } else {

                $userId = Auth::user()->id;
                $vendor = Vendor::where('user_id', $userId)->first();

                $vendor_id = $vendor->id;

                $vendor_id = $vendor->id;

                $vendordata = Vendor::with([
                    'company',
                    'proposals' => function ($query) {
                        $query->where('proposal_status', 1)
                            ->select('vendor_id', \DB::raw('SUM(proposal_total_cost) as total_proposal_amount'))
                            ->groupBy('vendor_id');
                    },
                    'invoices' => function ($query) {
                        $query->where('invoice_status', 1)
                            ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
                            ->select('invoices.vendor_id', \DB::raw('SUM(payment_milestones.milestone_total_amount) as total_paid_amount'))
                            ->groupBy('invoices.vendor_id');
                    }
                ])
                    ->where('vendor_status', 'verified')
                    ->where('id', $vendor_id) // Fetch specific vendor by id
                    ->first();

                // Get the totals
                $total_proposal_amount = $vendordata->proposals->isNotEmpty() ? $vendordata->proposals[0]->total_proposal_amount : 0;
                $total_paid_amount = $vendordata->invoices->isNotEmpty() ? $vendordata->invoices[0]->total_paid_amount : 0;
                $remainingBudget = $total_proposal_amount - $total_paid_amount;

                $paid_percentage = $total_proposal_amount > 0 ? ($total_paid_amount / $total_proposal_amount) * 100 : 0;

                // Optionally, you can round the percentage to two decimal places
                $paid_percentage = round($paid_percentage, 2);

                //$proposal = Proposal::where('vendor_id', $vendor->id)->orderBy('id')->get();

                $proposal = Proposal::where('vendor_id', $vendor->id)
    ->with(['invoices' => function ($query) {
        $query->where('invoice_status', 1) // Add condition to filter by invoice_status
            ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
            ->select('invoices.proposal_id', 
                DB::raw('COUNT(payment_milestones.id) as total_milestone_count'), 
                DB::raw('SUM(payment_milestones.milestone_total_amount) as total_paid_amount'))
            ->groupBy('invoices.proposal_id');
    }])
    ->with(['paymentMilestones' => function ($query) {
        // Get the count and sum for all payment milestones related to each proposal
        $query->select('id','proposal_id'); // Adjust fields as necessary
    }])
    ->orderBy('id')
    ->get();





                return view('vendor_dashboard', compact('total_proposal_amount', 'total_paid_amount', 'remainingBudget','paid_percentage','proposal'));
            }
        } else {

            $Year = $request->query('year');
            if (!$Year) {
            $currentfinancialYear = FinancialYear::where('is_current', 1)->first();

            $financialYearId = $currentfinancialYear->id;
            }else{

                $currentfinancialYear = FinancialYear::where('year', $Year)->first();

            $financialYearId = $currentfinancialYear->id;

            }

            $budgettotalAmount = Budget::where('financial_year_id', $financialYearId)->sum('amount');
            $PaidAmount = PaymentMilestone::whereHas('invoice', function ($query) {
                $query->where('invoice_status', 1);
            })
            ->when($financialYearId, function ($query) use ($financialYearId) {
                $query->whereHas('proposal', function ($subQuery) use ($financialYearId) {
                    $subQuery->where('proposal_year', $financialYearId);
                });
            })
            ->sum('milestone_total_amount');

            $remainingBudget = $budgettotalAmount - $PaidAmount;

            $usedPercentage = $budgettotalAmount > 0 ? ($PaidAmount / $budgettotalAmount) * 100 : 0;

            if (floor($usedPercentage) == $usedPercentage) {
                $usedPercentage = number_format($usedPercentage, 0);
            } else {
                $usedPercentage = number_format($usedPercentage, 2);
            }


            $categoryWiseBudgets = Budget::with('category')
                ->select('category_id', \DB::raw('SUM(amount) as total_amount'))
                ->where('financial_year_id', $financialYearId)
                ->groupBy('category_id')
                ->orderBy('total_amount', 'DESC') // Order by total_amount in descending order
                ->get();

            //$vendors = vendor::with('company')->where('vendor_status', 'verified')->orderBy('id')->get();

            $vendors = Vendor::with([
                'company',
                'proposals' => function ($query) use ($financialYearId) {
                    $query->where('proposal_status', 1)
                        ->when(!is_null($financialYearId), function ($query) use ($financialYearId) {
                            $query->where('proposal_year', $financialYearId); // Add year filter
                        })
                        ->select('vendor_id', \DB::raw('SUM(proposal_total_cost) as total_proposal_amount'))
                        ->groupBy('vendor_id');
                },
                'invoices' => function ($query) use ($financialYearId) {
                    $query->where('invoice_status', 1)
                        ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
                        ->join('proposal', 'payment_milestones.proposal_id', '=', 'proposal.id') // join proposal
                        ->when(!is_null($financialYearId), function ($query) use ($financialYearId) {
                            $query->where('proposal.proposal_year', $financialYearId); // Add year filter
                        })
                        ->select('invoices.vendor_id', \DB::raw('SUM(payment_milestones.milestone_total_amount) as total_paid_amount'))
                        ->groupBy('invoices.vendor_id');
                }
            ])
                ->where('vendor_status', 'verified')
                ->orderBy('id')
                ->get();
            
                

                $totalMilestoneByCategory = PaymentMilestone::join('invoices', 'payment_milestones.id', '=', 'invoices.milestone_id')
                    ->join('payment_request', 'invoices.id', '=', 'payment_request.invoice_id')
                    ->leftJoin('tbl_category as child_category', 'payment_request.category_id', '=', 'child_category.id') // LEFT JOIN for child_category
                    ->leftJoin('tbl_category as parent_category', 'child_category.parent_category', '=', 'parent_category.id') // Get parent category from child category
                    ->join('proposal', 'payment_milestones.proposal_id', '=', 'proposal.id') // join with proposal table
                    ->where('payment_request.payment_status', 'completed') // Filter by payment status
                    ->when($financialYearId, function ($query) use ($financialYearId) {
                        $query->where('proposal.proposal_year', $financialYearId); // Filter by financial year
                    })
                    ->select(
                        DB::raw('COALESCE(parent_category.id, child_category.id) as parent_category_id'), // Get the parent category or fallback to child category
                        DB::raw('COALESCE(parent_category.category_name, child_category.category_name) as parent_category_name'), // Get the parent category name or fallback
                        DB::raw('SUM(payment_milestones.milestone_total_amount) as total_milestone_amount') // Sum the milestones
                    )
                    ->groupBy('parent_category_id', 'parent_category_name') // Group by parent category
                    ->orderBy('total_milestone_amount', 'DESC') // Order by total milestone amount
                    ->get();


            $categorybudgetused = [];
            foreach ($totalMilestoneByCategory as $milestone) {
                // Use parent_category_id directly since child categories are grouped under parent
                $categoryIdToUse = $milestone->parent_category_id;

                $categorybudgetused[] = [
                    'parent_category_id' => $milestone->parent_category_id,
                    'parent_category_name' => $milestone->parent_category_name,
                    'total_milestone_amount' => $milestone->total_milestone_amount,
                    'budget_amount' => $categoryWiseBudgets->where('category_id', $categoryIdToUse)->sum('total_amount') // Sum the budget based on parent category
                ];
            }



            //print_r($categorybudgetused);exit();

            $totalcatCount = Category::where('parent_category', NULL)->count();


            $financialyears = FinancialYear::get();


            return view('home', compact('budgettotalAmount', 'categoryWiseBudgets', 'vendors', 'PaidAmount', 'remainingBudget', 'usedPercentage', 'categorybudgetused', 'totalcatCount','financialyears','currentfinancialYear'));
        }
    }

    public function registration()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $vendor = Vendor::where('user_id', $userId)->first();
        $account_details = VendorBankAccount::where('vendor_id', $vendor->id)->first();
        if (isset($vendor->company_id)) {
            $company = Company::where('id', $vendor->company_id)->first();

            // Ensure $companies is an array
            $companies = $company ? $company->toArray() : [];
        } else {
            $companies = [];
        }
        $states = State::all();
        return view('vendor_registration', compact('user', 'vendor', 'companies', 'states', 'account_details'));
    }

    public function registrationprocess(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'gst' => 'nullable|string|max:15',
            'pan' => 'nullable|string|max:10',
            'address_2' => 'nullable|string|max:255',
            'beneficiary_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'cn_person' => 'required|string|max:255',

        ]);

        try {
            // Find the vendor
            $vendor = Vendor::findOrFail($request->vid);

            // Check if the vendor already has a company
           /* if ($vendor->company) {
                // Update the existing company's name
                $vendor->company->company_name = $request->company;
                $vendor->company->save();
            } else {
                // Create a new company if none exists
                $company = new Company();
                $company->company_name = $request->company;
                $company->save();

                $vendor->company_id = $company->id;
            }*/

            if ($request->company) {
                // If a company name is provided, update or create a company
                if ($vendor->company) {
                    $vendor->company->company_name = $request->company;
                    $vendor->company->save();
                } else {
                    $company = new Company();
                    $company->company_name = $request->company;
                    $company->save();
            
                    $vendor->company_id = $company->id;
                    $vendor->save(); // Save the vendor with the new company_id
                }
            } else {
                // If no company name is provided, delete the existing company (if any)
                if ($vendor->company) {
                    $vendor->company->forceDelete();
                    $vendor->company_id = null;
                    $vendor->save(); // Save the vendor with null company_id
                }
            }
            

            // Update vendor details
            $vendor->vendor_name = $request->name;
            $vendor->phone = $request->phone;
            $vendor->contact_person = $request->cn_person;
            $vendor->gst = $request->gst ?? $vendor->gst;
            $vendor->pan = $request->pan ?? $vendor->pan;
            $vendor->address = $request->address;
            $vendor->address_2 = $request->address_2 ?? $vendor->address_2;
            $vendor->city = $request->city;
            $vendor->postcode = $request->postcode;
            $vendor->state = $request->state;
            if ($vendor->vendor_status != 'verified') {
                $vendor->vendor_status = 'profile updated';
            }

            $vendor->save();

            $vendorBankAccount = new VendorBankAccount();
            $vendorBankAccount->beneficiary_name = $request->beneficiary_name;
            $vendorBankAccount->account_no = $request->account_no;
            $vendorBankAccount->ifsc_code = $request->ifsc_code;
            $vendorBankAccount->bank_name = $request->bank_name;
            $vendorBankAccount->branch_name = $request->branch_name;
            $vendorBankAccount->vendor_id = $vendor->id; // If you need to associate it with a vendor
            $vendorBankAccount->save();


            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $user->first_name = $request->name;

            $user->save();

            $detailsvendor = [
                'name' => $vendor->vendor_name,

            ];

            $subject = "Welcome to Amrita - Vendor Sign-Up Successful!";

            Mail::to($vendor->email)->send(new VendorRegistration($detailsvendor, $subject));

            $adminsubject = "Vendor Sign-Up Notification - Review and Approval Required";
            $adminemail = env('CONTACT_MAIL');
            Mail::to($adminemail)->send(new AdminVendorRegistration($detailsvendor, $adminsubject));



            return redirect()->route('registration')->with('success', 'Vendor registered successfully.');
        } catch (\Exception $e) {
            // Log the exception
            print_r($e->getMessage());
            exit();
            \Log::error('Vendor update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the vendor.');
        }
    }

    public function profile()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $vendor = Vendor::where('user_id', $userId)->first();
        $account_details = VendorBankAccount::where('vendor_id', $vendor->id)->first();
        if (isset($vendor->company_id)) {
            $company = Company::where('id', $vendor->company_id)->first();

            // Ensure $companies is an array
            $companies = $company ? $company->toArray() : [];
        } else {
            $companies = [];
        }
        $states = State::all();
        return view('profile', compact('user', 'vendor', 'companies', 'states', 'account_details'));
    }

    public function profileupdate(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'gst' => 'nullable|string|max:15',
            'pan' => 'nullable|string|max:10',
            'address_2' => 'nullable|string|max:255',
            'beneficiary_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'cn_person' => 'required|string|max:255',

        ]);

        try {
            // Find the vendor
            $vendor = Vendor::findOrFail($request->vid);

            // Check if the vendor already has a company
            /*if ($vendor->company) {
                // Update the existing company's name
                $vendor->company->company_name = $request->company;
                $vendor->company->save();
            } else {
                // Create a new company if none exists
                $company = new Company();
                $company->company_name = $request->company;
                $company->save();

                $vendor->company_id = $company->id;
            }*/

            if ($request->company) {
                // If a company name is provided, update or create a company
                if ($vendor->company) {
                    $vendor->company->company_name = $request->company;
                    $vendor->company->save();
                } else {
                    $company = new Company();
                    $company->company_name = $request->company;
                    $company->save();
            
                    $vendor->company_id = $company->id;
                    $vendor->save(); // Save the vendor with the new company_id
                }
            } else {
                // If no company name is provided, delete the existing company (if any)
                if ($vendor->company) {
                    $vendor->company->forceDelete();
                    $vendor->company_id = null;
                    $vendor->save(); // Save the vendor with null company_id
                }
            }
            

            // Update vendor details
            $vendor->vendor_name = $request->name;
            $vendor->phone = $request->phone;
            $vendor->contact_person = $request->cn_person;
            $vendor->gst = $request->gst ?? $vendor->gst;
            $vendor->pan = $request->pan ?? $vendor->pan;
            $vendor->address = $request->address;
            $vendor->address_2 = $request->address_2 ?? $vendor->address_2;
            $vendor->city = $request->city;
            $vendor->postcode = $request->postcode;
            $vendor->state = $request->state;
            if ($vendor->vendor_status != 'verified') {
                $vendor->vendor_status = 'profile updated';
            }

            $vendor->save();

            $vendorBankAccount = VendorBankAccount::where('vendor_id', $request->vid)->firstOrFail();
            $vendorBankAccount->beneficiary_name = $request->beneficiary_name;
            $vendorBankAccount->account_no = $request->account_no;
            $vendorBankAccount->ifsc_code = $request->ifsc_code;
            $vendorBankAccount->bank_name = $request->bank_name;
            $vendorBankAccount->branch_name = $request->branch_name;
            $vendorBankAccount->vendor_id = $vendor->id; // If you need to associate it with a vendor
            $vendorBankAccount->save();


            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $user->first_name = $request->name;

            $user->save();



            return redirect()->route('lead.index')->with('success', 'Profile Updated Successfully');
        } catch (\Exception $e) {
            // Log the exception
            print_r($e->getMessage());
            exit();
            \Log::error('Vendor update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the vendor.');
        }
    }

    public function email()
    {

        $id = 9;

        $proposal = Proposal::with(['paymentMilestones', 'vendor.states', 'proposalro'])->find($id);



        $number = $proposal->proposal_total_cost;
        $numbersWords = new Numbers_Words();
        $amounwords = $numbersWords->toWords($number);

        return view('lead.release_order', compact('proposal', 'amounwords'));
    }

    public function userprofile()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $campus=Campus::orderBy('campus_name')->get();

        return view('userprofile',compact('user', 'campus'));
    }

    public function userupdate(Request $request){

        $id = Auth::user()->id;

        $request->validate([
            'fname' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);
        try{
            $user = User::findOrFail($id);
           $user->first_name = $request->fname;
           if($request->has('lname')){
               $user->last_name = $request->lname;
           }
           if($request->filled('password')){
           $user->password = bcrypt($request->password);
           }
           $user->save();

           return redirect()->route('dashboard')->with('success','User updated Successfully');
       } catch (\Exception $e) {
           return redirect()->back()->with('error', $e->getMessage());
       }
    }
}
