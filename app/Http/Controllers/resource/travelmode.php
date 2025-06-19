<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TravelMode as mode;
class travelmode extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $travelmodes = mode::with('parent')->orderBy('name')->get();
        return view('travelmode.index',compact('travelmodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $travelmodes = mode::where('parent_mode', NULL)->orderBy('name')->get();
        return view('travelmode.create', compact('travelmodes'));
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
            'name' => 'required|unique:travel_mode,name',
            'code' => 'required|unique:travel_mode,code',
        ]);
    
        try {
            $mode = new mode();
            $mode->name = $request->name;    
            $mode->code = $request->code;
            $mode->parent_mode = $request->parent_mode;
            $mode->save();
        
            return redirect()->route('travelmode.index')->with('success', 'Travel Mode Created Successfully');
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
        $modes = mode::find($id);
        $parent_modes = mode::where('id', '!=', $id)->where('parent_mode', NULL)->orderBy('name')->get();
        return view('travelmode.edit',compact('modes','parent_modes'));
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
            'name' => 'required|unique:travel_mode,name,'.$id,
            'code' => 'required|unique:travel_mode,code,'.$id,
        ]);
    
        try {
            $mode = mode::findOrFail($id);
            $mode->name = $request->name;    
            $mode->code = $request->code;
            $mode->parent_mode = $request->parent_mode;
            $mode->save();
        
            return redirect()->route('travelmode.index')->with('success', 'Travel Mode Created Successfully');
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
            $mode = mode::with(['designations', 'children.designations'])->findOrFail($id);

            if ($mode->designations->count() > 0) {
                return response()->json(['error' => 'Cannot delete: Travel Mode is assigned to designations.']);
            }

            // Check if any child mode is assigned
            foreach ($mode->children as $child) {
                if ($child->designations->count() > 0) {
                    return response()->json(['error' => 'Cannot delete: Child travel modes are assigned to designations.']);
                }
            }

            $mode->forceDelete();
            
            return response()->json(['success' => 'Travel Mode Deleted Successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
