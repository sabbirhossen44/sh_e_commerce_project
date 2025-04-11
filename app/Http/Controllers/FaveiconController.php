<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faveicon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FaveiconController extends Controller
{
    public function faveicon_store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'faveicon_logo' => 'required|image'
        ]);
        if ($request->hasFile('faveicon_logo')) {
            $icon = $request->file('faveicon_logo');
            $file_name = 'banner' . random_int(5000, 60000) . time() . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('uploads/faveicon/'), $file_name);
            Faveicon::insert([
                'title' => $request->title,
                'logo' => $file_name,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('faveicon_add', 'Faveicon Add Successfully!');
        }
    }
    public function getstatus_faveicon(Request $request){
        Faveicon::find($request->faveicon_id)->update([
            'status' => $request->status,
        ]);
    }
    public function faveicon_edit($id){
        $faveicon = Faveicon::find($id);
        return view('admin.faveicon.edit',[
            'faveicon' => $faveicon,
        ]);
    }
    public function faveicon_update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'logo' => 'nullable|image'
        ]);
        $faceicon = Faveicon::find($id);
        if($request->hasFile('logo')){
            $file_path = public_path('uploads/faveicon'.$faceicon->logo);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $icon = $request->file($id);
            $file_name = 'banner' . random_int(5000, 60000) . time() . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('uploads/faveicon/'), $file_name);
            $faceicon->update([
                'logo' => $file_name,
            ]);
        }
        $faceicon->update([
            'title'=>$request->title,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('faveion_update', 'Faveicon Update Successfully!');
    }
    public function faveicon_delete($id){
        $faveicon = Faveicon::find($id);
        $logo_file = public_path('uploads/faveicon/'. $faveicon->logo);
        if(file_exists($logo_file)){
            unlink($logo_file);
        }
        $faveicon->delete();
        return back()->with('faveicon_delete', 'Faveicon Delete Successfully!');
    }
}
