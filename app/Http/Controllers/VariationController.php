<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function variation(){
        $categories =Category::all();
        $colors = Color::all();
        return view('admin.variation.variation',[
            'categories' => $categories,
            'colors' => $colors,
        ]);
    }
    public function color_store(Request $request){
        $request->validate([
            'color_name' => 'required',
            'color_code' => 'nullable',
        ]);
        Color::insert([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('color_insert', 'Color Add Successfully!');
    }
    public function size_store(Request $request){
        $request->validate([
            'category_id' => 'required',
            'size_name' => 'required',
        ]);
        size::insert([
            'category_id' => $request->category_id,
            'size_name' => $request->size_name,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('size_insert', 'Size Add Successfully!');
    }
    
}
