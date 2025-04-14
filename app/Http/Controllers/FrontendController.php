<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Offer1;
use App\Models\Offer2;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function welcome()
    {
        $banners = Banner::all();
        $categories = Category::all();
        $offer1 = Offer1::all();
        $offer2 = Offer2::all();
        $products = Product::latest()->where('status', 1)->take(8)->get();
        return view('frontend.index', [
            'banners' => $banners,
            'categories' => $categories,
            'offer1' => $offer1,
            'offer2' => $offer2,
            'products' => $products,
        ]);
    }
    public function subscribe_store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribes,email'
        ]);
        Subscribe::insert([
            'customer_id' => 1,
            'email' => $request->email,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('subscribe_add', 'Subscribe Successfull!');
    }
    public function product_details($slug)
    {
        $product_id = Product::where('slug', $slug)->first()->id;
        $product_info = Product::find($product_id);
        $gallery = ProductGallery::where('product_id', $product_id)->get();
        $available_color = Inventory::where('product_id', $product_id)->selectRaw('color_id ,SUM(color_id) as sum')->groupBy('color_id')->get();
        $available_size = Inventory::where('product_id', $product_id)->selectRaw('size_id ,SUM(size_id) as sum')->groupBy('size_id')->get();
        return view('frontend.product_details', [
            'product_info' => $product_info,
            'gallery' => $gallery,
            'available_color' => $available_color,
            'available_size' => $available_size,
        ]);
    }
    public function getSize(Request $request)
    {
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach ($sizes as $size) {
            if ($size->rel_to_size->size_name == 'N/A') {
                $str = '<li class="color"><input class="size_id" checked id="size'.$size->size_id.'" type="radio" name="size_id"
                value="'.$size->size_id.'">
            <label
                for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
            </li>';
            }
            else{
                $str .= '<li class="color"><input class="size_id" id="size'.$size->size_id.'" type="radio" name="size_id"
                value="'.$size->size_id.'">
            <label
                for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
            </li>';
            }
        }
        echo $str;
    }
    public function getQuantity(Request $request){
        // echo $request->color_id.$request->size_id.$request->product_id;
        $str = ' ';
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quentity;
        if ($quantity == 0) {
            $str =' <li><span id="quan" class="btn btn-danger text-white">Out Of Stock</span></li>';
        } else {
            $str =' <li><span id="quan" class="btn btn-success text-white">'.$quantity.' In Stock</span></li>';
        }
        echo $str;
    }
}
