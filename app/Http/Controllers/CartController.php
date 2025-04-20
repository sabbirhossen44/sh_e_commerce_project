<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'color_id' => 'required',
            'size_id' => 'required',
        ]);
        Cart::insert([
            'customer_id' => Auth::guard('customer')->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success', 'Product added to cart successfully!');
    }
    public function cart_remove($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return back();
    }
    public function cart(Request $request)
    {
        $coupon = $request->coupon;

        $message = '';
        $message_sec = '';
        $type = '';
        $amount = 0;
        if (filled($coupon)) {
            if (Coupon::where('coupon', $coupon)->exists()) {
                if (Coupon::where('coupon', $coupon)->where('status', 1)->exists()) {
                    if (Coupon::where('coupon', $coupon)->where('limit', '>', 0)->exists()) {
                        if (Coupon::where('coupon', $coupon)->where('validity', '>=', Carbon::now())->exists()) {
                            $type = Coupon::where('coupon', $coupon)->first()->type;
                            $amount = Coupon::where('coupon', $coupon)->first()->amount;
                            $message_sec = 'Coupon Applied Successfully!';
                            $message_sec = 'Coupon Applied Successfully!';
                        } else {
                            $message = 'Coupon Expired!';
                            $amount = 0;
                        }
                    } else {
                        $message = 'Limit Exceeded!';
                        $amount = 0;
                    }
                } else {
                    $message = 'Coupon Does Not Exist!';
                    $amount = 0;
                }
            } else {
                $amount = 0;
                $message = 'Coupon Does Not Exist!';
            }
        }


        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.customer.cart', [
            'carts' => $carts,
            'type' => $type,
            'amount' => $amount,
            'message' => $message,
            'message_sec' => $message_sec,
        ]);
    }
    public function cart_update(Request $request)
    {
        foreach ($request->quantity as $cart_id => $quantity) {
            Cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back();
    }
}
