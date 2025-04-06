<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\size;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InventoryController extends Controller
{
    public function add_inventory($id){
        $colors = Color::all();
        $product = Product::find($id);
        $inventories = Inventory::where('product_id', $id)->get();
        return view('admin.product.inventory',[
            'colors' => $colors,
            'product' => $product,
            'inventories' => $inventories,
        ]);
    }
    public function inventory_store(Request $request, $id){
        Request()->validate([
            'color_id' => 'required',
            'size_id' => 'required',
            'quentity' => 'required',
        ]);
        Inventory::insert([
            'product_id' => $id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quentity' => $request->quentity,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('inventory_insert', 'Inventory Add Successfully!');
    }
    public function inventory_delete($id){
        Inventory::find($id)->delete();
        return back()->with('inventory_delete', 'Inventory Delete Successfully!');
    }
}
