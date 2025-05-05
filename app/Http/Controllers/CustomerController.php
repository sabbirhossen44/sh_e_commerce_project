<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CustomerEmailVerify;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerifyNotification;

class CustomerController extends Controller
{
    public function customer_profile()
    {
        return view('frontend.customer.profile');
    }
    public function customer_logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('welcome');
    }
    public function customer_profile_update(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'password' => ['nullable', Password::min(8)],
            'phone' => 'nullable',
            'zip' => 'nullable',
            'address' => 'nullable',
            'photo' => 'nullable|image',
        ]);
        $customer = Customer::find(Auth::guard('customer')->id());
        if ($request->filled('password')) {
            $customer->update([
                'password' => bcrypt($request->password),
            ]);
        }
        if ($request->hasFile('photo')) {
            if (!empty($customer->photo)) {
                $file_path = public_path('uploads/customer/' . $customer->photo);

                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $photo = $request->file('photo');
            $file_name = $request->fname . time() . random_int(5000, 5000000) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/customer/'), $file_name);
            $customer->update([
                'photo' => $file_name,
            ]);
        }
        $customer->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'phone' => $request->phone,
            'zip' => $request->zip,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('information_update', 'Customer Information Updated!');
    }
    public function my_orders()
    {
        $my_orders = Order::where('customer_id', Auth::guard('customer')->id())->latest()->get();
        return view('frontend.customer.myOrders', [
            'my_orders' => $my_orders,
        ]);
    }
    public function download_invoice($id)
    {
        $orders = Order::find($id);

        $pdf = PDF::loadView('frontend.customer.invoiceDownload', [
            'order_id' => $orders->order_id,
        ]);

        return $pdf->stream();

        // return $pdf->download('myOrders.pdf');
    }
    public function customer_email_verify($token)
    {
        if (CustomerEmailVerify::where('token', $token)->exists()) {
            $verify_info = CustomerEmailVerify::where('token', $token)->first();
            Customer::find($verify_info->customer_id)->update([
                'email_veryfied_at' => Carbon::now(),
            ]);
            CustomerEmailVerify::where('token', $token)->delete();
            return redirect()->route('customer.login')->with('email_verify', 'Email Verify Successful!');
        } else {
            return view('frontend.customer.404');
        }
    }
    public function reset_email_verify()
    {
        return view('frontend.customer.resend_email_verify');
    }
    public function reset_email_link_send(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();
        if (Customer::where('email', $request->email)->exists()) {
            CustomerEmailVerify::where('customer_id', $customer->id)->delete();
            $info = CustomerEmailVerify::create([
                'customer_id' => $customer->id,
                'token' => uniqid(),
                'created_at' => Carbon::now(),
            ]);
            Notification::send($customer, new EmailVerifyNotification($info));
            return back()->with('success', 'We have sent you verification link, Please verify your email');
            // return redirect()->route('customer.login');
        } else {
            return back()->with('notexist', 'Email Does Not Exist');
        }
    }
}
