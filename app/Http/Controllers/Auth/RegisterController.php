<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/registration';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/', // Must contain letters, numbers, and symbols
            ],
        ], [
            'password.regex' => 'The password must be at least 8 characters long and include a mix of letters, numbers, and symbols.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
{
    $user = User::create([
        'first_name' => $data['name'],
        'email' => $data['email'],
        'role' => 'Vendor',
        'password' => Hash::make($data['password']),
    ]);

    $prefix = 'BUET-VR-';
    // Retrieve the highest existing code
    $latestCode = Vendor::where('vendor_code', 'like', $prefix . '%')
        ->orderByRaw('CAST(SUBSTRING(vendor_code, LENGTH(?) + 1) AS UNSIGNED) DESC', [$prefix])
        ->pluck('vendor_code')
        ->first();

    $latestNumber = 0;
    if ($latestCode) {
        $latestNumber = (int)substr($latestCode, strlen($prefix));
    }

    $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT); // Adjust to 3 digits
    $vendorcode = $prefix . $nextNumber;

    Vendor::create([
        'user_id' => $user->id, 
        'vendor_name' => $data['name'],
        'email' => $data['email'], // Ensure this field is provided
        'vendor_code' => $vendorcode,
    ]);

    return $user;
}


}
