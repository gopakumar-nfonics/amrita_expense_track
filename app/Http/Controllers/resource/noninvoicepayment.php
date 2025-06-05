<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FinancialYear;
use App\Models\Stream;
use App\Models\NoninvoicePayment as noninvoicepayments;

class noninvoicepayment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = noninvoicepayments::with(['category', 'year', 'stream'])->get();
        return view('noninvoicepayment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $main_categories = Category::whereNull('parent_category')
                                ->with(['children', 'budgets']) 
                                ->get();
        $financialyears = FinancialYear::get();
        $streams = Stream::orderBy('stream_name')->get();
        
        return view('noninvoicepayment.create', compact('main_categories', 'financialyears', 'streams'));
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
            'title' => 'required',
            'category' => 'required|exists:tbl_category,id',
            'program' => 'required|exists:stream,id',
            'year' => 'required',
            'noninvoice_date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        try {

            $lastPayment = noninvoicepayments::where('reference_id', 'LIKE', 'NIP-%')
                            ->orderByDesc('id')
                            ->first();
            if ($lastPayment && preg_match('/NIP-(\d+)/', $lastPayment->reference_id, $matches)) {
                $lastNumber = (int) $matches[1];
            } else {
                $lastNumber = 0;
            }
            $newReferenceId = 'NIP-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

            $noninvoicepayments = new noninvoicepayments();
            $noninvoicepayments->title  = $request->title;
            $noninvoicepayments->reference_id   = $newReferenceId;
            $noninvoicepayments->category_id  = $request->category;
            $noninvoicepayments->stream_id  = $request->program;
            $noninvoicepayments->financial_year_id = $request->year;
            $noninvoicepayments->payment_status = 'completed';
            $noninvoicepayments->amount = $request->amount;
            $noninvoicepayments->transaction_date = $request->noninvoice_date;
            if ($request->has('utr_number')) {
                    $noninvoicepayments->utr_number = $request->utr_number;
            }
            if ($request->has('remarks')) {
                    $noninvoicepayments->remarks = $request->remarks;
            }
            $noninvoicepayments->save();

            return redirect()->route('noninvoicepayment.index')->with('success', 'Non Invoice Payment Submitted Successfully');
        } catch (\Exception $e) {
            // print_r($e->getMessage());exit();
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
        $noninvoicepayments = noninvoicepayments::find($id);
        $main_categories = Category::whereNull('parent_category')
                                ->with(['children', 'budgets']) 
                                ->get();
        $financialyears = FinancialYear::get();
        $streams = Stream::orderBy('stream_name')->get();

        return view('noninvoicepayment.edit', compact('noninvoicepayments', 'main_categories', 'financialyears', 'streams'));
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
            'title' => 'required',
            'category' => 'required|exists:tbl_category,id',
            'program' => 'required|exists:stream,id',
            'year' => 'required',
            'noninvoice_date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        try {

            $noninvoicepayments = noninvoicepayments::findOrFail($id);
            $noninvoicepayments->title  = $request->title;
            $noninvoicepayments->category_id  = $request->category;
            $noninvoicepayments->stream_id  = $request->program;
            $noninvoicepayments->financial_year_id = $request->year;
            $noninvoicepayments->payment_status = 'completed';
            $noninvoicepayments->amount = $request->amount;
            $noninvoicepayments->transaction_date = $request->noninvoice_date;
            if ($request->has('utr_number')) {
                    $noninvoicepayments->utr_number = $request->utr_number;
            }
            if ($request->has('remarks')) {
                    $noninvoicepayments->remarks = $request->remarks;
            }
            $noninvoicepayments->save();

            return redirect()->route('noninvoicepayment.index')->with('success', 'Non Invoice Payment Updated Successfully');
        } catch (\Exception $e) {
            // print_r($e->getMessage());exit();
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
}
