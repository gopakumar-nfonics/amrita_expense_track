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
use Carbon\Carbon;
use App\Modules\Staff\Models\Staff;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApproveAdvanceMail;
use App\Mail\ExpenseSettleMail;

class travelexpense extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = TravelExpenseModel::with(['staff', 'sourceCity', 'destinationCity'])
            ->orderBy('id', 'desc')
            ->get();
        $programmes = Stream::orderBy('stream_name')->get();
        $main_categories = Category::whereNull('parent_category')
            ->with(['children', 'budgets'])
            ->get();

        $years = FinancialYear::orderByDesc('is_current')
            ->orderBy('year')
            ->get();
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
        $expense = TravelExpenseModel::with(['staff', 'sourceCity', 'destinationCity', 'category', 'stream', 'details'])->find($id);

        $totalAmount = $expense->amount;
        $advanceAmount = $expense->advance_amount;
        $numbersWords = new Numbers_Words();
        $total_words = $numbersWords->toWords($totalAmount);
        $advance_words = $numbersWords->toWords($advanceAmount);

        $settleAmount = $totalAmount - $advanceAmount;


        // Check if negative
        if ($settleAmount < 0) {
            $settle_words = 'minus ' . $numbersWords->toWords(abs($settleAmount));
        }
        elseif($settleAmount == 0){
            $settle_words = '';
        }
         else {
            $settle_words = $numbersWords->toWords($settleAmount);
        }

        return view('travelexpense.show', compact('expense', 'total_words', 'advance_words', 'settleAmount', 'settle_words'));
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
            'advance_date' => 'required|date',
        ]);

        $expense = TravelExpenseModel::findOrFail($request->expense_id);
        if ($request->advance_date) {
            $advanceDate = Carbon::createFromFormat('d-M-Y', $request->advance_date)->format('Y-m-d');
        }

        $expense->update([
            'financial_year_id'  => $request->year,
            'category_id'        => $request->category,
            'stream_id'          => $request->programme,
            'advance_amount'     => $request->approved_amount,
            'associated'         => $request->associated,
            'status'             => 'advance_received',
            'advancepayment_date'=> $advanceDate,
        ]);

        $staff = Staff::where('id', $expense->staff_id)->first();

        $advanceDetails = [
            'name' => $staff->name,
            'expense_title' => $expense->title,
        ];

        $subject = $expense->title." Advance Approved"; 
        Mail::to($staff->email)->send(new ApproveAdvanceMail($advanceDetails, $subject));

        return redirect()->back()->with('success', 'Advance request approved successfully.');
    }

    public function settle_expense(Request $request)
    {

        $expense = TravelExpenseModel::findOrFail($request->expense_id);

        $expense->status = 'expense_settled';
        $expense->final_amount = $request->settle_amount;
        if ($request->settlement_date) {
            $expense->settlement_date = Carbon::createFromFormat('d-M-Y', $request->settlement_date)->format('Y-m-d');
        }
        $expense->save();

        $staff = Staff::where('id', $expense->staff_id)->first();
        $settlementDetails = [
            'name' => $staff->name,
            'expense_title' => $expense->title,
        ];

        $subject = $expense->title." Expense Settled"; 
        Mail::to($staff->email)->send(new ExpenseSettleMail($settlementDetails, $subject));

        return response()->json([
            'message' => 'Expense Settled Successfully.',
            'redirect' => route('travelexpense.index')
        ]);
    }

    public function deleteExpense(Request $request)
    {
        $expense = TravelExpenseModel::findOrFail($request->id);
        if (!$expense) {
            return response()->json(['error' => 'Advance Requst not found.'], 404);
        }
        $expense->forceDelete();
        return response()->json(['success' => 'Advance Request has been deleted!']);
        
    }

    public function reject_expense(Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $expense = TravelExpenseModel::findOrFail($request->expense_id);

        $expense->status = 'rejected';
        $expense->rejection_status = true;
        $expense->rejection_reason = $request->rejection_reason;
        
        $expense->save();

        

        return response()->json([
            'message' => 'Expense Rejected.',
            'redirect' => route('travelexpense.index')
        ]);
    }
}
