<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\vendor;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

     public function profile()
        {
            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();
            $vendor = Vendor::where('user_id', $userId)->first();
            $companies=Company::orderBy('company_name')->get();
            return view('profile',compact('user','vendor','companies'));
        }
}
