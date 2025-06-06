<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerEmailVerify;
use App\Notifications\EmailVerifyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use App\Rules\ReCaptcha;

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
            //  'captcha' => 'required|captcha'
        ]);
        
        
        $customer_info = Customer::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        CustomerEmailVerify::where('customer_id', $customer_info->id)->delete();
        $info = CustomerEmailVerify::create([
            'customer_id' => $customer_info->id,
            'token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);
        Notification::send($customer_info, new EmailVerifyNotification($info));
        // return back()->with('success', 'Customer Registered Successfully!');
        return redirect()->route('customer.login');
    }
     public function refreshCaptcha()

    {

        return response()->json(['captcha'=> captcha_img()]);

    }
    public function customer_logged(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            // 'g-recaptcha-response' => ['required', new ReCaptcha]
            // 'captcha' => 'required|captcha'
            // 'captcha' => 'required|captcha'

        ]);
        if (Customer::where('email', $request->email)->exists()) {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::guard('customer')->user()->email_veryfied_at == null) {
                    Auth::guard('customer')->logout();
                    return redirect()->route('customer.login')->with('verify', 'Please Verify your email first');
                } else {
                    return redirect()->route('welcome');
                }
                
            } else {
                return back()->with('password_error', 'Wrong Password');
            }
        } else {
            return back()->with('exist', 'Email Does Not Exist');
        }
    }
}
