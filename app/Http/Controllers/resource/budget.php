<?php

namespace App\Http\Controllers\resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category as Categories;
use App\Models\FinancialYear;
use App\Models\PaymentRequest;
use App\Models\Budget as Budgets;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class budget extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $budgets = Budgets::select('tbl_budget.*')
        ->selectRaw('(
            COALESCE((
                SELECT SUM(payment_milestones.milestone_total_amount) 
                FROM payment_request
                INNER JOIN invoices ON payment_request.invoice_id = invoices.id
                INNER JOIN payment_milestones ON invoices.milestone_id = payment_milestones.id
                INNER JOIN tbl_category ON payment_request.category_id = tbl_category.id
                INNER JOIN proposal ON payment_milestones.proposal_id = proposal.id
                WHERE (payment_request.category_id = tbl_budget.category_id 
                    OR tbl_category.parent_category = tbl_budget.category_id)
                AND payment_request.payment_status = "completed"
                AND proposal.proposal_year = tbl_budget.financial_year_id
            ), 0)
            +
            COALESCE((
                SELECT SUM(noninvoice_payment.amount)
                FROM noninvoice_payment
                INNER JOIN tbl_category ON noninvoice_payment.category_id = tbl_category.id
                WHERE (noninvoice_payment.category_id = tbl_budget.category_id 
                    OR tbl_category.parent_category = tbl_budget.category_id)
                AND noninvoice_payment.payment_status = "completed"
                AND noninvoice_payment.financial_year_id = tbl_budget.financial_year_id
            ), 0)
            +
            COALESCE((
                SELECT SUM(advance_amount)
                FROM tbl_travel_expenses
                INNER JOIN tbl_category ON tbl_travel_expenses.category_id = tbl_category.id
                WHERE (tbl_travel_expenses.category_id = tbl_budget.category_id 
                    OR tbl_category.parent_category = tbl_budget.category_id)
                AND tbl_travel_expenses.status IN ("advance_received", "expense_submitted")
                AND tbl_travel_expenses.financial_year_id = tbl_budget.financial_year_id
            ), 0)
            +
            COALESCE((
                SELECT SUM(amount)
                FROM tbl_travel_expenses
                INNER JOIN tbl_category ON tbl_travel_expenses.category_id = tbl_category.id
                WHERE (tbl_travel_expenses.category_id = tbl_budget.category_id 
                    OR tbl_category.parent_category = tbl_budget.category_id)
                AND tbl_travel_expenses.status = "expense_settled"
                AND tbl_travel_expenses.financial_year_id = tbl_budget.financial_year_id
            ), 0)
        ) as used_amount')
    ->from('tbl_budget')
    ->whereNull('tbl_budget.deleted_at')
    ->orderByDesc('id')
    ->get();
    
   
        return view('budget.index',['budgets'=>$budgets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Categories::orderBy('category_name')->where('parent_category',null)->get();
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
            'amount' => 'required',
        ]);
    
        $amount = preg_replace('/[^\d.]/', '', $request->input('amount'));
       
        
        // Try to save the budget entry
        try {
            $budget = Budgets::findOrFail($id);
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

        $budgets = Budgets::findOrFail($request->id);

        if (!$budgets) {
            return response()->json(['error' => 'Budget not found.'], 404);
        }

        $paymentRequestCount = PaymentRequest::where('category_id', $budgets->category_id)->count();
        
        if ($paymentRequestCount > 0) {
            return response()->json(['error' => 'Cannot delete budget associated with a payment request.']);
        }

        $budgets->forceDelete();
        return response()->json(['success' => 'The Budget has been deleted!']);
        
    }

    public function getCategories($financialYearId)
    {
        $selectedCategoryIds = Budgets::where('financial_year_id', $financialYearId)->pluck('category_id');

        $categories = Categories::whereNotIn('id', $selectedCategoryIds)
        ->where('parent_category', null)
        ->get(['id', 'category_name']);

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
    }
}
