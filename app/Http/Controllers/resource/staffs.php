<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

class staffs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::orderByDesc('id') ->get(); 
        return view('staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.create');
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
        ]);
    
        try {
            $staff = new Staff();
            $staff->name = $request->name;    
            $staff->email = $request->email;
            $staff->password = bcrypt($request->password);
            $staff->created_by = Auth::id();
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
        return view('staff.edit', compact('staffs'));
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
        ]);
    
        try {
           
            $staff = Staff::findOrFail($id);
            $staff->name = $request->name;
            $staff->email = $request->email;
            if($request->filled('password')){
                $staff->password = bcrypt($request->password);
            }
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
}
