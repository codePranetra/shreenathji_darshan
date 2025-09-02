<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserHasPermission;
use App\Models\User;
use Exception;
use App\Models\AuditLog;
class PermissionController extends Controller
{
    public function permissions(){
        try {
            $permissions = Permission::select('id', 'name', 'action')->get();

            $response = array();
            $response['data'] = $permissions;
            $response['message'] = 'Permissions fetched successfully';  
            $response['code'] = 200;
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;
            return response()->json($response, 500);
        }  
    }

    public function role_has_permissions($id){
        try {
            $permissions = RolePermission::select('permission_id', 'role_id')->where('role_id', $id)->get();

            $response = array();
            $response['data'] = $permissions;
            $response['message'] = 'Permissions fetched successfully';  
            $response['code'] = 200;
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;
            return response()->json($response, 500);
        }  
    }

    public function user_has_permissions($id){
        try {
            $permissions = UserHasPermission::select('permission_id', 'role_id', 'user_id')->where('user_id', $id)->with('permission')->get();

            foreach ($permissions as $permission) {
                $permission->name = $permission->permission->name;
                $permission->action = $permission->permission->action;
                unset($permission->permission);
            }

            $response = array();
            $response['data'] = $permissions;
            $response['message'] = 'Permissions fetched successfully';  
            $response['code'] = 200;
            return response()->json($response, 200);

        } catch (Exception $e) {
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;
            return response()->json($response, 500);
        }  
    }

    public function store_user_has_permissions(Request $request){
        try {
            UserHasPermission::where('user_id', $request->user_id)->delete();

            $role = User::find($request->user_id); 
            
            foreach ($request->permission_ids as $permission) {
                
               UserHasPermission::create([
                    'role_id' => $role->role_id,
                    'user_id' => $request->user_id,
                    'permission_id' => $permission
                ]);
            }

            $response = array();
            $response['data'] = [];
            $response['message'] = 'Permission Updated';  
            $response['code'] = 200;
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;
            return response()->json($response, 500);
        }  
    }

    public function store_role_has_permissions(Request $request){
        try {
            RolePermission::where('role_id', $request->role_id)->delete();

            foreach ($request->permission_ids as $permission) {
                RolePermission::create([
                    'role_id' => $request->role_id,
                    'permission_id' => $permission
                ]);
            }
            $response = array();
            $response['data'] = [];
            $response['message'] = 'Permission Updated';  
            $response['code'] = 200;

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;
            return response()->json($response, 500);
        }  
    }

    public function distinct_permissions(){
        try {
            $permissions = Permission::select('name')->groupBy('name')->get();

            $response = array();
            $response['data'] = $permissions;
            $response['message'] = 'Permission fetched successfully';  
            $response['code'] = 200;

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;
            return response()->json($response, 500);
        }  
    }
}
