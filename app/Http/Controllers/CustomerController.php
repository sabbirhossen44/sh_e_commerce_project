<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    public function customer_profile(){
        return view('frontend.customer.profile');
    }
    public function customer_logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('welcome');
    }
    public function customer_profile_update(Request $request){
        $request->validate([
            'fname' => 'required',
            'password' => ['nullable', Password::min(8)],
            'phone' => 'nullable',
            'zip' => 'nullable',
            'address' => 'nullable',
            'photo' => 'nullable|image',
        ]);
        $customer = Customer::find(Auth::guard('customer')->id());
        if($request->filled('password')){
            $customer->update([
                'password' => bcrypt($request->password),
            ]);
        }
        if($request->hasFile('photo')){
            if (!empty($customer->photo)) {
                $file_path = public_path('uploads/customer/' .$customer->photo);
            
                if(file_exists($file_path)){
                    unlink($file_path);
                }
            }
            $photo = $request->file('photo');
            $file_name = $request->fname. time(). random_int(5000, 5000000).'.'. $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/customer/'),$file_name);
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
}
