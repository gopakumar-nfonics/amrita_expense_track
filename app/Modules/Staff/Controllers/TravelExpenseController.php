<?php

namespace App\Modules\Staff\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Staff\Models\TravelExpense;
use Illuminate\Support\Facades\Auth;

class TravelExpenseController extends Controller
{
    public function create()
    {
        return view('modules.Staff.travel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
            'city'      => 'required|string|max:255',
            'amount'    => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        TravelExpense::create([
            'staff_id'  => Auth::guard('staff')->id(),
            'from_date' => $request->from_date,
            'to_date'   => $request->to_date,
            'city'      => $request->city,
            'amount'    => $request->amount,
            'description'  => $request->description,
            'status'    => 'pending', // default
        ]);

        return redirect()->back()->with('success', 'Travel expense submitted successfully.');
    }
}
