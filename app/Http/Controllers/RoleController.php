<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function role_manage()
    {
        $users = User::all();
        $permissions = Permission::all();
        $roles = Role::all();
        return view('admin.role.index', [
            'permissions' => $permissions,
            'roles' => $roles,
            'users' => $users,
        ]);
    }
    public function permission_store(Request $request)
    {
        $request->validate([
            'permission_name' => 'required',
        ]);
        $permission = Permission::create(['name' => $request->permission_name]);
        return back()->with('permission_add', 'Permission Added Successfully!');
    }
    public function role_store(Request $request)
    {
        $request->validate([
            'role_name' => 'required',
            'permission' => 'required|array',
        ]);
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back()->with('role_add', 'Role Added Successfully!');
    }
    public function role_delete($id){
        $role = Role::find($id);
        DB::table('role_has_permissions')->where('role_id', $id)->delete();
        $role->delete();
        return back()->with('role_delete', 'Role Delete Successfully!');
    }
    public function role_edit($id){
        $permissions = Permission::all();
        $roles = Role::find($id);
        return view('admin.role.edit',[
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }
    public function role_update(Request $request, $id){
        $roles = Role::find($id);
        $roles->syncPermissions([$request->permission]);
        return back()->with('role_update', 'Role Updated Successfull!');
    }
    public function assign_role(Request $request){
        $request->validate([
            'user_id' => 'required',
            'role' => 'required',
        ]);
        $user = User::find($request->user_id);
        $user->assignRole($request->role);
        return back()->with('assign_rol', 'Role Assign Successfully!');
    }
    public function user_role_delete($id){
        $user = User::find($id);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        return back()->with('user_role_delete', 'User Role Delete Successfully!');
    }
}   
