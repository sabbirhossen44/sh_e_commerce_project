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
use App\Models\Inventory;

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
            'discount' => 'nullable',
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
        $remove = array("@", "#", "(",")","*", "/", " ", '""');
        $sulg = Str::lower(str_replace($remove, '-', $request->product_name)) . random_int(5000, 500000) . time();

        $Product_id = Product::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->sub_category_id,
            'brand_id' => $request->brand,
            'product_name' => $request->product_name,
            'price' => $request->product_price,
            'discount' => $request->discount,
            'after_discount' => $request->product_price - ($request->product_price * $request->discount / 100),
            'tags' => implode($request->tags),
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'addi_info' => $request->addi_info,
            'preview' => $file_name,
            'slug' => $sulg,
            'created_at' => Carbon::now(),
        ]);



        $gallerys = $request->gallery;
        foreach ($gallerys as $gallery) {
            $file_name = Str::lower(str_replace(' ', '_', $request->product_name)) . random_int(5000, 50000) . time() . '.' . $gallery->getClientOriginalExtension();
            $gallery->move(public_path('uploads/product/gallery/'), $file_name);
            ProductGallery::insert([
                'product_id' => $Product_id,
                'gallery' => $file_name,
                'created_at' => Carbon::now(),
            ]);
        }


        return back()->with('prodect_add', 'New Product Add Successfully!');
    }
    public function product_list()
    {
        $products = Product::all();
        return view('admin.product.list', [
            'products' => $products,
        ]);
    }
    public function getstatus(Request $request)
    {
        Product::find($request->product_id)->update([
            'status' => $request->status,
        ]);
    }
    public function product_edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        $product_gallery = ProductGallery::where('product_id', $id)->get();
        $categoriesid = Category::where('id', $product->category_id)->first();
        $sub_categoriesid = Subcategory::where('id', $product->subcategory_id)->first();
        $sub_categories = Subcategory::all();
        $brands = Brand::all();
        $brandsid = Brand::where('id', $product->brand_id)->first();
        return view('admin.product.edit', [
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'brands' => $brands,
            'sub_categoriesid' => $sub_categoriesid,
            'product' => $product,
            'brandsid' => $brandsid,
            'categoriesid' => $categoriesid,
            'product_gallery' => $product_gallery,
        ]);
    }
    public function ajaxDeleteGalleryImage($id)
    {
        $image = ProductGallery::findOrFail($id);

        // Delete image file
        $image_path = public_path('uploads/product/gallery/' . $image->gallery);
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete DB record
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }

    public function product_update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'brand' => 'required',
            'product_name' => 'required',
            'product_price' => 'required',
            'discount' => 'nullable',
            'tags' => 'nullable',
            'short_desp' => 'nullable',
            'long_desp' => 'nullable',
            'addi_info' => 'nullable',
            'preview' => 'nullable|image',
            'gallery.*' => 'nullable|image',
        ]);
        $product = Product::findOrFail($id);
        if ($request->hasFile('preview')) {
            $file_path = public_path('uploads/product/preview/' . $product->preview);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $logo = $request->file('preview');
            $file_name = Str::lower(str_replace(' ', '_', $request->product_name)) . random_int(5000, 50000) . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/product/preview/'), $file_name);
            Product::find($id)->update([
                'preview' => $file_name,
            ]);
        }
        $Product_id = Product::find($id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->sub_category_id,
            'brand_id' => $request->brand,
            'product_name' => $request->product_name,
            'price' => $request->product_price,
            'discount' => $request->discount,
            'after_discount' => $request->product_price - ($request->product_price * $request->discount / 100),
            'tags' => implode($request->tags),
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'addi_info' => $request->addi_info,
        ]);
        // $ProductGallery = ProductGallery::where('product_id', $id)->get();
        if ($request->hasFile('gallery')) {
            $gallerys = $request->file('gallery');
            foreach ($gallerys as $gallery) {
            $file_name = Str::lower(str_replace(' ', '_', $request->product_name)) . random_int(5000, 50000) . time() . '.' . $gallery->getClientOriginalExtension();
            $gallery->move(public_path('uploads/product/gallery/'), $file_name);
            ProductGallery::create([
                'product_id' => $id,
                'gallery' => $file_name,
                'created_at' => Carbon::now(),
            ]);
            }
        }
    
        return back()->with('prodect_update', 'Product Update Successfully!');
    }
    public function product_delete($id){
        $product = Product::findOrFail($id);
        $img_path = public_path('uploads/product/preview/'.$product->preview);
        if (file_exists($img_path)) {
            unlink($img_path);
        }
        $product_path = ProductGallery::where('product_id', $id)->get();
        foreach ($product_path as $gallery) {
            $img_file = public_path('uploads/product/gallery/'.$gallery->gallery);
            if (file_exists($img_file)) {
                unlink($img_file);
            }
        }
        Inventory::where('product_id',$id)->delete();
        Product::find($id)->delete();
        ProductGallery::where('product_id', $id)->delete();
        return back()->with('product_delete', 'Product Delete Successfully!');
    }
}
