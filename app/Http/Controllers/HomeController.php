<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }
    public function user_list(){
        $users = User::where('id', '!=', Auth::id())->get();
        // return $abc;
        return view('admin.user.user_list', compact('users'));
    }
    public function user_delete($user_id){
        $user = User::find($user_id);
        $user->delete();
        return back()->with('user_delete', 'User deleted successfully');
    }
    public function user_add(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return back()->with('user_add', 'User added successfully');
    }
}
