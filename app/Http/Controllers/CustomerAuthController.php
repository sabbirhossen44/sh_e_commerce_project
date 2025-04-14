<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    public function customer_login(){
        return view('frontend.customer.login');
    }
    public function customer_register(){
        return view('frontend.customer.register');
    }
    public function customer_store(Request $request){
        $request->validate([
            'fname' => 'required',
            'email' => 'required|email|unique:customers',
            'password'=> ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => 'required',
        ]);
        Customer::insert([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success', 'Customer Registered Successfully!');
    }
}
