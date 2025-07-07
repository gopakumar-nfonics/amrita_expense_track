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
        $Year = $request->query('year');
        $financialyears = FinancialYear::get();

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

        // Calculate totals
        $totalAmount = $expenses->sum('amount');
        $totalAdvance = $expenses->sum('advance_amount');
        $totalFinal = $expenses->sum('final_amount');
        $totalDisbursed = $totalAdvance + $totalFinal;
        $balance = $totalAmount - ($totalAdvance + $totalFinal);

        return view('modules.Staff.travel.index', compact('expenses', 'totalAmount', 'totalAdvance', 'financialyears', 'balance', 'totalDisbursed'));
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
            'advance_amount' => 'required',
        ]);

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
            'amount' => 0,
            'status' => 'advance_requested',
            'advance_amount' => $request->advance_amount,
        ]);

        // Save DA
        TravelExpenseDetail::create([
            'travel_expense_id' => $travelExpense->id,
            'head' => 'DA',
            'expenditure' => '₹' . number_format($request->allowance_amount / max($days, 1)) . ' per day for ' . $days . ' ' . \Str::plural('day', $days),
            'amount' => $request->allowance_amount,
        ]);

        // Save Accommodation
        TravelExpenseDetail::create([
            'travel_expense_id' => $travelExpense->id,
            'head' => 'ACC',
            'expenditure' => '₹' . number_format($request->accommodation_amount / max($days, 1)) . ' per day for ' . $days . ' ' . \Str::plural('day', $days),
            'amount' => $request->accommodation_amount,
        ]);

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
        $staff = Auth::user();

        $travelModes = [];
        if ($staff && $staff->designation) {
            $travelModes = $staff->designation->travelModes()->with('parent')->orderBy('name')->get();
            $allowance = DailyAllowanceAccommodation::where('designation_id', $staff->designation_id)
                                                    ->first();
        }

        $daDetail = $expense->details->firstWhere('head', 'DA');
        $accDetail = $expense->details->firstWhere('head', 'ACC');
    
        $daAmount = $daDetail?->amount ?? 0;
        $accAmount = $accDetail?->amount ?? 0;

        return view('modules.Staff.travel.submit', compact('expense', 'cities', 'travelModes', 'allowance', 'daAmount', 'accAmount'));
    }

    public function expense_store(Request $request, $id)
    {
        $request->validate([
            'direction.*' => 'required',
            'travel_modes.*' => 'required',
            'fare.*' => 'required',
            'file.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:20480',
        ],
        [
            'file.mimes' => 'Only pdf, doc, docx, jpg, jpeg, png, and webp files are allowed.',
            'file.max' => 'The file size must not exceed 20MB.',
        ]);

        // Calculate total fare
        $subTotal = array_sum($request->fare);

        $travelExpense = TravelExpense::findOrFail($id);
  
        $travelExpense->update([
            'amount' => $subTotal,
            'status' => 'expense_submitted', // default
        ]);

        // Save each travel fare row
        foreach ($request->direction as $index => $head) {
            $expenditure = $request->travel_modes[$index] ?? null;

            // If it's "Additional Expense", replace travel_mode with user-defined input
            if ($head === 'Additional Expense' && isset($request->additional_expense_desc[$index])) {
                $expenditure = $request->additional_expense_desc[$index];
            } elseif ($expenditure) {
                
                $mode = TravelMode::with('parent')->find($expenditure);
                $expenditure = $mode && $mode->parent
                    ? $mode->parent->name . ' - ' . $mode->name
                    : ($mode ? $mode->name : null);
            }

            $file_path = null;
            if ($request->hasFile("file.$index")) {
                $file = $request->file("file.$index");

                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $slug = \Str::of($originalName)
                        ->lower()
                        ->replace(['_', ' '], '-'); // Replace underscores/spaces with hyphens

                $formattedName = ucwords((string) $slug, '-');
                $filename = $formattedName . '_' . time() . '.' . $extension;

                $path = $file->storeAs('expense_document', $filename, 'public');
                $file_path = $path;
            }

            TravelExpenseDetail::create([
                'travel_expense_id' => $travelExpense->id,
                'head' => $head,
                'expenditure' => $expenditure,
                'amount' => $request->fare[$index],
                'file_path' => $file_path ?? null,
            ]);
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
        $expense = TravelExpense::with(['staff','sourceCity', 'destinationCity', 'category', 'stream', 'details'])
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
        } else {
            $settle_words = $numbersWords->toWords($settleAmount);
        }

        return view('modules.Staff.travel.show',compact('expense', 'total_words', 'advance_words', 'settleAmount', 'settle_words'));
    }

}
