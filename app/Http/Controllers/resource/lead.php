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
use App\Models\ProposalRo;
use App\Mail\ProposalSubmit;
use App\Mail\AdminProposalSubmit;
use App\Mail\ApproveVendorProposal;
use App\Mail\RejectVendorProposal;

use Barryvdh\DomPDF\Facade\Pdf as PDF;


use Illuminate\Support\Facades\Mail;

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
        if(Auth::user()->isvendor()){
        $userId = Auth::user()->id;
        $vendor = Vendor::where('user_id', $userId)->first();
        $proposal = Proposal::with(['proposalro', 'vendor'])->where('vendor_id', $vendor->id)->orderBy('id')->get();
        
        }else{
          $proposal = Proposal::with(['proposalro', 'vendor'])->orderBy('id')->get();
        }
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
            'total_cost' => 'required',
            'invoice_due_date' => 'required|date',
            'name.*' => 'required|string',
            'amount.*' => 'required|numeric',
            'gst.*' => 'required|numeric',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Add file validation

        ]);
    
        try {
              
            $financialYear = $this->getShortFinancialYear();
            $prefix = $financialYear.'-PL-';
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
            $proposal->proposal_total_cost  =  $request->order_cost * (1 + ($request->order_gst / 100));
            $proposal->vendor_id  = $vendor->id;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $customFilename = $proposal_id.'.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('proposals', $customFilename, 'public'); // Store file in 'public/proposals'
                $proposal->file_path = $path; // Save file path to the Proposal model
            }
    
            $proposal->save();
            

            $milestones = [];
            foreach ($request->input('name') as $index => $name) {
                $milestones[] = [
                    'proposal_id' => $proposal->id,
                    'milestone_title' => $name,
                    'milestone_amount' => $request->input('amount')[$index],
                    'milestone_gst' => $request->input('gst')[$index], // Adjust if you have GST calculations
                    'milestone_total_amount' => $request->input('amount')[$index] * (1 + ($request->input('gst')[$index] / 100)), // Example GST calculation
                   
                ];
            }
        
            // Insert data into the database
             PaymentMilestone::insert($milestones);

             $detailsproposal = [
                'name' => $vendor->vendor_name,
                'proposal_title' => $proposal->proposal_title,
                
            ];

            $subject = $proposal->proposal_title." Proposal Submission";

            Mail::to($vendor->email)->send(new ProposalSubmit($detailsproposal,$subject));

            $adminsubject ="Vendor Proposal Submission - Review and Approval Required";
            $adminemail = env('CONTACT_MAIL');
            Mail::to($adminemail)->send(new AdminProposalSubmit($detailsproposal,$adminsubject));

    
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
        $proposal = Proposal::with(['paymentMilestones', 'vendor.states'])->find($id);

       
        
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
        $proposal = Proposal::with(['paymentMilestones'])->find($id);
        if($proposal->proposal_status == 0){
        return view('lead.edit', compact('proposal'));
        }
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
            'ptitle' => 'required|string|max:255',
            'description' => 'required|string',
            'order_cost' => 'required|numeric|min:0',
            'order_gst' => 'required|numeric|min:0',
            'total_cost' => 'required',
            'invoice_due_date' => 'required|date',
            'name.*' => 'required|string',
            'amount.*' => 'required|numeric',
            'gst.*' => 'required|numeric',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Add file validation

        ]);
    
        try {
              
           

    $userId = Auth::user()->id;
    $vendor = Vendor::where('user_id', $userId)->first();



            $proposal = Proposal::findOrFail($id);

            $proposal->proposal_date = $request->invoice_due_date;
            $proposal->proposal_title = $request->ptitle;
            $proposal->proposal_description = $request->description;
            $proposal->proposal_cost  = $request->order_cost;
            $proposal->proposal_gst  = $request->order_gst;
            $proposal->proposal_total_cost  =  $request->order_cost * (1 + ($request->order_gst / 100));
            $proposal->vendor_id  = $vendor->id;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $customFilename = $proposal->proposal_id.'.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('proposals', $customFilename, 'public'); // Store file in 'public/proposals'
                $proposal->file_path = $path; // Save file path to the Proposal model
            }
    
            $proposal->save();
            
            PaymentMilestone::where('proposal_id', $proposal->id)->delete();

            $milestones = [];
            foreach ($request->input('name') as $index => $name) {
                $milestones[] = [
                    'proposal_id' => $proposal->id,
                    'milestone_title' => $name,
                    'milestone_amount' => $request->input('amount')[$index],
                    'milestone_gst' => $request->input('gst')[$index], // Adjust if you have GST calculations
                    'milestone_total_amount' => $request->input('amount')[$index] * (1 + ($request->input('gst')[$index] / 100)), // Example GST calculation
                   
                ];
            }
        
            // Insert data into the database
             PaymentMilestone::insert($milestones);

            
            return redirect()->route('lead.index')->with('success', 'Proposal Updated Successfully');
        } catch (\Exception $e) {
            // Log the exception message
            print_r($e->getMessage());exit();
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

    public function getShortFinancialYear()
    {
        $currentDate = new \DateTime();
        $currentYear = (int)$currentDate->format('Y');
        $currentMonth = (int)$currentDate->format('m');

        // Define the start month of the financial year
        $financialYearStartMonth = 4; // April

        if ($currentMonth >= $financialYearStartMonth) {
            // If current month is from April onwards, the financial year is current year to next year
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        } else {
            // If current month is before April, the financial year is previous year to current year
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        }

        // Extract the last two digits of each year and concatenate
        $startYearShort = substr($startYear, -2);
        $endYearShort = substr($endYear, -2);

        return "{$startYearShort}{$endYearShort}";
    }

    public function approve(Request $request)
    {
        $status = $request->input('status');

        if($status == 'rejected'){

            $proposal = Proposal::findOrFail($request->input('id'));
        if (!$proposal) {
        return response()->json(['error' => 'Proposal not found.'], 404);
        }
        $proposal->proposal_status = 2;
        $proposal->save();

        $vendor = Vendor::where('id', $proposal->vendor_id)->first();


            $detailsproposal = [
                'name' => $vendor->vendor_name,
                'proposal_title' => $proposal->proposal_title,
                
            ];

            $subject = $proposal->proposal_title." Proposal Rejected";

            Mail::to($vendor->email)->send(new RejectVendorProposal($detailsproposal,$subject));

        return response()->json(['success' => 'The Proposal has been rejected!']);


        }
        
        else{

        $currentDate = new \DateTime();
        $currentMonth = $currentDate->format('m'); 
        $currentYear = $currentDate->format('y');

        $proposal = Proposal::findOrFail($request->input('id'));
        if (!$proposal) {
        return response()->json(['error' => 'Proposal not found.'], 404);
        }
        $proposal->proposal_status = 1;
        $proposal->save();

        $financialYear = $this->getShortFinancialYear();
            $prefix = 'AVV-'.$currentMonth.$currentYear.'-RO-';
    // Retrieve the highest existing code
    $latestCode = ProposalRo::where('proposal_ro', 'like', $prefix . '%')
        ->orderByRaw('CAST(SUBSTRING(proposal_ro, LENGTH(?) + 1) AS UNSIGNED) DESC', [$prefix])
        ->pluck('proposal_ro')
        ->first();

    $latestNumber = 0;
    if ($latestCode) {
        $latestNumber = (int)substr($latestCode, strlen($prefix));
    }

    $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT); // Adjust to 3 digits
    $proposal_ro  = $prefix . $nextNumber;


            $proposalro = new ProposalRo();
            $proposalro->proposal_id    = $request->input('id');
            $proposalro->proposal_ro = $proposal_ro;
            $proposalro->save();


            $this->saveReleaseOrderAsPdf($request->input('id'));


            $vendor = Vendor::where('id', $proposal->vendor_id)->first();


            $releaseorder = 'Release_Order_' . $proposal->proposal_id . '.pdf';
            $releaseorder = 'release_orders/' . $releaseorder;
            $releaseorderUrl = asset('storage/' . $releaseorder);


            $detailsproposal = [
                'name' => $vendor->vendor_name,
                'proposal_title' => $proposal->proposal_title,
                'releaseorderUrl'=> $releaseorderUrl,
                
            ];

            $subject = $proposal->proposal_title." Proposal Approval and Release Order";

            Mail::to($vendor->email)->send(new ApproveVendorProposal($detailsproposal,$subject));

        return response()->json(['success' => 'The Proposal has been approved!']);

        }
        
    }
    
    public function getMilestones($proposal_id)
    {
        // Fetch milestones based on the proposal ID
        $milestones = PaymentMilestone::where('proposal_id', $proposal_id)->get();

        $proposalRo = ProposalRo::where('proposal_id', $proposal_id)->first();

        // Return milestones as JSON
        return response()->json([
            'milestones' => $milestones,
            'proposalRo' => $proposalRo,
        ]);
    }

    public function getMilestonesdetails($milestone_id)
    {
        // Fetch milestones based on the proposal ID
        $milestones = PaymentMilestone::where('id', $milestone_id)->first();

       

        // Return milestones as JSON
        return response()->json($milestones);
    }

    public function ro($id)
    {
        $proposal = Proposal::with(['paymentMilestones', 'vendor.states','proposalro'])->find($id);

       
        
        $number = $proposal->proposal_total_cost;
        $numbersWords = new Numbers_Words();
        $amounwords = $numbersWords->toWords($number);

        return view('lead.roshow',compact('proposal','amounwords'));
    }

    public function saveReleaseOrderAsPdf($id)
    {
        $proposal = Proposal::with('vendor', 'proposalro')->findOrFail($id);

        $numbersWords = new Numbers_Words();
        $amounwords = $numbersWords->toWords($proposal->proposal_total_cost);

        $pdfName = 'Release_Order_' . $proposal->proposal_id. '.pdf';
    
        $pdfPath = public_path('storage/release_orders/' . $pdfName);

        // return view('reports.questionslip', $data);

        $pdf = PDF::loadView('lead.release_order', compact('proposal', 'amounwords'))
           ->setPaper('a4', 'portrait');
        $pdf->save($pdfPath);
    }
    
}
