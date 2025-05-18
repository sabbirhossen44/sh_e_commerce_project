<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use App\Models\Faveicon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\webInformation;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class LogoController extends Controller
{
    public function logo()
    {
        $faveicons = Faveicon::all();
        $logos = Logo::all();
        return view('admin.logo.index', [
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
            $icon->move(public_path('uploads/logo/'), $file_name);
            Logo::insert([
                'logo' => $file_name,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('logo_add', 'Logo Add Successfully!');
        }
    }
    public function getstatus_logo(Request $request)
    {
        Logo::find($request->logo_id)->update([
            'status' => $request->status,
        ]);
    }
    public function logo_delete($id)
    {
        $logo = Logo::find($id);
        $logo_file = public_path('uploads/logo/' . $logo->logo);
        if (file_exists($logo_file)) {
            unlink($logo_file);
        }
        $logo->delete();
        return back()->with('logo_delete', 'Logo Delete Successfully!');
    }


    public function web_information_store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'top_title' => 'required',
            'footer_title' => 'required',
            'web_number' => 'required|string',
            'phone_number1' => 'nullable|string',
            'phone_number2' => 'nullable|string',
            'email1' => 'nullable|email',
            'email2' => 'nullable|email',
            'address' => 'nullable|string',
            'facebook' => 'nullable|URL',
            'instagram' => 'nullable|URL',
            'linkedin' => 'nullable|URL',
            'twitter' => 'nullable|URL',
        ]);
        $raw = preg_replace('/[\s\-_]+/', '', $request->web_number);
        if (Str::startsWith($raw, '+88')) {
            $final = $raw;
        } else {
            $clean = ltrim($raw, '0');
            $final = '+880' . $clean;
        }
        webInformation::insert([
            'top_title' => $request->top_title,
            'footer_title' => $request->footer_title,
            'web_number' => $request->web_number,
            'web_number_link' => $final,
            'phone_number1' => $request->phone_number1,
            'phone_number2' => $request->phone_number2,
            'email1' => $request->email1,
            'email2' => $request->email2,
            'address' => $request->address,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('web_info_add', 'Web Information Add Successfully!');
    }
     public function getstatus_webinfo(Request $request)
    {
        webInformation::find($request->info_id)->update([
            'status' => $request->status,
        ]);
    }
    public function webInfo_view($id){
        $webInfo = webInformation::find($id);
        return view('admin.logo.webInfo_view',[
            'webInfo' => $webInfo,
        ]);
    }
    public function webInfo_edit($id){
        $webInfo = webInformation::find($id);
        return view('admin.logo.webInfo_edit',[
            'webInfo' => $webInfo,
        ]);
    }
    public function webinfo_update(Request $request, $id){
        $request->validate([
            'top_title' => 'required',
            'footer_title' => 'required',
            'web_number' => 'required|string',
            'phone_number1' => 'nullable|string',
            'phone_number2' => 'nullable|string',
            'email1' => 'nullable|email',
            'email2' => 'nullable|email',
            'address' => 'nullable|string',
            'facebook' => 'nullable|URL',
            'instagram' => 'nullable|URL',
            'linkedin' => 'nullable|URL',
            'twitter' => 'nullable|URL',
        ]);
        $raw = preg_replace('/[\s\-_]+/', '', $request->web_number);
        if (Str::startsWith($raw, '+88')) {
            $final = $raw;
        } else {
            $clean = ltrim($raw, '0');
            $final = '+880  ' . $clean;
        }
        webInformation::find($id)->update([
            'top_title' => $request->top_title,
            'footer_title' => $request->footer_title,
            'web_number' => $request->web_number,
            'web_number_link' => $final,
            'phone_number1' => $request->phone_number1,
            'phone_number2' => $request->phone_number2,
            'email1' => $request->email1,
            'email2' => $request->email2,
            'address' => $request->address,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('web_info_update', 'Web Information Update Successfully!');
    }
}
