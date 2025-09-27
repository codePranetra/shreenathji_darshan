<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
        public function index(Request $request){
            try {
                $packages = Package::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->get();
                // 
                $response = array();
                $response['data'] = $packages;

                $response['message'] = 'Packages fetched successfully';  
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
            try {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => [
                            'required',
                            'string',
                            Rule::unique('packages', 'name')->where(function ($query) {
                                return $query->where('is_deleted', 0);  // Only consider names with flag = 0 for uniqueness
                            })
                        ],
                        'price' => 'required|numeric',
                        'description' => 'nullable|string',
                    ],
                    [
                        'name.required'     => "Name is required",
                        'name.unique'       => "Name already exists",
                        'name.string'       => "Name must be a string",
                        'price.required'    => "Price is required",
                        'price.numeric'     => "Price must be a number",
                        'description.string'=> "Description must be a string",
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

                $package = Package::create([
                    'name' => $request->name,
                    'price' => $request->price,
                    'description' => $request->description,
                ]);

                $response = array();
                $response['data'] = $package;
                $response['message'] = 'Package created successfully';  
                $response['code'] = 201;

                return response()->json($response, 201);
            } catch (Exception $e) {
                $response = array();
                $response['data'] = [];
                $response['message'] = $e->getMessage();  
                $response['code'] = 500;
                return response()->json($response, 500);
            }  
        }

        public function getPackageById($id){
            try {
                $package = Package::where('is_active', 1)->where('is_deleted', 0)->where('id', $id)->first();
                $response = array();
                $response['data'] = $package;
                $response['message'] = 'Package fetched successfully';
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
                        'name' => [
                            'required',
                            'string',
                            Rule::unique('packages', 'name')->where(function ($query) {
                                return $query->where('is_deleted', 0);  // Only consider names with flag = 0 for uniqueness
                            })->ignore($id)
                        ],
                        'price' => 'required|numeric',
                        'description' => 'nullable|string',
                    ],
                    [
                        'name.required'     => "Name is required",
                        'name.unique'       => "Name already exists",
                        'name.string'       => "Name must be a string",
                        'price.required'    => "Price is required",
                        'price.numeric'     => "Price must be a number",
                        'description.string'=> "Description must be a string",
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

                $package = Package::where('id', $id)->where('is_active', 1)->where('is_deleted', 0)->first();
                if(!$package){
                    $response = array();
                    $response['data'] = [];
                    $response['message'] = 'Package not found';  
                    $response['code'] = 404;
                    return response()->json($response, 404);
                }

                $package->name = $request->name;
                $package->price = $request->price;
                $package->description = $request->description;
                $package->save();

                $response = array();
                $response['data'] = $package;
                $response['message'] = 'Package updated successfully';  
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
                $package = Package::findOrFail($id);
                $package->is_deleted = 1;
                $package->save();

                $response = array();
                $response['data'] = [];
                $response['message'] = 'Package deleted successfully';  
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
    


