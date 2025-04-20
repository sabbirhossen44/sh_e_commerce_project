<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $countries = Country::all();
        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.customer.checkout', [
            'carts' => $carts,
            'countries' => $countries,
        ]);
    }
    public function getcity(Request $request)
    {
        $str = '';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach ($cities as $city) {
            $str .= '<option value="' . $city->id . '">' . $city->name . '</option>';
        }
        echo $str;
    }
    public function getshipcity(Request $request)
    {
        $str = '';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach ($cities as $city) {
            $str .= '<option value="' . $city->id . '">' . $city->name . '</option>';
        }
        echo $str;
    }
    public function order_store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'charge' => 'required',
            'payment_method' => 'required',
        ]);
        if ($request->ship_to_different == 1) {
            $request->validate([
                'ship_fname' => 'required',
                'ship_lname' => 'required',
                'ship_country' => 'required',
                'ship_city' => 'required',
                'ship_zip' => 'required',
                'ship_company' => 'required',
                'ship_email' => 'required|email',
                'ship_phone' => 'required',
                'ship_address' => 'required',
            ]);
        }
        if ($request->payment_method == 1) {
            $order_id = '#' . uniqid() . time();
            Order::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customer')->id(),
                'total' => $request->total + $request->charge,
                'sub_total' => $request->total + $request->discount,
                'discoutn' => $request->discount,
                'charge' => $request->charge,
                'payment_method' => $request->payment_method,
                'created_at' => Carbon::now(),
            ]);
            Billing::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customer')->id(),
                'fname' => $request->fname,
                'lname' => $request->lname,
                'country_id' => $request->country,
                'city_id' => $request->city,
                'zip' => $request->zip,
                'company' => $request->company,
                'email' => $request->email,
                'phone' => $request->phone,
                'adress' => $request->address,
                'notes' => $request->notes,
                'created_at' => Carbon::now(),
            ]);
            if ($request->ship_to_different == 1) {
                Shipping::insert([
                    'order_id' => $order_id,
                    'ship_fname' => $request->ship_fname,
                    'ship_lname' => $request->ship_lname,
                    'ship_country_id' => $request->ship_country,
                    'ship_city_id' => $request->ship_city,
                    'ship_zip' => $request->ship_zip,
                    'ship_company' => $request->ship_company,
                    'ship_email' => $request->ship_email,
                    'ship_phone' => $request->ship_phone,
                    'ship_adress' => $request->ship_address,
                    'created_at' => Carbon::now(),
                ]);
            } else {
                Shipping::insert([
                    'order_id' => $order_id,
                    'ship_fname' => $request->fname,
                    'ship_lname' => $request->lname,
                    'ship_country_id' => $request->country,
                    'ship_city_id' => $request->city,
                    'ship_zip' => $request->zip,
                    'ship_company' => $request->company,
                    'ship_email' => $request->email,
                    'ship_phone' => $request->phone,
                    'ship_adress' => $request->address,
                    'created_at' => Carbon::now(),
                ]);
            }
            $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
            foreach ($carts as $cart) {
                OrderProduct::insert([
                    'order_id' => $order_id,
                    'customer_id' => Auth::guard('customer')->id(),
                    'product_id' => $cart->product_id,
                    'price' => $cart->rel_to_product->after_discount,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'quantity' => $cart->quantity,
                    'created_at' => Carbon::now(),
                ]);
                // Cart::find($cart->id)->delete();
                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quentity', $cart->quantity);
            }
            return redirect()->route('order.success')->with('success', $order_id);
        } elseif ($request->payment_method == 2) {
            # code...
        } elseif ($request->payment_method == 3) {
            # code...
        } else {
            # code...
        }
    }
    public function order_success(){
        if (session('success')) {
            return view('frontend.customer.order_success');
        } else {
            return view('frontend.customer.404');
        }
        
        
    }
}
