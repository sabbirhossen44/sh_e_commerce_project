<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    public function customer_login()
    {
        return view('frontend.customer.login');
    }
    public function customer_register()
    {
        return view('frontend.customer.register');
    }
    public function customer_store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => 'required',
        ]);
        Customer::insert([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        // return back()->with('success', 'Customer Registered Successfully!');
        return redirect()->route('customer.login');
    }
    public function customer_logged(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Customer::where('email', $request->email)->exists()) {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('welcome');
            } else {
                return back()->with('password_error', 'Wrong Password');
            }
        } else {
            return back()->with('exist', 'Email Does Not Exist');
        }
    }
    
}
