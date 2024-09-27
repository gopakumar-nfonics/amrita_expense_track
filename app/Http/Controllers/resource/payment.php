<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Stream;
use App\Models\Invoice as Invoices;
use App\Models\Proposal;
use App\Models\PaymentMilestone;
use App\Models\PaymentRequest;
use App\Models\Budget;
use App\Models\FinancialYear;
use Numbers_Words;
use App\Mail\InvoicePaymentInitiation;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

use Illuminate\Support\Facades\Mail;

class payment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payrequest = PaymentRequest::with(['invoice.milestone', 'invoice.vendor', 'invoice.proposalro', 'invoice.proposal'])->orderBy('id')->get();

        return view('payment.index', compact('payrequest'));
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
        $invoice = Invoices::with(['proposal', 'milestone', 'vendor.banckaccount', 'vendor.states', 'proposalro'])->where('id', $id)->first();
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
        return view('payment.create', compact('main_categories', 'stream', 'invoice', 'amounwords', 'paymentrequest'));
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
            'category' => 'required|exists:tbl_category,id',
            'programme' => 'required|exists:stream,id',
        ]);

        try {


            $paymentrequest = PaymentRequest::where('invoice_id', $request->invoid)->first();
            $paymentrequest->stream_id  = $request->programme;
            $paymentrequest->category_id  = $request->category;
            $paymentrequest->payment_status  = 'completed';
            $paymentrequest->save();

            $invoice = Invoices::findOrFail($request->invoid);
            $invoice->invoice_status  = 1;
            $invoice->save();

            $vendor = Vendor::where('id', $invoice->vendor_id)->first();
            $proposal = Proposal::where('id', $invoice->proposal_id)->first();
            $milestone = PaymentMilestone::where('id', $invoice->milestone_id)->first();

            $detailsproposal = [
                'name' => $vendor->vendor_name,
                'proposal_title' => $proposal->proposal_title,
                'milestone_title' => $milestone->milestone_title,

            ];

            $subject = $proposal->proposal_title . " " . $milestone->milestone_title . " Invoice Payment Initiation";

            Mail::to($vendor->email)->send(new InvoicePaymentInitiation($detailsproposal, $subject));

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

    public function updatepayment()
    {
        return view('payment.update');
    }

    public function getBudgetDetails(Request $request)
    {
        $categoryId = $request->input('category_id');

        $currentFinancialYear = FinancialYear::where('is_current', 1)->first();

        if (!$currentFinancialYear) {
            return response()->json([
                'error' => 'Current financial year not found'
            ], 404);
        }

        $category = Category::find($categoryId);

        $totalBudget = 0;
        $usedBudget = 0;

        $budget = Budget::where('category_id', $categoryId)
            ->where('financial_year_id', $currentFinancialYear->id)
            ->first();

        if ($budget) {
            $totalBudget = $budget->amount;
        } else {

            if ($category->parent_category) {
                $parentBudget = Budget::where('category_id', $category->parent_category)
                    ->where('financial_year_id', $currentFinancialYear->id)
                    ->first();

                if ($parentBudget) {
                    $totalBudget = $parentBudget->amount;
                }
            }
        }

        $usedBudget = PaymentRequest::where('category_id', $categoryId)
        ->where('payment_status', 'completed')
        ->whereHas('invoice', function ($query) {
            $query->whereHas('milestone', function ($milestoneQuery) {
                $milestoneQuery->selectRaw('SUM(milestone_total_amount) as total');
            });
        })
        ->with('invoice.milestone')
        ->get()
        ->sum(function ($paymentRequest) {
            return $paymentRequest->invoice->milestone->milestone_total_amount;
        });

        $formattedTotalBudget = number_format($totalBudget, 2, '.', ',');
    $formattedUsedBudget = number_format($usedBudget, 2, '.', ',');

    return response()->json([
        'num_total_budget' => $formattedTotalBudget,
        'num_used_budget' => $formattedUsedBudget,
        'total_budget' => $totalBudget,
        'used_budget' => $usedBudget
    ]);
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

    public function savepaymentrequestPdf($id)
    {
        $proposal = Proposal::with('vendor', 'proposalro')->findOrFail($id);

        $numbersWords = new Numbers_Words();
        $amounwords = $numbersWords->toWords($proposal->proposal_total_cost);

        $pdfName = 'payment_request_' . $proposal->proposal_id. '.pdf';
    
        $pdfPath = public_path('storage/payment_request/' . $pdfName);

        // return view('reports.questionslip', $data);

        $pdf = PDF::loadView('payment.payment_request', compact('proposal', 'amounwords'))
           ->setPaper('a4', 'portrait');
        $pdf->save($pdfPath);
    }
}
