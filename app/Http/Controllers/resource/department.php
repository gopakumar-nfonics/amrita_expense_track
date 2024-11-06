<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department as departments;
use App\Models\Campus;
use Illuminate\Validation\Rule;
use App\Models\Stream;

class department extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments=departments::with('campus')->orderByDesc('id')->get();
        return view('department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campus=Campus::orderBy('campus_name')->get();
        return view('department.create', compact('campus'));
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
            'name' => [
                'required',
                Rule::unique('department', 'department_name')->where(function ($query) use ($request) {
                    return $query->where('campus_id', $request->campus);
                }),
            ],
            'code' => [
                'required',
                Rule::unique('department', 'department_code')->where(function ($query) use ($request) {
                    return $query->where('campus_id', $request->campus);
                }),
            ],
            'campus' => 'required',
            'address' => 'required',
        ]);
    
            try {
                $department = new departments();
                $department->department_name = $request->name;
                $department->department_code = $request->code;
                $department->campus_id = $request->campus;
                $department->address = $request->address;
                $department->save();
        
                return redirect()->route('department.index')->with('success', 'Department Created Successfully');
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
        $campus=Campus::orderBy('campus_name')->get();
        $department = departments::find($id);
        return view('department.edit', compact('campus','department'));
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
                Rule::unique('department', 'department_name')
                    ->ignore($id) // Exclude the current record if updating
                    ->where(function ($query) use ($request) {
                        return $query->where('campus_id', $request->campus);
                    }),
            ],
            'code' => [
                'required',
                Rule::unique('department', 'department_code')
                    ->ignore($id) // Exclude the current record if updating
                    ->where(function ($query) use ($request) {
                        return $query->where('campus_id', $request->campus);
                    }),
            ],
            'campus' => 'required',
            'address' => 'required',
        ]);
    
            try {
                $department = departments::findOrFail($id);
                $department->department_name = $request->name;
                $department->department_code = $request->code;
                $department->campus_id = $request->campus;
                $department->address = $request->address;
                $department->save();
        
                return redirect()->route('department.index')->with('success', 'Department Updated Successfully');
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

    public function deleteDepartment(Request $request)
    {

        $department = departments::findOrFail($request->input('id'));

        if (!$department) {
        return response()->json(['error' => 'department not found.'], 404);
        }

        $streamCount = Stream::where('department_id', $department->id)->count();

        if ($streamCount > 0) {
            return response()->json(['error' => 'Cannot delete department associated with a programme.']);
        }

        $department->forceDelete(); 
        return response()->json(['success' => 'The department has been deleted!']);
        
    }
}
