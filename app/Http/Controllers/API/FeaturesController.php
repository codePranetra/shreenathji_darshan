<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class FeaturesController extends Controller
{
        public function index(Request $request){
        try {
            $features = Feature::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->get();

            $response = array();
            $response['data'] = $features;
            $response['message'] = 'Features fetched successfully';  
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
                    'title' => [
                        'required',
                        'string',
                        Rule::unique('features', 'title')->where(function ($query) {
                            return $query->where('is_deleted', 0);  // Only consider names with flag = 0 for uniqueness
                        })
                    ]
                ],
                [
                    'title.required'     => "Title is required",
                    'title.unique'       => "Title already exists",
                    'title.string'       => "Title must be a string",
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
            $icon = '';
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $icon = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/features/'), $icon);
            }
           
            $feature = Feature::create([
                'title'             => $request->title,
                'icon'              => $icon,
            ]);

            // assingPermission($request->role_id, $user->id);

            $response = array();
            $response['data'] = $feature;
            $response['message'] = 'Feature Added successfully';  
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

    public function getFeatureById($id){
        try {
            $feature = Feature::where('is_active', 1)->where('is_deleted', 0)->where('id', $id)->first();


            $response = array();
            $response['data'] = $feature;
            $response['message'] = 'Feature fetched successfully';  
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
                    'title' => ['required','string']
                ],
                [
                    'title.required'     =>  "Title is required",
                    'title.string'       =>  "Title must be a string",
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
        
            $feature = Feature::find($id);

            if(!$feature){
                $response = array();
                $response['data'] = [];
                $response['message'] = 'Feature not found';  
                $response['code'] = 404;
                return response()->json($response, 404);
            }
            
            $feature->title         = $request->title;

            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $icon = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/features/'), $icon);
                $feature->icon = $icon;
            }
            $feature->save();


            
            $response = array();
            $response['data'] = $feature;
            $response['message'] = 'Feature updated successfully';  
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
            $feature = Feature::findOrFail($id);
            $feature->is_deleted = 1;
            $feature->save();

            $response = array();
            $response['data'] = $feature;
            $response['message'] = 'Feature deleted successfully.';  
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
