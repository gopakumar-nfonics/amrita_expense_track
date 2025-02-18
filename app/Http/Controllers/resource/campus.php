<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department as departments;
use App\Models\Campus as cmps;

class campus extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campus=cmps::orderBy('campus_name')->get();
        return view('campus.index', compact('campus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campus=cmps::orderBy('campus_name')->get();
        return view('campus.create', compact('campus'));
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
            'name' => 'required|unique:campus,campus_name',
            'code' => 'required|unique:campus,campus_code',
            'address' => 'required',
        ]);

        try {
            $campus = new cmps();
            $campus->campus_name = $request->name;
            $campus->campus_code = $request->code;
            $campus->address = $request->address;
            $campus->save();
    
            return redirect()->route('campus.index')->with('success', 'Campus Created Successfully');
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
        $campus=cmps::find($id);
        return view('campus.edit', compact('campus'));
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
            'name' => 'required|unique:campus,campus_name,'.$id,
            'code' => 'required|unique:campus,campus_code,'.$id,
            'address' => 'required',
        ]);

        try {
            $campus = cmps::findOrFail($id);;
            $campus->campus_name = $request->name;
            $campus->campus_code = $request->code;
            $campus->address = $request->address;
            $campus->save();
    
            return redirect()->route('campus.index')->with('success', 'Campus Updated Successfully');
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

    public function deleteCampus(Request $request)
    {

        $campus = cmps::findOrFail($request->input('id'));

        if (!$campus) {
        return response()->json(['error' => 'campus not found.'], 404);
        }

        $departmentsCount = departments::where('campus_id', $campus->id)->count();

        if ($departmentsCount > 0) {
            return response()->json(['error' => 'Cannot delete campus associated with a department.']);
        }

        $campus->forceDelete(); 
        return response()->json(['success' => 'The Campus has been deleted!']);
        
    }

    public function getdepartments($campusId)
    {
        // Fetch departments based on the campus ID
        $departments = departments::where('campus_id', $campusId)->get();

        // Return the departments as JSON
        return response()->json($departments);
    }
}
