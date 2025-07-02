<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TravelExpense as TravelExpenseModel;
use App\Models\Stream;
use App\Models\Category;
use App\Models\FinancialYear;

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
            'approved_amount' => 'required',
        ]);
    
        $expense = TravelExpenseModel::findOrFail($request->expense_id);
    
        $expense->update([
            'financial_year_id'  => $request->year,
            'category_id'        => $request->category,
            'stream_id'       => $request->programme,
            'status'             => 'advance_received',
            'final_amount'     => 0,
        ]);
    
        return redirect()->back()->with('success', 'Advance request approved successfully.');
    }

}
