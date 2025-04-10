<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function welcome(){
        $banners = Banner::all();
        $categories = Category::all();
        return view('frontend.index',[
            'banners' => $banners,
            'categories' => $categories,
        ]);
    }
}
