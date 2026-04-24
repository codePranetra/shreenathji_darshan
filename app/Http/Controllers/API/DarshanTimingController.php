<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DarshanTiming;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DarshanTimingController extends Controller
{
        public function index(Request $request){
            try {
                $darshanTimings = DarshanTiming::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->get();

                $response = array();
                $response['data'] = $darshanTimings;
                $response['message'] = 'Darshan Timings fetched successfully';  
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
                $request->validate([
                    'start_time' => 'nullable|date_format:H:i:s',
                    'end_time' => 'nullable|date_format:H:i:s',
                    'title' => 'nullable|string',
                    'type' => 'nullable|in:morning,afternoon,evening',
                ], [
                    'start_time.date_format' => 'Start time must be a valid time',
                    'end_time.date_format' => 'End time must be a valid time',
                    'title.string' => 'Title must be a string',
                    'type.in' => 'Type must be one of the following: morning, afternoon, evening',
                ]);

                $darshanTiming = DarshanTiming::create([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'title' => $request->title,
                    'type' => $request->type,
                ]);

                $response = array();
                $response['data'] = $darshanTiming;
                $response['message'] = 'Darshan Timing created successfully';  
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
        public function getDarshanTimingById($id){
            try {
                $darshanTiming = DarshanTiming::where('is_active', 1)->where('is_deleted', 0)->where('id', $id)->first();
                $response = array();
                $response['data'] = $darshanTiming;
                $response['message'] = 'Darshan Timing fetched successfully';
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
                        'start_time' => 'nullable|date_format:H:i:s',
                        'end_time' => 'nullable|date_format:H:i:s',
                        'title' => 'nullable|string',
                        'type' => 'nullable|in:morning,afternoon,evening',
                    ],
                    [
                        'start_time.date_format' => 'Start time must be a valid time',
                        'end_time.date_format' => 'End time must be a valid time',
                        'title.string' => 'Title must be a string',
                        'type.in' => 'Type must be one of the following: morning, afternoon, evening',
                    ]
                );
                if ($validator->fails()) {
                    $response = array();
                    $response['data'] = [];
                    $response['message'] = $validator->errors()->first();  
                    $response['code'] = 400;
                    return response()->json($response, 400);
                }
                $darshanTiming = DarshanTiming::find($id);
                if(!$darshanTiming){
                    $response = array();
                    $response['data'] = [];
                    $response['message'] = 'Darshan Timing not found';  
                    $response['code'] = 404;
                    return response()->json($response, 404);
                }
                $darshanTiming->start_time = $request->start_time;
                $darshanTiming->end_time = $request->end_time;
                $darshanTiming->title = $request->title;
                $darshanTiming->type = $request->type;
                $darshanTiming->save();
                $response = array();
                $response['data'] = $darshanTiming;
                $response['message'] = 'Darshan Timing updated successfully';  
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
                $darshanTiming = DarshanTiming::findOrFail($id);
                $darshanTiming->is_deleted = 1;
                $darshanTiming->save();

                $response = array();
                $response['data'] = [];
                $response['message'] = 'Darshan Timing deleted successfully';  
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
