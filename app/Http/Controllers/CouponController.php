<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CouponController extends Controller
{
    public function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',[
            'coupons' => $coupons,
        ]);
    }
    public function coupon_store(Request $request){
        $request->validate([
            'coupon' => 'required|unique:coupons',
            'type' => 'required',
            'amount' => 'required',
            'validity' => 'required',
            'limit' => 'required',
        ]);
        Coupon::insert([
            'coupon' => $request->coupon,
            'type' => $request->type,
            'amount' => $request->amount,
            'validity' => $request->validity,
            'limit' => $request->limit,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success', 'Coupon Added Successfully');
    }
    public function couponstatus(Request $request){
        Coupon::find($request->coupon_id)->update([
            'status' => $request->status,
        ]);
    }
    public function coupon_edit($id){
        $coupon= Coupon::find($id);
        return view('admin.coupon.edit',[
            'coupon' => $coupon,
        ]);
    }
    public function coupon_update(Request $request, $id){
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'validity' => 'required',
            'limit' => 'required',
        ]);
        Coupon::find($id)->update([
            'type' => $request->type,
            'amount' => $request->amount,
            'validity' => $request->validity,
            'limit' => $request->limit,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('success', 'Coupon Updated Successfully');
    }
    public function coupon_delete($id){
        Coupon::find($id)->delete();
        return back()->with('coupon_delete', 'Coupon Deleted Successfully!');
        
    }
}
