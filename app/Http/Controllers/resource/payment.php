<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Stream;
use App\Models\Invoice as Invoices;
use App\Models\PaymentRequest;
use Numbers_Words;
class payment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $main_categories = Category::whereNull('parent_category')->with('children')->get();
        $stream = Stream::orderBy('stream_name')->get();
        $invoice = Invoices::with(['proposal','milestone','vendor.banckaccount','vendor.states', 'proposalro'])->where('id', $id)->first();
       // print_r($invoice->vendor->banckaccount);exit();

       //create payment request Id start

       $existingRequest = PaymentRequest::where('invoice_id', $invoice->id)->first();

       if (!$existingRequest) {
   
       // Generate unique payment_request_id
       
       $financialYear = $this->getShortFinancialYear();
            $prefix = $financialYear . '-PR-';
            // Retrieve the highest existing code
            $latestCode = PaymentRequest::where('payment_request_id', 'like', $prefix . '%')
                ->orderByRaw('CAST(SUBSTRING(payment_request_id, LENGTH(?) + 1) AS UNSIGNED) DESC', [$prefix])
                ->pluck('payment_request_id')
                ->first();

            $latestNumber = 0;
            if ($latestCode) {
                $latestNumber = (int)substr($latestCode, strlen($prefix));
            }

            $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT); // Adjust to 3 digits
            $paymentRequestId  = $prefix . $nextNumber;
   
       // Create a new PaymentRequest record
       $paymentRequest = PaymentRequest::create([
           'payment_request_id' => $paymentRequestId,
           'invoice_id' => $invoice->id,
           
       ]);
    }

       //create payment request Id End

       $number = $invoice->milestone->milestone_total_amount;
       $numbersWords = new Numbers_Words();
       $amounwords = $numbersWords->toWords($number);

       $paymentrequest = PaymentRequest::where('invoice_id', $invoice->id)->first();
        return view('payment.create',compact('main_categories','stream','invoice','amounwords','paymentrequest'));
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
            'invoid' => 'required|exists:invoices,id',
            'pay_category' => 'required|exists:tbl_category,id',
            'stream' => 'required|exists:stream,id', 
        ]);

        try {

           
            $paymentrequest = PaymentRequest::where('invoice_id', $request->invoid)->first();
            $paymentrequest->stream_id  = $request->stream;
            $paymentrequest->category_id  = $request->pay_category;
            $paymentrequest->payment_status  = 'completed';
              $paymentrequest->save();

              $invoice = Invoices::findOrFail($request->invoid);
              $invoice->invoice_status  = 1;
              $invoice->save();

            return redirect()->route('invoice.index')->with('success', 'Payment Request Submitted Successfully');
        } catch (\Exception $e) {
            
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
        return view('payment.show');
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

    public function updatepayment(){
        return view('payment.update');
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
