<?php
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserHasPermission;
use App\Models\Role;



function assingPermission($role, $user_id)
    {
        $role = Role::where('id', $role)->first();
        $role_permission = RolePermission::where('role_id', $role->id)->with('permission')->get();
        if (!empty($role_permission)) {
            foreach ($role_permission as $permission) {
                $permission_id = $permission->permission->id;
                if (UserHasPermission::where(['role_id' => $role->id, 'permission_id' => $permission_id, 'user_id' => $user_id,])->first() != true) {
                    UserHasPermission::create([
                        'role_id'   =>  $role->id,
                        'permission_id' => $permission_id,
                        'user_id'   =>  $user_id,
                    ]);
                }
            }
        }
    }

function checkPermission($name1, $action1){
    $user = Auth::user();
    if(!empty($user)){
        $rolehaspermissions = UserHasPermission::where('user_id',$user->id)->with('permission')->get();
        foreach ($rolehaspermissions as  $rolehaspermission) {
            if(!empty($rolehaspermission->permission)) {
                $permission = array(); 
                $name = $rolehaspermission->permission->name;
                $action = $rolehaspermission->permission->action;
                $permission[] = $name;
                $permission[] = $action;
            }
            if($name1 == $name && $action1== $action){
                return true;
            }
        }
    }
    return false;
}

/*
UPS API Helpers
*/ 

