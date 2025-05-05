<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function category()
    {
        $categories = Category::paginate(10);
        return view('admin.category.category', compact('categories'));
    }
    public function category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'icon' => 'required',
        ]);
        $icon = $request->file('icon');
        $file_name = str::lower(str_replace(' ', '_', $request->category_name)) . random_int(5000, 60000) . time() . '.' . $icon->getClientOriginalExtension();
        $icon->move(public_path('uploads/category/'), $file_name);
        Category::insert([
            'category_name' => $request->category_name,
            'icon' => $file_name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('category_add', 'Category added successfully');
    }
    public function category_soft_delete($category_id)
    {
        Category::find($category_id)->delete();
        return back()->with('category_soft_delete', 'Category deleted successfully');
    }
    public function category_trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.trash', compact('categories'));
    }
    public function category_restore($category_id)
    {
        $category = Category::onlyTrashed()->find($category_id);

        if (!$category) {
            return back()->with('category_restore_error', 'Category not found in trash!');
        }

        $category->restore();
        return back()->with('category_restore', 'Category restored successfully');
    }
    public function parmarent_delete($category_id)
    {
        $cat = Category::onlyTrashed()->find($category_id);
        $cat_img = public_path('uploads/category/' . $cat->icon);
        unlink($cat_img);
        Category::onlyTrashed()->find($category_id)->forceDelete();
        Subcategory::where('category_id', $category_id)->update([
            'category_id' => 1,
        ]);
        return back()->with('category_permanent_delete', 'Category permanently deleted successfully');
    }
    public function category_edit($category_id)
    {
        $category = Category::find($category_id);
        return view('admin.category.edit', [
            'category' => $category,
        ]);
    }
    public function category_update(Request $request, $category_id)
    {
        $request->validate([
            'category_name' => 'required',
            'icon' => 'image|nullable'
        ]);
        if ($request->icon == '') {
            Category::find($category_id)->update([
                'category_name' => $request->category_name,
            ]);
            return back()->with('category_update', 'Category update successfully');
        } else {
            $cat = Category::find($category_id);
            $cat_img = public_path('uploads/category/' . $cat->icon);
            unlink($cat_img);
            $icon = $request->file('icon');
            $file_name = str::lower(str_replace(' ', '_', $request->category_name)) . random_int(5000, 60000) . time() . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('uploads/category/'), $file_name);
            Category::find($category_id)->update([
                'category_name' => $request->category_name,
                'icon' => $file_name,
            ]);
            return back()->with('category_update', 'Category update successfully');
        }
    }
    public function checked_delete(Request $request)
    {
        foreach ($request->category_id as $category) {
            Category::find($category)->delete();
        }
        return back()->with('soft_delete', 'Category Move To Trash Successfully!');
    }
    public function checked_restore(Request $request)
    {
        if ($request->input('action') == 'restore') {
            foreach ($request->category_id as $category) {
                Category::onlyTrashed()->find($category)->restore();
            }
            return back()->with('soft_restore', 'Category Restore Successfully!');
        }
        if ($request->input('action') == 'delete') {
            foreach ($request->category_id as $category) {
                Category::onlyTrashed()->find($category)->forceDelete();
            }
            return back()->with('category_permanent_delete', 'Selected categories have been permanently deleted.');
        }
    }
}
