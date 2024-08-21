<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category as Categories;
use App\Models\FinancialYear;
use App\Models\Budget as Budgets;
use Carbon\Carbon;

class budget extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budgets = Budgets::with('financialYear','category')->orderBy('id')->get();
        return view('budget.index',['budgets'=>$budgets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Categories::orderBy('category_name')->get();
        $financialyears = FinancialYear::get();
        return view('budget.create',compact('category','financialyears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'financialyear' => 'required',
        'category' => 'required',
        'amount' => 'required',
    ], [
        'financialyear.exists' => 'The selected financial year is invalid.',
        'category.exists' => 'The selected category is invalid.',
    ]);

    $amount = preg_replace('/[^\d.]/', '', $request->input('amount'));

    // Check for unique combination of financial_year_id and category_id
    $exists = Budgets::where('financial_year_id', $request->input('financialyear'))
                     ->where('category_id', $request->input('category'))
                     ->exists();

    if ($exists) {
        return redirect()->back()->withErrors([
            'category' => 'The combination of financial year and category already exists.'
        ])->withInput(); // Keep the old input
    }

    // Try to save the budget entry
    try {
        $budget = new Budgets();
        $budget->financial_year_id = $request->input('financialyear');    
        $budget->category_id = $request->input('category');
        $budget->amount = $amount;    
        $budget->notes = $request->input('notes');    
        $budget->save();

        return redirect()->route('budget.index')->with('success', 'Budget Allocated Successfully');
    } catch (\Exception $e) {
        // Log the exception message
        \Log::error('Error saving budget: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while saving the budget.')->withInput();
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
        $category = Categories::orderBy('category_name')->get();
        $financialyears = FinancialYear::get();
        $budget = Budgets::find($id);
        return view('budget.edit',compact('category','financialyears','budget'));
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
            'financialyear' => 'required',
            'category' => 'required',
            'amount' => 'required',
        ], [
            'financialyear.exists' => 'The selected financial year is invalid.',
            'category.exists' => 'The selected category is invalid.',
        ]);
    
        $amount = preg_replace('/[^\d.]/', '', $request->input('amount'));
    
        // Check for unique combination of financial_year_id and category_id
        $exists = Budgets::where('financial_year_id', $request->input('financialyear'))
                         ->where('category_id', $request->input('category'))
                         ->where('id', '!=', $id)
                         ->exists();
    
        if ($exists) {
            return redirect()->back()->withErrors([
                'category' => 'The combination of financial year and category already exists.'
            ])->withInput(); // Keep the old input
        }
    
        // Try to save the budget entry
        try {
            $budget = Budgets::findOrFail($id);
            $budget->financial_year_id = $request->input('financialyear');    
            $budget->category_id = $request->input('category');
            $budget->amount = $amount;    
            $budget->notes = $request->input('notes');    
            $budget->save();
    
            return redirect()->route('budget.index')->with('success', 'Budget Updated Successfully');
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error('Error saving budget: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving the budget.')->withInput();
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

    public function deletebudget(Request $request)
    {

        $budgets = Budgets::findOrFail($request->input('id'));
        if (!$budgets) {
        return response()->json(['error' => 'Budget not found.'], 404);
        }
        $budgets->deleted_at = Carbon::parse(now())->format('Y-m-d H:i:s');
        $budgets->save();
        return response()->json(['success' => 'The Budget has been deleted!']);
        
    }
}
