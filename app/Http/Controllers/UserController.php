<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\fileExists;

class UserController extends Controller
{
    public function admin()
    {
        return view('layouts.admin');
    }
    public function user_info()
    {
        return view('admin.user.profile');
    }
    public function user_info_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        User::find(Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return back()->with('user_update', 'Profile updated successfully!');
    }
    public function user_password_update(UserRequest $request)
    {
        if (Hash::check($request->old_password, Auth::user()->password)) {
            User::find(Auth::id())->update([
                'password' => bcrypt($request->password),
            ]);
            return back()->with('password_update', 'Password updated successfully!');
        } else {
            return back()->with('password_not_match', 'Old password not match!');
        }
    }
    public function user_photo_update(Request $request)
    {
        //    return back()->with('photo_update', 'Photo updated disable!');
        $request->validate([
            'photo' => 'required|image',
        ]);
        
        $user = Auth::user(); // Get logged-in user
        
        if ($user->photo) {
            // **Delete old photo**
            $image_path = public_path('uploads/user/' . $user->photo);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        // **Upload new photo**
        $photo = $request->file('photo');
        $photo_name = 'user' . Auth::id() . time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('uploads/user/'), $photo_name);
        
        // **Update user photo in database**
        User::find(Auth::id())->update([
            'photo' => $photo_name,
            'updated_at' => now(),
        ]);
        
        return back()->with('photo_update', 'Photo updated Successfully!');
        

    }
}
