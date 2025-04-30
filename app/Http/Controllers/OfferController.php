<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer1;
use App\Models\Offer2;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OfferController extends Controller
{
    public function offer(){
        $offer = Offer1::all();
        $offer2 = Offer2::all();
        return view('admin.offer.index', [
            'offer' => $offer,
            'offer2' => $offer2,
        ]);
    }
    public function offer1_update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'discount_price' => 'required',
            'date' => 'required',
            'image' => 'nullable|image',
        ]);
        $offer1 = Offer1::find($id);
        if($request->hasFile('image')){
            $file_name = public_path('uploads/offer/'.$offer1->image);
            if(file_exists($file_name)){
                unlink($file_name);
            }
            $image = $request->file('image');
            $image_path = 'offer1'. time() . random_int(500, 50000). '.' . $image->getClientOriginalExtension() ;
            $image->move(public_path('uploads/offer/'), $image_path);
            $offer1 -> update([
                'image' => $image_path,
            ]);
        }
        $offer1->update([
            'title' => $request->title,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'date' => $request->date,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('offer1_update', 'Your Offer Update Successfully!');
    }
    public function offer2_update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'image2' => 'nullable|image',
        ]);
        $offer2 = Offer2::find($id);
        if($request->hasFile('image2')){
            $file_name = public_path('uploads/offer/'.$offer2->image);
            if(file_exists($file_name)){
                unlink($file_name);
            }
            $image = $request->file('image2');
            $image_path = 'offer2'. time() . random_int(500, 50000). '.' . $image->getClientOriginalExtension() ;
            $image->move(public_path('uploads/offer/'), $image_path);
            $offer2 -> update([
                'image' => $image_path,
            ]);
        }
        $offer2->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('offer2_update', 'Your Offer Update Successfully!');
    }
}
