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
use Carbon\Carbon;

class payment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       
        $payrequest = PaymentRequest::with(['invoice.milestone', 'invoice.vendor', 'invoice.proposalro', 'invoice.proposal', 'category', 'category.parent', 'stream'])->orderByDesc('id')->get();

        return view('payment.index', compact('payrequest'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $categories = Category::whereNull('parent_category')
    ->with(['children', 'budgets']) // Eager load children and budgets
    ->get();

    $main_categories = $categories->filter(function ($category) {
        return $category->budgets->isNotEmpty(); // Categories with budgets
    });

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
            $paymentrequest->payment_status  = 'initiated';
            $paymentrequest->save();

            $invoice = Invoices::findOrFail($request->invoid);
            $invoice->invoice_status  = 2;
            $invoice->save();

            $vendor = Vendor::where('id', $invoice->vendor_id)->first();
            $proposal = Proposal::where('id', $invoice->proposal_id)->first();
            $milestone = PaymentMilestone::where('id', $invoice->milestone_id)->first();


            $this->savepaymentrequestPdf($request->invoid);



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

        $proposal_year =  $request->input('proposal_year');

        if ($proposal_year) {
            // If a specific proposal year is provided, use it
            $financialYear = FinancialYear::find($proposal_year);
        } else {

        // Get the current financial year
        $financialYear = FinancialYear::where('is_current', 1)->first();

        }

        if (!$financialYear) {
            return response()->json([
                'error' => 'Current financial year not found'
            ], 404);
        }

        // Find the selected category
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'error' => 'Category not found'
            ], 404);
        }

        $totalBudget = 0;
        $usedBudget = 0;

        // Get the budget for the selected category
        $budget = Budget::where('category_id', $categoryId)
            ->where('financial_year_id', $financialYear->id)
            ->first();

        if ($budget) {
            $totalBudget = $budget->amount;
        } else {
            // If no budget found for the selected category, check for parent category
            if ($category->parent_category) {
                $parentBudget = Budget::where('category_id', $category->parent_category)
                    ->where('financial_year_id', $financialYear->id)
                    ->first();

                if ($parentBudget) {
                    $totalBudget = $parentBudget->amount;
                }
            }
        }

        
        $usedBudget = PaymentRequest::where(function ($query) use ($category) {
           
            if ($category->parent_category) {
                
                $subCategoryIds = Category::where('parent_category', $category->parent_category)->pluck('id');

                $subCategoryIds->push($category->parent_category);
                $query->whereIn('category_id', $subCategoryIds);
            } else {
                
                $query->where('category_id', $category->id);
            }
        })
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


        // Format the results
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
        $invoice = Invoices::with(['proposal', 'milestone', 'vendor.banckaccount', 'vendor.states', 'proposalro', 'paymentRequests'])->where('id', $id)->first();
        $number = $invoice->milestone->milestone_total_amount;
        $numbersWords = new Numbers_Words();
        $amounwords = $numbersWords->toWords($number);

        $pdfName = 'PR_' . $invoice->paymentRequests->payment_request_id . '.pdf';

        $pdfPath = public_path('storage/payment_request/' . $pdfName);


        // return view('reports.questionslip', $data);

        $pdf = PDF::loadView('payment.payment_request', compact('invoice', 'amounwords'))
            ->setPaper('a4', 'portrait');
        $pdf->save($pdfPath);
    }

    public function updatePaymentStatus(Request $request)
    {
        // Validate the input fields
        $validated = $request->validate([
            'utrnumber' => 'required|string|max:255|unique:payment_request,utr_number',
            'transactiondate' => 'required|date',
        ]);

        // Update payment request in the database
        $paymentRequest = PaymentRequest::where('id', $request->reqid)->first();

        if ($paymentRequest) {
            $paymentRequest->utr_number = "P2".$request->utrnumber;
            $paymentRequest->transaction_date = $request->transactiondate;
            $paymentRequest->payment_status = 'completed';  // Example of status update
            $paymentRequest->save();

            $invoice = Invoices::where('id', $paymentRequest->invoice_id)->first();
            $vendor = Vendor::where('id', $invoice->vendor_id)->first();
            $proposal = Proposal::where('id', $invoice->proposal_id)->first();
            $milestone = PaymentMilestone::where('id', $invoice->milestone_id)->first();

            $invoice->invoice_status = 1;  // Example of status update
            $invoice->save();

            $detailsproposal = [
                'name' => $vendor->vendor_name,
                'proposal_title' => $proposal->proposal_title,
                'milestone_title' => $milestone->milestone_title,

            ];

            $subject = $proposal->proposal_title . " " . $milestone->milestone_title . " Invoice Payment Processed";

            Mail::to($vendor->email)->send(new InvoicePaymentInitiation($detailsproposal, $subject));

            return response()->json(['success' => 'Payment status updated successfully.']);
        }

        return response()->json(['error' => 'Payment request not found.']);
    }

    public function getPaymentDetails(Request $request)
{
    $reqid = $request->input('reqid');
    
    // Fetch the payment details (modify according to your database structure)
    $payment = PaymentRequest::where('id', $reqid)->first();

    if ($payment) {

        $utr_number = $payment->utr_number ?? null;
        $transaction_date = $payment->transaction_date ?? \Carbon\Carbon::now()->format('Y-m-d');
        
        return response()->json([
            'utr_number' => $utr_number,
            'transaction_date' => $transaction_date,
        ]);
    }

    return response()->json(['error' => 'Payment details not found'], 404);
}

}