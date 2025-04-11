<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faveicon;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LogoController extends Controller
{
    public function logo()
    {
        $faveicons = Faveicon::all();
        $logos = Logo::all();
        return view('admin.logo.index',[
            'faveicons' => $faveicons,
            'logos' => $logos,
        ]);
    }
    public function logo_store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image'
        ]);
        if ($request->hasFile('logo')) {
            $icon = $request->file('logo');
            $file_name = 'banner' . random_int(5000, 60000) . time() . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('uploads/logo/') ,$file_name);
            Logo::insert([
                'logo' => $file_name,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('logo_add', 'Logo Add Successfully!');
        }
    }
    public function getstatus_logo(Request $request){
        Logo::find($request->logo_id)->update([
            'status' => $request->status,
        ]);
    }
    public function logo_delete($id){
        $logo = Logo::find($id);
        $logo_file = public_path('uploads/logo/'. $logo->logo);
        if(file_exists($logo_file)){
            unlink($logo_file);
        }
        $logo->delete();
        return back()->with('logo_delete', 'Logo Delete Successfully!');
    }
}
