<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Passreset;
use App\Notifications\PassResetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class PassResetController extends Controller
{
    public function forget_password()
    {
        return view('frontend.password_reset.password_reset');
    }
    public function pass_reset_req(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        if (Customer::where('email', $request->email)->exists()) {
            $customer = Customer::where('email', $request->email)->first();
            Passreset::where('customer_id', $customer->id)->delete();
            $info = Passreset::create([
                'customer_id' => $customer->id,
                'token' => uniqid(),
                'created_at' => Carbon::now(),
            ]);
            Notification::send($customer, new PassResetNotification($info));
            return back()->with('sent', "We have sent you a password reset link, on $customer->email");
        } else {
            return back()->with('email_not_exist', "Email dose not Exists");
        }
    }
    public function password_reset_form($token)
    {
        if (Passreset::where('token', $token)->exists()) {
            return view('frontend.password_reset.pass_reset_form', [
                'token' => $token
            ]);
        } else {
            return view('frontend.customer.404');
        }
    }
    public function password_reset_confirm(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8']
        ]);
        $passreset = Passreset::where('token', $token)->first();
        if (Passreset::where('token', $token)->exists()) {
            Customer::find($passreset->customer_id)->update([
                'password' => bcrypt($request->password),
                'updated_at' => Carbon::now(),
            ]);
            Passreset::where('token', $token)->delete();
            return redirect()->route('customer.login')->with('reset', 'Password Reset Success!');
        } else {
            return view('frontend.customer.404');
        }
    }
}
