<?php

namespace App\Modules\Staff\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Staff\Models\TravelExpense;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\TravelMode;
use App\Models\DailyAllowanceAccommodation;
use App\Modules\Staff\Models\TravelExpenseDetail;
use App\Models\FinancialYear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Numbers_Words;
use App\Modules\Staff\Models\Staff;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdvanceRequestMail;
use App\Mail\ExpenseSubmitMail;
use App\Models\Category;

class TravelExpenseController extends Controller
{
    public function create()
    {
        $cities = City::orderBy('name')->get();
        $staff = Auth::user();

        $travelModes = [];
        if ($staff && $staff->designation) {
            $travelModes = $staff->designation->travelModes()->with('parent')->orderBy('name')->get();
        }

        return view('modules.Staff.travel.create', compact('cities', 'travelModes'));
    }

    public function index(Request $request)
    {
        $staffId = auth()->guard('staff')->id();
        $currentYear = FinancialYear::where('is_current', 1)->first();
        $financialyears = FinancialYear::orderByDesc('is_current')->orderByDesc('year')->get();
        $Year = $request->query('year') ?? $currentYear?->year;

        $query = TravelExpense::with(['sourceCity', 'destinationCity'])
            ->where('staff_id', $staffId)
            ->orderBy('id', 'desc');

        if ($Year) {
            $financialYear = FinancialYear::where('year', $Year)->first();

            if ($financialYear) {
                $query->where('financial_year_id', $financialYear->id);
            }
        }

        // Get the results
        $expenses = $query->get();
        $filteredExpenses = $expenses->where('status', '!=', 'rejected');

        $totalAmount = $filteredExpenses->sum('amount');
        $totalAdvance = $filteredExpenses->sum('advance_amount');
        $totalFinal = $filteredExpenses->sum('final_amount');
        $totalDisbursed = $totalAdvance + $totalFinal;
        $balance = $totalAmount - $totalDisbursed;

        return view('modules.Staff.travel.index', compact('expenses', 'totalAmount', 'totalAdvance', 'financialyears', 'balance', 'totalDisbursed', 'currentYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'source_city' => 'required',
            'destination_city' => 'required',
            'allowance_amount' => 'required',
            'accommodation_amount' => 'required',
            'advance_amount' => 'required|numeric',
        ]);

        $staff_id = Auth::guard('staff')->id();
        $staff = Staff::where('id', $staff_id)->first();
        $currentYearId = FinancialYear::where('is_current', 1)->value('id') 
            ?? FinancialYear::orderByDesc('year')->value('id');


        // Calculate days between
        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        $days = $from->diffInDays($to); // full days only

        $travelExpense = TravelExpense::create([
            'staff_id' => Auth::guard('staff')->id(),
            'title' => $request->title,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'source_city' => $request->source_city,
            'destination_city' => $request->destination_city,
            'financial_year_id' => $currentYearId,
            'amount' => 0,
            'status' => 'advance_requested',
            'advance_amount' => $request->advance_amount,
        ]);

        $requestDetails = [
            'name' => $staff->name,
            'expense_title' => $travelExpense->title,
        ];

        $adminsubject ="Staff Advance Request - Review and Approval Required";
        $adminemail = env('CONTACT_MAIL');
        Mail::to($adminemail)->send(new AdvanceRequestMail($requestDetails,$adminsubject));

        return redirect()->route('travel.index')->with('success', 'Advance request submitted successfully.');
    }

    public function getAllowance(Request $request)
    {
        $designationId = Auth::user()->designation_id;
        $destinationCityId = $request->input('city_id');

        $city = City::find($destinationCityId);
        if (!$city || !$designationId) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $allowance = DailyAllowanceAccommodation::where('designation_id', $designationId)
            ->where('city_tier_id', $city->tier_id) // Make sure your city model has a `tier` field
            ->first();

        if (!$allowance) {
            return response()->json(['error' => 'No allowance found'], 404);
        }

        return response()->json([
            'allowance_amount' => $allowance->allowance_amount,
            'accommodation_amount' => $allowance->accommodation_amount,
        ]);
    }

    public function submit_expense($id)
    {
        $expense = TravelExpense::findOrFail($id);
        $cities = City::orderBy('name')->get();
        $categories = Category::where('parent_category', $expense->category_id)->get();
        $staff = Auth::user();

        $travelModes = [];
        if ($staff && $staff->designation) {
            // $travelModes = $staff->designation->travelModes()->with('parent')->orderBy('name')->get();
            $allowance = DailyAllowanceAccommodation::where('designation_id', $staff->designation_id)
                                                    ->first();
        }

        return view('modules.Staff.travel.submit', compact('expense', 'cities', 'allowance', 'categories'));
    }

    public function edit($id)
    {
        $expense = TravelExpense::with('details')->findOrFail($id);
        $cities = City::orderBy('name')->get();
        $categories = Category::where('parent_category', $expense->category_id)->get();
        $staff = Auth::user();

        $travelModes = [];
        if ($staff && $staff->designation) {
            // $travelModes = $staff->designation->travelModes()->with('parent')->orderBy('name')->get();
            $allowance = DailyAllowanceAccommodation::where('designation_id', $staff->designation_id)
                                                    ->first();
        }

        $total = $expense->amount;

        return view('modules.Staff.travel.edit', compact('expense', 'cities', 'allowance', 'total', 'categories'));
    }

