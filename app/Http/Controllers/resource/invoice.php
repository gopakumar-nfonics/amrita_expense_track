<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Proposal;
use App\Models\PaymentMilestone;
use App\Models\ProposalRo;
use App\Models\Invoice as Invoices;
use Illuminate\Support\Facades\Auth;

class invoice extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::user()->id;
        $vendor = Vendor::where('user_id', $userId)->first();
        $proposal = Proposal::where('vendor_id', $vendor->id)->where('proposal_status', 1)->orderBy('id')->get();
        return view('invoice.create',compact('proposal'));
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
            'proposal' => 'required|exists:proposal,id',
            'milestone' => 'required|exists:payment_milestones,id',
            'invoice_number' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048', // Adjust file validation as needed
        ]);

        try {
              
            $userId = Auth::user()->id;
           $vendor = Vendor::where('user_id', $userId)->first();

            $invoices = new Invoices();
            $invoices->vendor_id  = $vendor->id;
            $invoices->proposal_id  = $request->proposal;
            $invoices->milestone_id = $request->milestone;
            $invoices->invoice_number = $request->invoice_number;
            $invoices->invoice_date  = $request->invoice_date;
            $invoices->invoice_notes  = $request->invoice_note;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('invoice', 'public'); // Store file in 'public/proposals'
                $invoices->invoice_file = $path; // Save file path to the Proposal model
            }
    
            $invoices->save();
    
            return redirect()->route('invoice.index')->with('success', 'Invoice Created Successfully');
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
        return view('invoice.show');
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
