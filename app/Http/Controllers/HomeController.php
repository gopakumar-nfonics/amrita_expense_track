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
    public function index()
    {

        if (Auth::user()->isvendor()) {
            if(Auth::user()->vendor_status == null){
                return redirect()->route('registration');

            }else{
            $userId = Auth::user()->id;
            $vendor = Vendor::where('user_id', $userId)->first();
            $proposal = Proposal::where('vendor_id', $vendor->id)->orderBy('id')->get();
            return view('lead.index', compact('proposal'));
            }
        } else {

            $budgettotalAmount = Budget::sum('amount');
            $totalPaidAmount = PaymentMilestone::whereHas('invoice', function($query) {
                $query->where('invoice_status', 1);
            })->sum('milestone_total_amount');
            $remainingBudget = $budgettotalAmount - $totalPaidAmount;
            
            $usedPercentage = $budgettotalAmount > 0 ? ($totalPaidAmount / $budgettotalAmount) * 100 : 0;

            if (floor($usedPercentage) == $usedPercentage) {
                $usedPercentage = number_format($usedPercentage, 0); 
                } else {
                $usedPercentage = number_format($usedPercentage, 2); 
                }


            $categoryWiseBudgets = Budget::with('category')
            ->select('category_id', \DB::raw('SUM(amount) as total_amount'))
            ->groupBy('category_id')
            ->get();

            //$vendors = vendor::with('company')->where('vendor_status', 'verified')->orderBy('id')->get();

            $vendors = Vendor::with(['company', 'proposals' => function($query) {
                $query->where('proposal_status', 1)
                      ->select('vendor_id', \DB::raw('SUM(proposal_total_cost) as total_proposal_amount'))
                      ->groupBy('vendor_id');
            }, 'invoices' => function($query) {
                $query->where('invoice_status', 1)
                      ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
                      ->select('invoices.vendor_id', \DB::raw('SUM(payment_milestones.milestone_total_amount) as total_paid_amount'))
                      ->groupBy('invoices.vendor_id');
            }])
            ->where('vendor_status', 'verified')
            ->orderBy('id')
            ->get();
        
            $totalMilestoneByCategory = PaymentMilestone::join('invoices', 'payment_milestones.id', '=', 'invoices.milestone_id')
            ->join('payment_request', 'invoices.id', '=', 'payment_request.invoice_id')
            ->leftJoin('tbl_category as child_category', 'payment_request.category_id', '=', 'child_category.id') // LEFT JOIN for child_category
            ->leftJoin('tbl_category as parent_category', function($join) {
                $join->on('child_category.parent_category', '=', 'parent_category.id')
                    ->orOn('payment_request.category_id', '=', 'parent_category.id'); // Handle both child and parent category cases
            })
            ->select(
                'parent_category.id as parent_category_id',
                'parent_category.category_name as parent_category_name', // Adjust based on your actual column name
                DB::raw('SUM(payment_milestones.milestone_total_amount) as total_milestone_amount')
            )
            ->groupBy('parent_category.id','parent_category.category_name') // Group by parent category ID
            ->get();
        


        $categorybudgetused = [];
    foreach ($totalMilestoneByCategory as $milestone) {
        $categorybudgetused[] = [
            'parent_category_id' => $milestone->parent_category_id,
            'parent_category_name' => $milestone->parent_category_name,
            'total_milestone_amount' => $milestone->total_milestone_amount,
            'budget_amount' => $categoryWiseBudgets->where('category_id', $milestone->parent_category_id)->sum('total_amount') // Adjust the category_id if needed
        ];
    }
     



            return view('home',compact('budgettotalAmount','categoryWiseBudgets','vendors','totalPaidAmount','remainingBudget','usedPercentage','categorybudgetused'));
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
            if ($vendor->company) {
                // Update the existing company's name
                $vendor->company->company_name = $request->company;
                $vendor->company->save();
            } else {
                // Create a new company if none exists
                $company = new Company();
                $company->company_name = $request->company;
                $company->save();

                $vendor->company_id = $company->id;
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
            if($vendor->vendor_status != 'verified'){
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

            $subject ="Welcome to Amrita - Vendor Sign-Up Successful!";

            Mail::to($vendor->email)->send(new VendorRegistration($detailsvendor,$subject));

            $adminsubject ="Vendor Sign-Up Notification - Review and Approval Required";
            $adminemail = env('CONTACT_MAIL');
            Mail::to($adminemail)->send(new AdminVendorRegistration($detailsvendor,$adminsubject));



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
            if ($vendor->company) {
                // Update the existing company's name
                $vendor->company->company_name = $request->company;
                $vendor->company->save();
            } else {
                // Create a new company if none exists
                $company = new Company();
                $company->company_name = $request->company;
                $company->save();

                $vendor->company_id = $company->id;
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
            if($vendor->vendor_status != 'verified'){
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

        $proposal = Proposal::with(['paymentMilestones', 'vendor.states','proposalro'])->find($id);

       
        
        $number = $proposal->proposal_total_cost;
        $numbersWords = new Numbers_Words();
        $amounwords = $numbersWords->toWords($number);
        
        return view('lead.release_order',compact('proposal', 'amounwords'));
    }
}