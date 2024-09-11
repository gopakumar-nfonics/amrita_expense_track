<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Stream;
use App\Models\Proposal;
use App\Models\PaymentMilestone;
use Numbers_Words;

use Illuminate\Support\Facades\Auth;

class lead extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $vendor = Vendor::where('user_id', $userId)->first();
        $proposal = Proposal::where('vendor_id', $vendor->id)->orderBy('id')->get();
        return view('lead.index',compact('proposal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_categories = Category::whereNull('parent_category')->with('children')->get();
        $vendors = Vendor::orderBy('vendor_name')->get();
        $stream = Stream::orderBy('stream_name')->get();
        return view('lead.create',compact('main_categories','vendors','stream'));
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
            'ptitle' => 'required|string|max:255',
            'description' => 'required|string',
            'order_cost' => 'required|numeric|min:0',
            'order_gst' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'invoice_due_date' => 'required|date',
            'name.*' => 'required|string',
            'mdate.*' => 'required|date',
            'amount.*' => 'required|numeric',
            'gst.*' => 'required|numeric',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Add file validation

        ]);
    
        try {

            $prefix = '2324-PL-';
    // Retrieve the highest existing code
    $latestCode = Proposal::where('proposal_id', 'like', $prefix . '%')
        ->orderByRaw('CAST(SUBSTRING(proposal_id, LENGTH(?) + 1) AS UNSIGNED) DESC', [$prefix])
        ->pluck('proposal_id')
        ->first();

    $latestNumber = 0;
    if ($latestCode) {
        $latestNumber = (int)substr($latestCode, strlen($prefix));
    }

    $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT); // Adjust to 3 digits
    $proposal_id  = $prefix . $nextNumber;

    $userId = Auth::user()->id;
    $vendor = Vendor::where('user_id', $userId)->first();



            $proposal = new Proposal();
            $proposal->proposal_id  = $proposal_id;
            $proposal->proposal_date = $request->invoice_due_date;
            $proposal->proposal_title = $request->ptitle;
            $proposal->proposal_description = $request->description;
            $proposal->proposal_cost  = $request->order_cost;
            $proposal->proposal_gst  = $request->order_gst;
            $proposal->proposal_total_cost  = $request->total_cost;
            $proposal->vendor_id  = $vendor->id;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('proposals', 'public'); // Store file in 'public/proposals'
                $proposal->file_path = $path; // Save file path to the Proposal model
            }
    
            $proposal->save();
            
            $proposal->save();

            $milestones = [];
            foreach ($request->input('name') as $index => $name) {
                $milestones[] = [
                    'proposal_id' => $proposal->id,
                    'milestone_title' => $name,
                    'milestone_date' => $request->input('mdate')[$index],
                    'milestone_amount' => $request->input('amount')[$index],
                    'milestone_gst' => $request->input('gst')[$index], // Adjust if you have GST calculations
                    'milestone_total_amount' => $request->input('amount')[$index] * (1 + ($request->input('gst')[$index] / 100)), // Example GST calculation
                   
                ];
            }
        
            // Insert data into the database
             PaymentMilestone::insert($milestones);
    
            return redirect()->route('lead.index')->with('success', 'Proposal Created Successfully');
        } catch (\Exception $e) {
            // Log the exception message
            print_r($e->getMessage());exit();
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
        $proposal = Proposal::with(['paymentMilestones', 'vendor'])->find($id);
        
        $number = $proposal->proposal_total_cost;
        $numbersWords = new Numbers_Words();
        $amounwords = $numbersWords->toWords($number);

        return view('lead.show',compact('proposal','amounwords'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
