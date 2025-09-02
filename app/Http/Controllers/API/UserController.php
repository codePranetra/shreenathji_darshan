<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request){
        // if(!checkPermission("Users","list")){
        //     return response()->json(['message' => 'Permission Denied'], 403); 
        //  }
        try {
            $users = User::where('flag', 0)->with('role')->orderBy('id', 'desc')->get();

            foreach ($users as $user) {
                $user->role_name = $user->role->name;
                unset($user->role);
            }
            return response()->json(['data' => $users], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching users.', 'message' => $e->getMessage()], 500);
        }  
    }

    public function store(Request $request){
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => [
                        'required',
                        'string',
                        Rule::unique('users', 'name')->where(function ($query) {
                            return $query->where('flag', 0);  // Only consider names with flag = 0 for uniqueness
                        })
                    ],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        Rule::unique('users', 'email')->where(function ($query) {
                            return $query->where('flag', 0);  // Only consider names with flag = 0 for uniqueness
                        })
                    ],
                    'password'     =>  'required|string|min:6',
                    'role_id'      =>  'required',
                ],
                [
                    'name.required'     =>  "Name is required",
                    'password.required' =>  "Password is required",
                    'password.min'      =>  "Password must be of atleast 6 characters",
                    'role_id.required'  =>  "Role is required",
                    'email.required'    =>  "email name is required",
                ]
            );
            
            if ($validator->fails()) {
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
           
            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'role_id'           => $request->role_id,
            ]);

            // assingPermission($request->role_id, $user->id);

            $response = array();
            $response['data'] = $user;
            $response['message'] = 'User created successfully';  
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

    public function getUserById($id){
        try {
            $user = User::where('id', $id)->first();

            $response = array();
            $response['data'] = $user;
            $response['message'] = 'User fetched successfully';  
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

    public function update(Request $request, $id){
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => ['required','string'],
                    'email' => ['required','string','email'],
                    'password'     =>  'required|string|min:6',
                    'role_id'      =>  'required',
                ],
                [
                    'name.required'     =>  "Name is required",
                    'password.required' =>  "Password is required",
                    'password.min'      =>  "Password must be of atleast 6 characters",
                    'role_id.required'  =>  "Role is required",
                    'email.required'    =>  "email name is required",
                ]
            );
    
            if ($validator->fails()) {
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
            }
        
            $user = User::findOrFail($id);
            
            $user->name             = $request->name;
            $user->role_id          = $request->role_id;
            $user->email            = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            // if($user->role_id != $request->role_id) {
            //     DB::table('user_has_permissions')->where('user_id', $user->id)->delete();
            //     assingPermission($request->role_id, $user->id);
            // }
            $response = array();
            $response['data'] = $user;
            $response['message'] = 'User updated successfully';  
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


    public function destroy($id){
        try {
            $user = User::findOrFail($id);
            $user->flag = 1;
            $user->save();

            $response = array();
            $response['data'] = $user;
            $response['message'] = 'User deleted successfully.';  
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
