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
use Carbon\Carbon;

class TravelExpenseController extends Controller
{
    public function create()
    {
        $cities = City::orderBy('name')->get();
        $staff = Auth::user();

        $travelModes = [];
        if ($staff && $staff->designation) {
            $travelModes = $staff->designation->travelModes()->with('parent')->orderBy('name')->get();
            $allowance = DailyAllowanceAccommodation::where('designation_id', $staff->designation_id)
                                                    ->first();
        }

        return view('modules.Staff.travel.create', compact('cities', 'travelModes', 'allowance'));
    }

    public function index()
    {
        $expenses = TravelExpense::with(['sourceCity', 'destinationCity'])
                                   ->orderBy('title')
                                   ->get();
        return view('modules.Staff.travel.index', compact('expenses'));
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
            'status' => 'advance_requested', // default
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
            'file.*' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
        ],
        [
            'file.mimes' => 'Only pdf, doc, and docx files are allowed.',
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
}
