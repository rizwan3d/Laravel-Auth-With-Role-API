<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function creatRole(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $name = $request['name'];

        $role = Role::where('name', $name)->first();

        if($role){
            return response(['message' => "Role allrady existy."], 422);
        }

        $role = Role::create(['name' => $name ]);
        if ($role) {
            return response(['message' => "Role created sucessfuly."], 200);
        } else {
            return response(["message" => "Unable to create role."], 422);
        }
    }


     public function deletRole(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $name = $request['name'];

        $role = Role::where('name', $name)->first();

        if($role){
            $role->delete();
            return response(['message' => "Role delted sucessfully."], 200);
        }
        else{
            return response(['message' => "Role cannot existy."], 422);
        }
    }

    public function assignRole(Request $request)
    {

    }
}
