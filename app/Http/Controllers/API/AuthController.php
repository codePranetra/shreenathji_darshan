<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
// use App\Models\AuditLog;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
    */

     public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'      =>  'required|string',
                'email'     =>  'required|email|string',
                'password'  =>  'required|string|min:6',
                'role'      =>  'required',
            ],
            [
                'name.required'     =>  "Name is required",
                'email.required'    =>  "Email is required",
                'email.email'       =>  "Email must be of type email",
                'password.required' =>  "Password is required",
                'password.min'      =>  "Password must be of atleast 6 characters",
                'role.required'     =>  "Role is required",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // return $request->all();

        $user = User::create([
            'name'       => "admin",
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role_id'    => $request->role,
        ]);
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        // Validate the request inputs
        $validator = Validator::make(
            $request->all(),
            [
                'email'  => 'required',
                'password'      =>  'required|string|min:6',
            ],
            [
                'email.required'          => "Email is required",
                'password.required'       => "Password is required",
                'password.min'            => "Password must be of at least 6 characters",
            ]
        );

        // Check if the validation fails
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

        $logincredentials = array();
            $logincredentials['email'] = $request->email;
            $logincredentials['password'] = $request->password;


        // Attempt to authenticate the user
        if (!Auth::attempt($logincredentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retrieve the authenticated user
        $user = Auth::user();
        $role = Role::find($user->role_id);
        $token =  $user->createToken('TestApp')->accessToken;

        $data = array();
        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['role'] = $user->role_id;
        $data['role_name'] = $role->name;
        $data['token'] = $token;
        $data['account_number'] = $user->account_number;

        $response = array();
        
        $response['data'] = $data;
        $response['message'] = 'User logged in successfully';  
        $response['code'] = 200;

        return response()->json($response, 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ],
        [
            'email.required' => 'Email is required',
            'email.email' => 'Email must be of type email',
            'email.exists' => 'Email does not exist',
        ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        $name = $substring = substr($user->name, 0,5);

        $otp = rand(1000, 9999);

        $password = $name.$otp;
        $oldPasswordHash = $user->password;

        $user->password = Hash::make($password);

        $user->save();

        AuditLog::create([
            'model_name' => 'User',
            'model_id' => $user->id,
            'action' => 'Password Reset',
            'user_id' => auth()->check() ? auth()->user()->id : $user->id,
            'old_values' => json_encode(['password' => $oldPasswordHash]),
            'new_values' => json_encode(['password' => $user->password]),
        ]);

        Mail::to($user->email)->send(new OtpMail($password));

        return response()->json(['message' => 'Password has been reset successfully'], 200);
        
    }
}
