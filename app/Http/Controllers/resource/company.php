<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company as companies;
use Illuminate\Validation\Rule;

class company extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies=companies::orderBy('company_name')->get();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prefix = 'BUET-CY-';
        // Retrieve the highest existing code
        $latestCode = companies::where('company_code', 'like', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(company_code, LENGTH(?) + 1) AS UNSIGNED) DESC', [$prefix])
            ->pluck('company_code')
            ->first();

        $latestNumber = 0;
        if ($latestCode) {
            $latestNumber = (int)substr($latestCode, strlen($prefix));
        }

        $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT); // Adjust to 4 digits
        $companycode = $prefix . $nextNumber;
        return view('company.create',compact('companycode'));
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
            'name' => 'required|unique:company,company_name',
            'code' => 'required|unique:company,company_code',
            'email' => 'required|string|email|max:255|unique:company',
            'phone' => 'required|max:15',
            'address' => 'required',
        ]);
    
            try {
                $company = new companies();
                $company->company_name = $request->name;
                $company->company_code = $request->code;
                $company->email = $request->email;
                $company->phone = $request->phone;
                if ($request->has('gst')) {
                    $company->gst = $request->gst;
                }
                if ($request->has('pan')) {
                    $company->pan = $request->pan;
                }
                $company->address = $request->address;
                $company->save();
        
                return redirect()->route('company.index')->with('success', 'Company Created Successfully');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = companies::find($id);
        return view('company.edit',compact('company'));
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
            'name' => [
                'required',
                Rule::unique('company', 'company_name')->ignore($id),
            ],
            'code' => [
                'required',
                Rule::unique('company', 'company_code')->ignore($id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('company', 'email')->ignore($id),
            ],
            'phone' => 'required|max:15',
            'address' => 'required',
        ]);
        
    
            try {
                $company = companies::findOrFail($id);
                $company->company_name = $request->name;
                $company->company_code = $request->code;
                $company->email = $request->email;
                $company->phone = $request->phone;
                if ($request->has('gst')) {
                    $company->gst = $request->gst;
                }
                if ($request->has('pan')) {
                    $company->pan = $request->pan;
                }
                $company->address = $request->address;
                $company->save();
        
                return redirect()->route('company.index')->with('success', 'Company Updated Successfully');
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
}
