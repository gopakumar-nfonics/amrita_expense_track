<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stream as streams;
use App\Models\Department;
use App\Models\Campus;
use App\Models\Proposal;

class stream extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streams=streams::with('campus','department')->orderByDesc('id')->get();
        return view('stream.index', compact('streams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campus=campus::orderBy('campus_name')->get();
        $department=Department::orderBy('department_name')->get();
        return view('stream.create',compact('department','campus'));
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
            'code' => 'required|unique:stream,stream_code',
            'campus' => 'required',
            'billingaddress' => 'required',
        ]);
    
            try {
                $stream = new streams();
                $stream->stream_name = $request->name;
                $stream->stream_code = $request->code;
                $stream->campus_id = $request->campus;
                $stream->department_id = $request->department;
                $stream->billing_address = $request->billingaddress;
                $stream->save();
        
                return redirect()->route('stream.index')->with('success', 'Programme Created Successfully');
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
        $campus=campus::orderBy('campus_name')->get();
        $stream = streams::find($id);
        $department = Department::where('campus_id', $stream->campus_id)->get();
        
        return view('stream.edit',compact('department','campus','stream'));
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
            'name' => 'required',
            'code' => 'required|unique:stream,stream_code,'.$id,
            'campus' => 'required',
            'billingaddress' => 'required',
        ]);
    
            try {
                $stream = streams::findOrFail($id);
                $stream->stream_name = $request->name;
                $stream->stream_code = $request->code;
                $stream->campus_id = $request->campus;
                $stream->department_id = $request->department;
                $stream->billing_address = $request->billingaddress;
                $stream->save();
        
                return redirect()->route('stream.index')->with('success', 'Programme Updated Successfully');
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

    public function deleteProgramme(Request $request)
    {

        $stream = streams::findOrFail($request->input('id'));

        if (!$stream) {
        return response()->json(['error' => 'programme not found.'], 404);
        }

        $proposalCount = Proposal::where('programme_id', $stream->id)->count();

        if ($proposalCount > 0) {
            return response()->json(['error' => 'Cannot delete programme associated with a proposal.']);
        }

        $stream->forceDelete(); 
        return response()->json(['success' => 'The programme has been deleted!']);
        
    }
}
