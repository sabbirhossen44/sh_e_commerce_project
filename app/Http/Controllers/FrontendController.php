<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Offer1;
use App\Models\Offer2;
use App\Models\Product;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function welcome(){
        $banners = Banner::all();
        $categories = Category::all();
        $offer1 = Offer1::all();
        $offer2 = Offer2::all();
        $products = Product::latest()->where( 'status',1)->take(8)->get();
        return view('frontend.index',[
            'banners' => $banners,
            'categories' => $categories,
            'offer1' => $offer1,
            'offer2' => $offer2,
            'products' => $products,
        ]);
    }
    public function subscribe_store(Request $request){
        $request->validate([
            'email' => 'required|email|unique:subscribes,email'
        ]);
        Subscribe::insert([
            'customer_id' => 1,
            'email' =>$request->email,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('subscribe_add', 'Subscribe Successfull!');
    }
    
}
