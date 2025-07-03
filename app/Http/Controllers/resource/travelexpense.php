<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TravelExpense as TravelExpenseModel;
use App\Models\Stream;
use App\Models\Category;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\Crypt;
use Numbers_Words;

class travelexpense extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = TravelExpenseModel::with(['staff','sourceCity', 'destinationCity'])
                                   ->orderBy('id', 'desc')
                                   ->get();
        $programmes = Stream::orderBy('stream_name')->get();
        $main_categories = Category::whereNull('parent_category')
                        ->with(['children', 'budgets'])
                        ->get();

        $years = FinancialYear::orderBy('year')->get();
        return view('travelexpense.index', compact('expenses', 'programmes', 'main_categories', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $expense = TravelExpenseModel::with(['staff','sourceCity', 'destinationCity', 'category', 'stream', 'details'])->find($id);

        $totalAmount = $expense->amount;
        $advanceAmount = $expense->advance_amount;
        $numbersWords = new Numbers_Words();
        $total_words = $numbersWords->toWords($totalAmount);
        $advance_words = $numbersWords->toWords($advanceAmount);

        $settleAmount = $totalAmount - $advanceAmount;
        $settle_words = $numbersWords->toWords($settleAmount);

        return view('travelexpense.show',compact('expense', 'total_words', 'advance_words', 'settleAmount', 'settle_words'));
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

    public function approve_advance(Request $request)
    {
        $request->validate([
            'expense_id'  => 'required|exists:tbl_travel_expenses,id',
            'year'        => 'required',
            'category'    => 'required',
            'programme'   => 'required',
            'associated'  => 'required',
            'approved_amount' => 'required',
        ]);
    
        $expense = TravelExpenseModel::findOrFail($request->expense_id);
    
        $expense->update([
            'financial_year_id'  => $request->year,
            'category_id'        => $request->category,
            'stream_id'          => $request->programme,
            'advance_amount'     => $request->approved_amount,
            'associated'         => $request->associated,
            'status'             => 'advance_received',
        ]);
    
        return redirect()->back()->with('success', 'Advance request approved successfully.');
    }

    public function settle_expense(Request $request)
    {
           
        $expense = TravelExpenseModel::findOrFail($request->expense_id);
    
        $expense->status = 'expense_settled';
        $expense->final_amount = $request->settle_amount;
        $expense->save();
    
        return response()->json([
            'message' => 'Expense Settled Successfully.',
            'redirect' => route('travelexpense.index')
        ]);
    }

}
