<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request){
        try {
            $Roles = Role::select('id', 'name')->where('flag', 0)->get();

            $response = array();
            $response['data'] = $Roles;
            $response['message'] = 'Roles fetched successfully';  
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

    public function getById($id){
        try {
            $roles = Role::select('id', 'name')->where('flag', 0)->where('id', $id)->get();

            $response = array();
            $response['data'] = $roles;
            $response['message'] = 'Role fetched successfully';  
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

    public function store(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'name' => [
                        'required',
                        'string',
                        Rule::unique('roles', 'name')->where(function ($query) {
                            return $query->where('flag', 0);  // Only consider names with flag = 0 for uniqueness
                        })
                    ],
                ],[
                    'name.required' => "Name is required",
                ]
             );
             if($validator->fails()){
                $response = array();
                $errors = collect(); // Initialize an empty collection for errors
                if ($validator->errors()->any()) {
                    foreach ($validator->errors()->all() as $error) { // Use all() to get all error messages
                        $errors->push($error); // Push each error into the collection
                    }
                }

                $response['data'] = [];
                $response['message'] = $errors;  
                $response['code'] = 400;
    
                return response()->json($response, 400);
            }
            $role = Role::create([
                'name' => $request->name,
            ]);
            // new values after store 
            $response = array();
            $response['data'] = $role;
            $response['message'] = 'Role created successfully';  
            $response['code'] = 200;

            return response()->json($response, 200);
        }catch(Exception $e){
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;

            return response()->json($response, 500);
        }
    }

    public function update(Request $request, $id){
        try{
            
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|string',
                ],[
                    'name.required' => "Name is required",
                ]
             );
             if($validator->fails()){
                $errors = collect(); // Initialize an empty collection for errors
                if ($validator->errors()->any()) {
                    foreach ($validator->errors()->all() as $error) { // Use all() to get all error messages
                        $errors->push($error); // Push each error into the collection
                    }
                }
                $response = array();
                $response['data'] = [];
                $response['message'] = $errors;  
                $response['code'] = 400;
    
                return response()->json($response, 400);
            }

            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();

            $response = array();
            $response['data'] = $role;
            $response['message'] = 'Role updated successfully';  
            $response['code'] = 200;
            return response()->json($response, 200);

        }catch(Exception $e){
            $response = array();
            $response['data'] = [];
            $response['message'] = $e->getMessage();  
            $response['code'] = 500;
            return response()->json($response, 500);
        }
    }

    public function destroy($id){
        try {
            $role = Role::findOrFail($id);
            $role->flag = 1;
            $role->save();

            $response = array();
            $response['data'] = $role;
            $response['message'] = 'Role deleted successfully';  
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
