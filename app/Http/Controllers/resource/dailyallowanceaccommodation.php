<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Tier;
use App\Models\DailyAllowanceAccommodation as DAAModel;

class dailyallowanceaccommodation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = DAAModel::with(['designation', 'tier'])->orderBy('id', 'desc')->get();
        return view('dailyallowanceaccommodation.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations = Designation::orderBy('title')->get();
        $tiers = Tier::orderBy('name')->get();
        return view('dailyallowanceaccommodation.create', compact('designations', 'tiers'));
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
            'designation' => 'required',
            'tier' => 'required',
            'allowance_amount' => 'required',
            'accommodation_amount' => 'required',
        ]);
    
        try {
            $allowance_accommodation = new DAAModel();
            $allowance_accommodation->designation_id = $request->designation;
            $allowance_accommodation->city_tier_id = $request->tier;    
            $allowance_accommodation->allowance_amount = $request->allowance_amount;
            $allowance_accommodation->accommodation_amount = $request->accommodation_amount;
            $allowance_accommodation->save();

            return redirect()->route('dailyallowanceaccommodation.index')->with('success', 'DA & Accommodation Created Successfully');
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
        $record = DAAModel::find($id);
        $designations = Designation::orderBy('title')->get();
        $tiers = Tier::orderBy('name')->get();
        return view('dailyallowanceaccommodation.edit', compact('record', 'designations', 'tiers'));
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
            'designation' => 'required',
            'tier' => 'required',
            'allowance_amount' => 'required',
            'accommodation_amount' => 'required',
        ]);
    
        try {
            $allowance_accommodation = DAAModel::findOrFail($id);
            $allowance_accommodation->designation_id = $request->designation;
            $allowance_accommodation->city_tier_id = $request->tier;    
            $allowance_accommodation->allowance_amount = $request->allowance_amount;
            $allowance_accommodation->accommodation_amount = $request->accommodation_amount;
            $allowance_accommodation->save();
    
            return redirect()->route('dailyallowanceaccommodation.index')->with('success', 'DA & Accommodation Updated Successfully');
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
            $allowance_accommodation = DAAModel::findOrFail($id);
            $allowance_accommodation->forceDelete();
            
            return response()->json(['success' => 'DA & Accommodation Deleted Successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getAvailableTiers($designationId)
    {
        $assignedTierIds = DAAModel::where('designation_id', $designationId)
                            ->pluck('city_tier_id');

        $availableTiers = Tier::whereNotIn('id', $assignedTierIds)->get();

        return response()->json($availableTiers);
    }

}
