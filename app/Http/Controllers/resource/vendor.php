<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor as vendors;
use App\Models\Company;
use App\Models\Proposal;
use App\Mail\VendorVerified;
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
        $vendors=vendors::with('company')->whereNotNull('vendor_status')->orderBy('vendor_name')->get();
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
                      ->select('id', 'vendor_id', \DB::raw('SUM(proposal_total_cost) as total_proposal_amount'))
                      ->groupBy('id', 'vendor_id');
            },
            'invoices' => function ($query) {
                $query->where('invoice_status', 1)
                      ->join('payment_milestones', 'invoices.milestone_id', '=', 'payment_milestones.id')
                      ->select('invoices.vendor_id', 'invoices.proposal_id', \DB::raw('SUM(payment_milestones.milestone_total_amount) as total_paid_amount'))
                      ->groupBy('invoices.vendor_id', 'invoices.proposal_id');
            }
        ])->find($id);

        $proposalWiseTotals = []; 

        $vendor->proposals = $vendor->proposals->map(function ($proposal) use ($vendor, &$proposalWiseTotals) {
            // Get total paid amount for the specific proposal
            $totalPaidAmount = $vendor->invoices
                ->where('proposal_id', $proposal->id) // Filter by the proposal ID
                ->sum('total_paid_amount'); // Sum total_paid_amount per proposal
            
            // Add the total_paid_amount to the proposal
            $proposal->total_paid_amount = $totalPaidAmount;
        
            // Construct the proposal-wise total array
            $proposalWiseTotals[] = [
                'proposal_id' => $proposal->id, // Proposal ID
                'proposal_date' => $proposal->proposal_date, // Ensure this field exists
                'total_proposal_amount' => $proposal->total_proposal_amount,
                'total_paid_amount' => $totalPaidAmount,
            ];
        
            return $proposal;
        });

        
        
        return view('vendor.show',compact('vendor','proposalWiseTotals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor=vendors::find($id);
        $companies=Company::orderBy('company_name')->get();
        return view('vendor.edit', compact('vendor','companies'));
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
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:vendor,vendor_code,'.$id,
            'email' => 'required|string|email',
            'phone' => 'required|max:15',
            'company'=> 'required',
            'address' => 'required',
        ]);
    
            try {
                $vendor = vendors::findOrFail($id);
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
        
                return redirect()->route('vendor.index')->with('success', 'Vendor Updated Successfully');
            } catch (\Exception $e) {
                // Log the exception message
                return redirect()->back()->with('error', $e->getMessage());
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
