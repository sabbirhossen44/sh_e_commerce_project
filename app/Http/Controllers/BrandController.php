<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function brand()
    {
        $brands = Brand::all();
        return view('admin.brand.brand', [
            'brands' => $brands,
        ]);
    }
    public function brand_store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|unique:brands,brand_name',
            'brand_logo' => 'required|image',
        ]);
        $logo = $request->brand_logo;
        $file_name = Str::lower(str_replace(' ', '_', $request->brand_name)) . random_int(5000, 50000) . time() . '.' . $logo->getClientOriginalExtension();
        $logo->move(public_path('uploads/brand/'), $file_name);
        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_logo' => $file_name,
            'created_at' =>Carbon::now(),
        ]);
        return back()->with('brand_add', 'Brand Add Successfully!');
    }
}
