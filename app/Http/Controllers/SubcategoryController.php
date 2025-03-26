<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function sub_category(){
        $categories = Category::all();
        // $subcategories = Subcategory::all();
        return view('admin.subcategory.index' , [
            'categories'=>$categories,
            // 'subcategories'=>$subcategories,
        ]);
    }
    public function sub_category_store(Request $request){
        $request->validate([
            'category'=> 'required',
            'sub_category'=>'required',
        ]);
        if (Subcategory::where('category_id', $request->category)->where('sub_category', $request->sub_category)->exists()) {
            return back()->with('exist', 'Subcategory Name Already Exist in this Category');
        }else{
            Subcategory::insert([
                'category_id' => $request->category,
                'sub_category' => $request->sub_category,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('sub_category_store', 'Sub category Add successfully!');
        }
        
    }
    public function sub_category_edit($id){
        $categories = Category::all();
        $sebcategory = Subcategory::find($id);
        return view('admin.subcategory.edit',[
            'categories'=> $categories,
            'sebcategory'=>$sebcategory,
        ]);
    }
    public function sub_category_update(Request $request , $id){
        $request->validate([
            'category'=> 'required',
            'sub_category'=>'required',
        ]);
        if (Subcategory::where('category_id', $request->category)->where('sub_category', $request->sub_category)->exists()) {
            return back()->with('exist_category', 'Subcategory Name Already Exist in this Category');
        }else{
            Subcategory::find($id)->update([
                'category_id' => $request->category,
                'sub_category' => $request->sub_category,
                'created_at' => Carbon::now(),
            ]);
            return redirect()->route('sub.category')->with('sub_category_update', 'Sub category update successfully!');
        }
       
    }
    public function sub_category_delete($id){
        Subcategory::find($id)->delete();
        return back()->with('category_permanent_delete', 'sub_categories have been deleted.');
    }
}
