<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Offer1;
use App\Models\Offer2;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\size;
use App\Models\Subscribe;
use App\Models\Tag;
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
        $reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->orderByDesc('star')->take(4)->get();
        $total_reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');
        // return $reviews;
        return view('frontend.product_details', [
            'product_info' => $product_info,
            'gallery' => $gallery,
            'available_color' => $available_color,
            'available_size' => $available_size,
            'reviews' => $reviews,
            'total_reviews' => $total_reviews,
            'total_star' => $total_star,
        ]);
    }
    public function getSize(Request $request)
    {
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach ($sizes as $size) {
            if ($size->rel_to_size->size_name == 'N/A') {
                $str = '<li class="color"><input class="size_id" checked id="size' . $size->size_id . '" type="radio" name="size_id"
                value="' . $size->size_id . '">
            <label
                for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label>
            </li>';
            } else {
                $str .= '<li class="color"><input class="size_id" id="size' . $size->size_id . '" type="radio" name="size_id"
                value="' . $size->size_id . '">
            <label
                for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label>
            </li>';
            }
        }
        echo $str;
    }
    public function getQuantity(Request $request)
    {
        // echo $request->color_id.$request->size_id.$request->product_id;
        $str = ' ';
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quentity;
        if ($quantity == 0) {
            $str = ' <li><span id="quan" class="btn btn-danger text-white">Out Of Stock</span></li>';
        } else {
            $str = ' <li><span id="quan" class="btn btn-success text-white">' . $quantity . ' In Stock</span></li>';
        }
        echo $str;
    }
    public function shop(Request $request)
    {
        // return Product::max('price');
        $data = $request->all();
        // filter start
        $based = 'created_at';
        $type = 'DESC';
        if (!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined') {
            if ($data['sort'] == 1) {
                $based = 'after_discount';
                $type = 'ASC';
            }elseif ($data['sort'] == 2) {
                $based = 'after_discount';
                $type = 'DESC';
            }elseif ($data['sort'] == 3) {
                $based = 'product_name';
                $type = 'ASC';
            }elseif ($data['sort'] == 4) {
                $based = 'product_name';
                $type = 'DESC';
            }
        }
        // filter end
        $categoris = Category::all();
        $products = Product::where('status', 1)->where(function ($q) use ($data) {
            $min = 0;
            $max = 0;
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined') {
                $min = $data['min'];
            } else {
                $min = 1;
            }
            if (!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $max = $data['max'];
            } else {
                $max = Product::max('after_discount');
            }

            if (!empty($data['search_input']) && $data['search_input'] != '' && $data['search_input'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('product_name', 'like', '%' . $data['search_input'] . '%');
                    // $q->orWhere('long_desp', 'like', '%' . $data['search_input'] . '%');
                    $q->orWhere('tags', 'like', '%' . $data['search_input'] . '%');
                });
            }
            if (!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('category_id', $data['category_id']);
                });
            }
            if (!empty($data['tag']) && $data['tag'] != '' && $data['tag'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $all = '';
                    foreach (Product::where('status', 1)->get() as $product) {
                        $explode = explode(',', $product->tags);
                        if (in_array($data['tag'], $explode)) {
                            $all .= $product->id . ',';
                        }
                    }
                    $explode2 = explode(',', $all);
                    $q->find($explode2);
                });
            }
            if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                $q->whereHas('rel_to_inventory', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('color_id', $data['color_id']);
                        });
                    }
                });
            }
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $q->whereBetween('after_discount', [$min, $max]);
            }
        })->orderBy($based, $type)->get();
        $colors = Color::all();
        $sizes = size::all();
        $new_products = Product::latest()->where('status', 1)->take(3)->get();
        $tags = Tag::all();
        return view('frontend.shop', [
            'products' => $products,
            'new_products' => $new_products,
            'categoris' => $categoris,
            'colors' => $colors,
            'sizes' => $sizes,
            'tags' => $tags,
        ]);
    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function about()
    {
        return view('frontend.about');
    }
    public function faq()
    {
        return view('frontend.faq');
    }
    public function compare()
    {
        return view('frontend.compare');
    }
    public function recent_view()
    {
        return view('frontend.recent_view');
    }
}
