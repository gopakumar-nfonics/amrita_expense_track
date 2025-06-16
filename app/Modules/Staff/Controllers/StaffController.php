<?php

namespace App\Modules\Staff\Controllers;

use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    public function dashboard()
    {
        return view('modules.Staff.dashboard');
    }
}
