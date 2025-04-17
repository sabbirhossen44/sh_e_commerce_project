<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
            'customer_id'=> Auth::guard('customer')->id(),
            'product_id'=> $request->product_id,
            'quantity'=> $request->quantity,
            'color_id'=> $request->color_id,
            'size_id'=> $request->size_id,
            'created_at'=> Carbon::now(),
        ]);
        return back()->with('success', 'Product added to cart successfully!');

    }
    public function cart_remove($id){
        $cart = Cart::find($id);
        $cart->delete();
        return back();
    }
    public function cart(){
        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.customer.cart',[
            'carts' => $carts,
        ]);
    }
    public function cart_update(Request $request){
        foreach ($request->quantity as $cart_id =>$quantity) {
            Cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back();
    }
}
