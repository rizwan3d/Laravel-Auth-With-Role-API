<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
     public function creatPermissions(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $name = $request['name'];

        $permission = Permission::where('name', $name)->first();

        if($permission){
            return response(['message' => "Permission allrady existy."], 422);
        }

        $permission = Permission::create(['name' => $name]);
        if ($permission) {
            return response(['message' => "Permission created sucessfuly."], 200);
        } else {
            return response(["message" => "Unable to create Permission."], 422);
        }
    }


     public function deletePermissions(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $name = $request['name'];

        $permission = Permission::where('name', $name)->first();

        if($permission){
            $permission->delete();
            return response(['message' => "Permission delted sucessfully."], 200);
        }
        else{
            return response(['message' => "Permission cannot existy."], 422);
        }
    }


    public function assignPermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|max:255',
            'permission' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $rolename = $request['role'];
        $permissionname = $request['permission'];

        $role = Role::where('name', $rolename)->first();
        if($role)
        {
            $permission = Permission::where('name', $permissionname)->first();
            if($permission)
            {
                $role->givePermissionTo($permissionname);
                return response(['message' => "Permission assignerd sucessfully."], 200);
            }
            else
                return response(['message' => "Permission cannot existy."], 422);
        }
        else
        {
            return response(['message'=> "Role cannot exist"], 422);
        }
    }

    public function revokePermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|max:255',
            'permission' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $rolename = $request['role'];
        $permissionname = $request['permission'];

        $role = Role::where('name', $rolename)->first();
        if($role)
        {
            $permission = Permission::where('name', $permissionname)->first();
            if($permission)
            {
                $role->revokePermissionTo($permissionname);
                return response(['message' => "Permission revoked sucessfully."], 200);
            }
            else
                return response(['message' => "Permission cannot existy."], 422);
        }
        else
        {
            return response(['message'=> "Role cannot exist"], 422);
        }
    }
}
