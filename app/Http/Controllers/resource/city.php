<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tier;
use App\Models\City as CityModel;
use App\Models\State;

class city extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = CityModel::with(['tier', 'state'])->orderBy('name')->get();
        return view('city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tiers = Tier::orderBy('name')->get();
        $states = State::orderBy('name')->get();
        return view('city.create', compact('tiers', 'states'));
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
            'state' => 'required',
            'name' => 'required|string|max:255|unique:city,name',
            'code' => 'required|string|max:255|unique:city,code',
            'tier' => 'required',
        ]);
    
        try {
            $city = new CityModel();
            $city->state_id = $request->state;
            $city->name = $request->name;    
            $city->code = $request->code;
            $city->tier_id = $request->tier;
            $city->save();

            return redirect()->route('city.index')->with('success', 'City Created Successfully');
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
        $city = cityModel::find($id);
        $tiers = Tier::orderBy('name')->get();
        $states = State::orderBy('name')->get();
        return view('city.edit', compact('city', 'tiers', 'states'));
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
            'state' => 'required',
            'name' => 'required|string|max:255|unique:city,name,'.$id,
            'code' => 'required|string|max:255|unique:city,code,'.$id,
            'tier' => 'required',
        ]);
    
        try {
           
            $city = cityModel::findOrFail($id);
            $city->state_id = $request->state;
            $city->name = $request->name;
            $city->code = $request->code;
            $city->tier_id = $request->tier;
            $city->save();
    
            return redirect()->route('city.index')->with('success', 'City Updated Successfully');
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
            $city = cityModel::findOrFail($id);
            $city->forceDelete();
            
            return response()->json(['success' => 'City Deleted Successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
