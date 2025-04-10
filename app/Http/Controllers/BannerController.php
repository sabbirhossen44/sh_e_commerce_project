<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BannerController extends Controller
{
    public function banner()
    {
        $categories = Category::all();
        $banners = Banner::all();
        return view('admin.banner.index', [
            'categories' => $categories,
            'banners' => $banners,
        ]);
    }
    public function banner_store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'category_id' => 'required',
        ]);
        $image = $request->file('image');
        $file_name = 'banner' . random_int(5000, 60000) . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/banner/'), $file_name);
        Banner::insert([
            'title' => $request->title,
            'image' => $file_name,
            'category_id' => $request->category_id,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('banner_add', 'Banner Content Add Successfully!');
    }
    public function banner_edit(Request $request, $id)
    {
        $banner = Banner::find($id);
        return view('admin.banner.edit', compact('banner'));
    }
    public function banner_update(Request $request, $id)
    {
        $request->validate([
            'banner_text' => 'required',
            'banner_images' => 'nullable|image'
        ]);
        $banners = Banner::find($id);
        if ($request->hasFile('banner_images')) {
            $file_path = public_path('uploads/banner/' . $banners->image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $image = $request->file('banner_images');
            $file_name = 'banner' . random_int(5000, 60000) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banner/'), $file_name);
            $banners->update([
                'image' => $file_name,
            ]);
        }
        $banners->update([
            'title' => $request->banner_text,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('banner_update', 'Banner Update Successfully!');
    }
    public function banner_delete($id)
    {
        $banners = Banner::find($id);
        $file_path = public_path('uploads/banner/' . $banners->image);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $banners->delete();
        return back()->with('banner_delete', 'Banner Delete Successfully!');
       

    }
}
