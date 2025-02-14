<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor as vendors;
use App\Models\Company;
use App\Models\Proposal;
use App\Models\User;
use App\Models\State;
use App\Mail\VendorVerified;
use App\Models\VendorBankAccount;
use Illuminate\Support\Facades\Mail;

class vendor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors=vendors::with('company')->whereNotNull('vendor_status')->orderByDesc('vendor_name')->get();
        return view('vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prefix = 'BUET-VR-';
        // Retrieve the highest existing code
        $latestCode = vendors::where('vendor_code', 'like', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(vendor_code, LENGTH(?) + 1) AS UNSIGNED) DESC', [$prefix])
            ->pluck('vendor_code')
            ->first();

        $latestNumber = 0;
        if ($latestCode) {
            $latestNumber = (int)substr($latestCode, strlen($prefix));
        }

        $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT); // Adjust to 4 digits
        $vendorcode = $prefix . $nextNumber;

        $companies=Company::orderBy('company_name')->get();
        return view('vendor.create', compact('companies','vendorcode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:vendor,vendor_code',
            'email' => 'required|string|email',
            'phone' => 'required|max:15',
            'company'=> 'required',
            'address' => 'required',
        ]);
    
            try {
                $vendor = new vendors();
                $vendor->vendor_name = $request->name;
                $vendor->vendor_code = $request->code;
                $vendor->email = $request->email;
                $vendor->phone = $request->phone;
                $vendor->company_id  = $request->company;
                if ($request->has('gst')) {
                    $vendor->gst = $request->gst;
                }
                if ($request->has('pan')) {
                    $vendor->pan = $request->pan;
                }
                $vendor->address = $request->address;
                $vendor->save();
        
                return redirect()->route('vendor.index')->with('success', 'Vendor Created Successfully');
            } catch (\Exception $e) {
                // Log the exception message
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = vendors::with([
            'company',
            'states',
            'proposals' => function ($query) {
                $query->where('proposal_status', 1)
                      ->select('id', 'vendor_id', 'proposal_title', 'proposal_id', 'created_at', \DB::raw('SUM(proposal_total_cost) as total_proposal_amount'))
                      ->groupBy('id', 'vendor_id', 'proposal_title', 'proposal_id', 'created_at');
            },
            'invoices' => function ($query) {
                $query->where('invoice_status', 1)
                      ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
                      ->select('invoices.vendor_id', 'invoices.proposal_id', \DB::raw('SUM(payment_milestones.milestone_total_amount) as total_paid_amount'))
                      ->groupBy('invoices.vendor_id', 'invoices.proposal_id');
            }
        ])->find($id);
        
        $proposalWiseTotals = []; 
        $totalProposalCost = 0;
        $totalPaidAmount = 0;
        
        $vendor->proposals = $vendor->proposals->map(function ($proposal) use ($vendor, &$proposalWiseTotals, &$totalProposalCost, &$totalPaidAmount) {
            // Get total paid amount for the specific proposal
            $paidAmountForProposal = $vendor->invoices
                ->where('proposal_id', $proposal->id) // Filter by the proposal ID
                ->sum('total_paid_amount'); // Sum total_paid_amount per proposal
            
            // Add the total_paid_amount to the proposal
            $proposal->total_paid_amount = $paidAmountForProposal;
        
            // Accumulate the total amounts
            $totalProposalCost += $proposal->total_proposal_amount;
            $totalPaidAmount += $paidAmountForProposal;
        
            // Construct the proposal-wise total array with additional fields
            $proposalWiseTotals[] = [
                'proposal_id' => $proposal->proposal_id, 
                'proposal_title' => $proposal->proposal_title,
                'created_at' => $proposal->created_at,
                'total_proposal_amount' => $proposal->total_proposal_amount,
                'total_paid_amount' => $paidAmountForProposal,
            ];
        
            return $proposal;
        });
        
        // Add the total proposal cost and total paid amount to the vendor object
        $vendor->total_proposal_cost = $totalProposalCost;
        $vendor->total_paid_amount = $totalPaidAmount;

       //print_r($vendor);exit();

        $bankaccount_details = VendorBankAccount::where('vendor_id', $vendor->id)->first();

        
        return view('vendor.show',compact('vendor','proposalWiseTotals','bankaccount_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = vendors::where('id', $id)->first();
        $user = User::where('id', $vendor->user_id)->first();
        $account_details = VendorBankAccount::where('vendor_id', $vendor->id)->first();
        if (isset($vendor->company_id)) {
            $company = Company::where('id', $vendor->company_id)->first();

            // Ensure $companies is an array
            $companies = $company ? $company->toArray() : [];
        } else {
            $companies = [];
        }
        $states = State::all();
        return view('vendor.edit', compact('user', 'vendor', 'companies', 'states', 'account_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            $vendor = Vendors::findOrFail($request->vid);

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

            $vendorBankAccount = VendorBankAccount::where('vendor_id', $request->vid)->firstOrFail();
            $vendorBankAccount->beneficiary_name = $request->beneficiary_name;
            $vendorBankAccount->account_no = $request->account_no;
            $vendorBankAccount->ifsc_code = $request->ifsc_code;
            $vendorBankAccount->bank_name = $request->bank_name;
            $vendorBankAccount->branch_name = $request->branch_name;
            $vendorBankAccount->vendor_id = $vendor->id; // If you need to associate it with a vendor
            $vendorBankAccount->save();


            $userId = $vendor->user_id;
            $user = User::where('id', $userId)->first();

            $user->first_name = $request->name;

            $user->save();



            return redirect()->route('vendor.index')->with('success', 'Vendor details Updated Successfully');
        } catch (\Exception $e) {
            // Log the exception
            print_r($e->getMessage());
            exit();
            \Log::error('Vendor update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the vendor.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteVendor(Request $request)
    {

        $vendor = vendors::findOrFail($request->input('id'));

        if (!$vendor) {
        return response()->json(['error' => 'vendor not found.'], 404);
        }

        $proposalCount = Proposal::where('vendor_id', $vendor->id)->count();

        if ($proposalCount > 0) {
            return response()->json(['error' => 'Cannot delete vendor associated with a proposal.']);
        }

        $vendor->forceDelete(); 
        return response()->json(['success' => 'The vendor has been deleted!']);
        
    }

    public function approve(Request $request)
    {

        $status = $request->input('status');

       
        
        $vendor = vendors::findOrFail($request->input('id'));
        if (!$vendor) {
        return response()->json(['error' => 'Vendor not found.'], 404);
        }

        if($status == 'approve'){
        $vendor->vendor_status = 'verified';
        $vendor->save();

        $detailsvendor = [
            'name' => $vendor->vendor_name,
            
        ];

        $subject ="Your Vendor Registration with Amrita - Approved!";

        Mail::to($vendor->email)->send(new VendorVerified($detailsvendor,$subject));

        return response()->json(['success' => 'The Vendor has been approved!']);

    }
    if($status == 'rejected'){
        $vendor->vendor_status = 'rejected';
        $vendor->save();

        

        return response()->json(['success' => 'The Vendor has been rejected!']);

    }
        
    }
}
