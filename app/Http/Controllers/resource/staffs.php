<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Models\Designation;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StaffImport;

class staffs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::with('designation')->orderByDesc('id') ->get(); 
        return view('staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designation = Designation::orderBy('title')->get();
        return view('staff.create', compact('designation'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_staff',
            'password' => 'required|string|min:8',
            'designation' => 'required',
        ]);
    
        try {
            $staff = new Staff();
            $staff->name = $request->name;    
            $staff->email = $request->email;
            $staff->password = bcrypt($request->password);
            $staff->created_by = Auth::id();
            $staff->designation_id = $request->designation;
            $staff->save();
    
            return redirect()->route('staffs.index')->with('success', 'Staff Created Successfully');
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
        $staffs = Staff::find($id);
        $designation = Designation::orderBy('title')->get();
        return view('staff.edit', compact('staffs', 'designation'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:tbl_staff,email,'.$id,
            'password' => 'nullable|string|min:8',
            'designation' => 'required',
        ]);
    
        try {
           
            $staff = Staff::findOrFail($id);
            $staff->name = $request->name;
            $staff->email = $request->email;
            if($request->filled('password')){
                $staff->password = bcrypt($request->password);
            }
            $staff->designation_id = $request->designation;
            $staff->save();
    
            return redirect()->route('staffs.index')->with('success', 'Staff Updated Successfully');
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
        try {
            $staff = Staff::findOrFail($id);
            $staff->forceDelete();
            
            return response()->json(['success' => 'Staff Deleted Successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function importstaff()
    {
        return view('staff.import');        
    }

    public function import(Request $request)
    {
        \Log::info('Import request received');

        $request->validate([
            'importstaff' => 'required|mimes:xlsx,xls,csv,txt',
        ], [], [
            'importstaff' => 'Import File'
        ]);

        try {
            \Log::info('File validation passed.');
            $file = $request->file('importstaff');
            \Log::info('File received: ' );
           
            $import = new StaffImport();

            Excel::import($import, $file);

            $failures = $import->failures();

            if (count($failures) > 0) {
                \Log::warning('Import completed with failures.');
                return redirect()->back()->with('error', 'Some rows failed validation.')->with('failures', $failures);
            }

            \Log::info('Import completed successfully.');
            return redirect()->route('staffs.index')->with('success', ' Staffs has been imported successfully...!');
        } catch (\Exception $e) {
            \Log::error('Error during import: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Import failed.');
        }
    }

}
