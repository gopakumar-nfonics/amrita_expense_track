<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor as vendors;
use App\Models\Company;

class vendor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors=vendors::with('company')->orderBy('vendor_name')->get();
        return view('vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies=Company::orderBy('company_name')->get();
        return view('vendor.create', compact('companies'));
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
            'email' => 'required|string|email|max:255|unique:vendor',
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
        //
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
        //
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
}
