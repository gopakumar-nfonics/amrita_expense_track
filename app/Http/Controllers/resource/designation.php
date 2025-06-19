<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation as designations;
use App\Models\Staff;
use App\Models\TravelMode;

class designation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designations = designations::with('travelModes')->orderByDesc('id')->get(); 
        return view('designation.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $travelModes = TravelMode::with('children')->whereNull('parent_mode')->orderBy('name')->get();
        return view('designation.create', compact('travelModes'));
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
            'title' => 'required|string|max:255|unique:designation,title',
            'code' => 'required|string|max:255|unique:designation,code',
        ]);
    
        try {
            $designation = new designations();
            $designation->title = $request->title;    
            $designation->code = $request->code;
            $designation->save();

            if ($request->filled('travel_mode')) {
                $designation->travelModes()->attach($request->travel_mode);
            }
    
            return redirect()->route('designation.index')->with('success', 'Designation Created Successfully');
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
        $designations = designations::with('travelModes')->findOrFail($id);
        $travelModes = TravelMode::with('children')->whereNull('parent_mode')->orderBy('name')->get();
        return view('designation.edit', compact('designations', 'travelModes'));
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
            'title' => 'required|string|max:255|unique:designation,title,'.$id,
            'code' => 'required|string|unique:designation,code,'.$id,
        ]);
    
        try {
           
            $designation = designations::findOrFail($id);
            $designation->title = $request->title;
            $designation->code = $request->code;
            $designation->save();

            // Sync travel modes
            $designation->travelModes()->sync($request->travel_mode ?? []);
    
            return redirect()->route('designation.index')->with('success', 'Designation Updated Successfully');
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
            $designation = designations::findOrFail($id);

            $staffCount = Staff::where('designation_id', $designation->id)->count();
        
            if ($staffCount > 0) {
                return response()->json(['error' => 'Cannot delete designation associated with a staff.']);
            }

            $designation->forceDelete();
            
            return response()->json(['success' => 'Designation Deleted Successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
