<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function role_manage(){
        return view('admin.role.index');
    }
    public function permission_store(Request $request){
        $permission = Permission::create(['name' => $request->permission_name]);
        return back()->with('permission_add', 'Permission Added Successfully!');
    }
}
