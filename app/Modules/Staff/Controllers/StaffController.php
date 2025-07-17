<?php

namespace App\Modules\Staff\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Staff\Models\Staff;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        return view('modules.Staff.dashboard');
    }

    public function profile()
    {
        $staffId = auth()->guard('staff')->id();
        $staffs = Staff::where('id', $staffId)->first();
        $designation = Designation::orderBy('title')->get();
        return view('modules.Staff.profile', compact('staffs', 'designation'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);
    
        try {
            $staff = Staff::findOrFail($id);
            $staff->password = bcrypt($request->password);
            $staff->save();
    
            return redirect()->route('travel.index')->with('success', 'Password Updated Successfully');
        } catch (\Exception $e) {
            // Log the exception message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
