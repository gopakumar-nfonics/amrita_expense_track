<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\vendor;
use App\Models\Company;
use App\Models\State;
use App\Models\Proposal;
use App\Models\PaymentMilestone;
use App\Models\VendorBankAccount;
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

        if (Auth::user()->isvendor()) {
            $userId = Auth::user()->id;
            $vendor = Vendor::where('user_id', $userId)->first();
            $proposal = Proposal::where('vendor_id', $vendor->id)->orderBy('id')->get();
            return view('lead.index', compact('proposal'));
        } else {

            return view('home');
        }
    }

    public function profile()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $vendor = Vendor::where('user_id', $userId)->first();
        $account_details = VendorBankAccount::where('vendor_id', $vendor->id)->first();
        if (isset($vendor->company_id)) {
            $company = Company::where('id', $vendor->company_id)->first();

            // Ensure $companies is an array
            $companies = $company ? $company->toArray() : [];
        } else {
            $companies = [];
        }
        $states = State::all();
        return view('profile', compact('user', 'vendor', 'companies', 'states', 'account_details'));
    }

    public function profileupdate(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'gst' => 'nullable|string|max:15',
            'pan' => 'nullable|string|max:10',
            'address_2' => 'nullable|string|max:255',
            'beneficiary_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'cn_person' => 'required|string|max:255',

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
            $vendor->phone = $request->phone;
            $vendor->contact_person = $request->cn_person;
            $vendor->gst = $request->gst ?? $vendor->gst;
            $vendor->pan = $request->pan ?? $vendor->pan;
            $vendor->address = $request->address;
            $vendor->address_2 = $request->address_2 ?? $vendor->address_2;
            $vendor->city = $request->city;
            $vendor->postcode = $request->postcode;
            $vendor->state = $request->state;

            $vendor->save();

            $vendorBankAccount = new VendorBankAccount();
            $vendorBankAccount->beneficiary_name = $request->beneficiary_name;
            $vendorBankAccount->account_no = $request->account_no;
            $vendorBankAccount->ifsc_code = $request->ifsc_code;
            $vendorBankAccount->bank_name = $request->bank_name;
            $vendorBankAccount->branch_name = $request->branch_name;
            $vendorBankAccount->vendor_id = $vendor->id; // If you need to associate it with a vendor
            $vendorBankAccount->save();

            return redirect()->route('profile')->with('success', 'Vendor Updated Successfully');
        } catch (\Exception $e) {
            // Log the exception
            print_r($e->getMessage());
            exit();
            \Log::error('Vendor update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the vendor.');
        }
    }
}
