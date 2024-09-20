<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor as vendors;
use App\Models\Company;
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
        return view('vendor.show');
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
