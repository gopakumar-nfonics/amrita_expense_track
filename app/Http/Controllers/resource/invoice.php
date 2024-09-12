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
use Numbers_Words;

class invoice extends Controller
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
            $invoices = Invoices::with(['milestone', 'vendor', 'proposalro'])->where('vendor_id', $vendor->id)->orderBy('id')->get();
            
            }else{
              $invoices = Invoices::with(['milestone', 'vendor', 'proposalro'])->orderBy('id')->get();
            }

        return view('invoice.index',compact('invoices'));
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
        return view('invoice.create', compact('proposal'));
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


            $financialYear = $this->getShortFinancialYear();
            $prefix = $financialYear . '-IV-';
            // Retrieve the highest existing code
            $latestCode = Invoices::where('invoice_id', 'like', $prefix . '%')
                ->orderByRaw('CAST(SUBSTRING(invoice_id, LENGTH(?) + 1) AS UNSIGNED) DESC', [$prefix])
                ->pluck('invoice_id')
                ->first();

            $latestNumber = 0;
            if ($latestCode) {
                $latestNumber = (int)substr($latestCode, strlen($prefix));
            }

            $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT); // Adjust to 3 digits
            $invoice_id  = $prefix . $nextNumber;

            $invoices = new Invoices();
            $invoices->invoice_id  = $invoice_id;
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
            print_r($e->getMessage());
            exit();
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
        $invoice = Invoices::with(['proposal','milestone','vendor.banckaccount','vendor.states', 'proposalro'])->where('id', $id)->first();
        $number = $invoice->milestone->milestone_total_amount;
       $numbersWords = new Numbers_Words();
       $amounwords = $numbersWords->toWords($number);
        return view('invoice.show',compact('invoice','amounwords'));
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
}
