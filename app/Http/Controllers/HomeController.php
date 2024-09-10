<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\vendor;
use App\Models\Company;
use App\Models\State;
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
        
        if(Auth::user()->isvendor()){
        return view('lead.index');
        }else{

            return view('home');
        }
    }

     public function profile()
        {
            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();
            $vendor = Vendor::where('user_id', $userId)->first();
            if (isset($vendor->company_id)) {
                $company = Company::where('id', $vendor->company_id)->first();
                
                // Ensure $companies is an array
                $companies = $company ? $company->toArray() : [];
            } else {
                $companies = [];
            }
            $states = State::all();
            return view('profile',compact('user','vendor','companies','states'));
        }

        public function profileupdate(Request $request)
        {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'postcode' => 'required|string|max:10',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'gst' => 'nullable|string|max:15',
                'pan' => 'nullable|string|max:10',
                'address_2' => 'nullable|string|max:255',
            ]);
        
            try {
                // Find the vendor
                $vendor = Vendor::findOrFail($request->vid);
        
                // Check if the vendor already has a company
                if ($vendor->company) {
                    // Update the existing company's name
                    $vendor->company->company_name = $request->company;
                    $vendor->company->save();
                } else {
                    // Create a new company if none exists
                    $company = new Company();
                    $company->company_name = $request->company;
                    $company->save();
                    
                    $vendor->company_id = $company->id;
                }
        
                // Update vendor details
                $vendor->vendor_name = $request->name;
                $vendor->email = $request->email;
                $vendor->phone = $request->phone;
                $vendor->gst = $request->gst ?? $vendor->gst;
                $vendor->pan = $request->pan ?? $vendor->pan;
                $vendor->address = $request->address;
                $vendor->address_2 = $request->address_2 ?? $vendor->address_2;
                $vendor->city = $request->city;
                $vendor->postcode = $request->postcode;
                $vendor->state = $request->state;
        
                $vendor->save();
        
                return redirect()->route('profile')->with('success', 'Vendor Updated Successfully');
            } catch (\Exception $e) {
                // Log the exception
                print_r($e->getMessage());exit();
                \Log::error('Vendor update failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while updating the vendor.');
            }
        }
        
}
