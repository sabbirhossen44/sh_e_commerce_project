<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

use function PHPUnit\Framework\fileExists;

class ProductController extends Controller
{
    public function product_add()
    {
        $categories = Category::all();
        $sub_categories = Subcategory::all();
        $brands = Brand::all();
        return view('admin.product.index', [
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'brands' => $brands,
        ]);
    }
    public function getsubcategory(Request $request)
    {
        $str = '<option value="">Select Category</option>';
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        foreach ($subcategories as $subcategory) {
            $str .= '<option value="' . $subcategory->id . '">' . $subcategory->sub_category . '</option>';
        }
        echo $str;
    }
    public function product_stroe(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'brand' => 'required',
            'product_name' => 'required',
            'product_price' => 'required',
            'discout' => 'required',
            'tags' => 'nullable',
            'short_desp' => 'nullable',
            'long_desp' => 'nullable',
            'addi_info' => 'nullable',
            'preview' => 'required|image',
            'gallery.*' => 'required|image',
        ]);
        $logo = $request->preview;
        $file_name = Str::lower(str_replace(' ', '_', $request->product_name)) . random_int(5000, 50000) . time() . '.' . $logo->getClientOriginalExtension();
        $logo->move(public_path('uploads/product/preview/'), $file_name);

        $Product_id = Product::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->sub_category_id,
            'brand_id' => $request->brand,
            'product_name' => $request->product_name,
            'price' => $request->product_price,
            'discount' => $request->discout,
            'after_discount' => $request->product_price - ($request->product_price * $request->discout / 100),
            'tags' => implode($request->tags),
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'addi_info' => $request->addi_info,
            'preview' => $file_name,
            'created_at' => Carbon::now(),
        ]);



        $gallerys = $request->gallery;
        foreach ($gallerys as $gallery) {
            $file_name = Str::lower(str_replace(' ', '_', $request->product_name)) . random_int(5000, 50000) . time() . '.' . $gallery->getClientOriginalExtension();
            echo $file_name . '<br>';
            $gallery->move(public_path('uploads/product/gallery/'), $file_name);
            ProductGallery::insert([
                'product_id' => $Product_id,
                'gallery' => $file_name,
                'created_at' => Carbon::now(),
            ]);
        }


        return back()->with('prodect_add', 'New Product Add Successfully!');
    }
    public function product_list(){
        $products = Product::all();
        return view('admin.product.list',[
            'products' => $products,
        ]);
    }
    public function getstatus(Request $request){
       Product::find($request->product_id)->update([
        'status' => $request->status,
       ]);
       
    }
}