    public function expense_store(Request $request, $id)
    {
        $request->validate([
            'direction.*' => 'required',
            'fare.*' => 'required',
            'file.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:20480',
        ],
        [
            'file.mimes' => 'Only pdf, doc, docx, jpg, jpeg, png, and webp files are allowed.',
            'file.max' => 'The file size must not exceed 20MB.',
        ]);

        $oldExpense = TravelExpense::with('details')->findOrFail($id);
        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        $days = $from->diffInDays($to);
        $subTotal = array_sum($request->fare);
    
        // If rejected: Clone as new
        if ($oldExpense->status === 'rejected') {

            $oldExpense->update([
                'is_resubmit' => true,
            ]);

            $newExpense = TravelExpense::create([
                'title' => $oldExpense->title,
                'staff_id' => $oldExpense->staff_id,
                'from_date' => $oldExpense->from_date,
                'to_date' => $oldExpense->to_date,
                'source_city' => $oldExpense->source_city,
                'destination_city' => $oldExpense->destination_city,
                'financial_year_id' => $oldExpense->financial_year_id,
                'category_id' => $oldExpense->category_id,
                'stream_id' => $oldExpense->stream_id,
                'associated' => $oldExpense->associated,
                'status' => 'expense_submitted',
                'amount' => $subTotal,
                'advance_amount' => $oldExpense->advance_amount,
                'advancepayment_date' => $oldExpense->advancepayment_date,
            ]);
    
            foreach ($request->direction as $index => $categoryId) {
                $notes = $request->notes[$index] ?? null;
                $fare = $request->fare[$index] ?? 0;
                $file_path = null;
    
                if ($request->hasFile("file.$index")) {
                    $file = $request->file("file.$index");
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $slug = \Str::of($originalName)->lower()->replace(['_', ' '], '-');
                    $formattedName = ucwords((string) $slug, '-');
                    $filename = $formattedName . '_' . time() . '.' . $extension;
                    $path = $file->storeAs('expense_document', $filename, 'public');
                    $file_path = $path;
                }
    
                TravelExpenseDetail::create([
                    'travel_expense_id' => $newExpense->id,
                    'travel_head' => $categoryId,
                    'amount' => $fare,
                    'expenditure' => $notes,
                    'file_path' => $file_path,
                ]);
            }
    
            $staff = Staff::find($newExpense->staff_id);
            $expenseDetails = [
                'name' => $staff->name,
                'expense_title' => $newExpense->title,
            ];
            $adminsubject = "Expense Re-Submitted";
            $adminemail = env('CONTACT_MAIL');
            Mail::to($adminemail)->send(new ExpenseSubmitMail($expenseDetails, $adminsubject));
    
        } else {
            
            $oldExpense->details()->delete();
    
            $oldExpense->update([
                'amount' => $subTotal,
                'status' => 'expense_submitted',
            ]);
    
            foreach ($request->direction as $index => $categoryId) {
                $notes = $request->notes[$index] ?? null;
                $fare = $request->fare[$index] ?? 0;
                $file_path = null;
    
                if ($request->hasFile("file.$index")) {
                    $file = $request->file("file.$index");
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $slug = \Str::of($originalName)->lower()->replace(['_', ' '], '-');
                    $formattedName = ucwords((string) $slug, '-');
                    $filename = $formattedName . '_' . time() . '.' . $extension;
                    $path = $file->storeAs('expense_document', $filename, 'public');
                    $file_path = $path;
                }
    
                TravelExpenseDetail::create([
                    'travel_expense_id' => $oldExpense->id,
                    'travel_head' => $categoryId,
                    'amount' => $fare,
                    'expenditure' => $notes,
                    'file_path' => $file_path,
                ]);
            }
    
            $staff = Staff::find($oldExpense->staff_id);
            $expenseDetails = [
                'name' => $staff->name,
                'expense_title' => $oldExpense->title,
            ];
            $adminsubject = "Expense Submitted";
            $adminemail = env('CONTACT_MAIL');
            Mail::to($adminemail)->send(new ExpenseSubmitMail($expenseDetails, $adminsubject));
        }

        return redirect()->route('travel.index')->with('success', 'Travel expense submitted successfully.');
    }

    public function deleteExpense(Request $request)
    {
        $expense = TravelExpense::findOrFail($request->id);
        if (!$expense) {
            return response()->json(['error' => 'Advance Request not found.'], 404);
        }
        $expense->forceDelete();
        return response()->json(['success' => 'Advance Request has been deleted!']);
        
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $staffId = auth()->guard('staff')->id();
        $expense = TravelExpense::with(['staff','sourceCity', 'destinationCity', 'category', 'stream', 'details.category'])
        ->where('staff_id', $staffId)
        ->find($id);

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

        return view('modules.Staff.travel.show',compact('expense', 'total_words', 'advance_words', 'settleAmount', 'settle_words'));
    }

}
