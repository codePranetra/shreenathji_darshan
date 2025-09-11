<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Booking;
use Exception;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $bookings = Booking::where('is_active', 1)
                ->where('is_deleted', 0)
                ->orderBy('id', 'desc')
                ->get();

            $response = [
                'data' => $bookings,
                'message' => 'Bookings fetched successfully',
                'code' => 200
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500
            ];
            return response()->json($response, 500);
        }
    }
    public function store(Request $request){
         try {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone_number' => 'required|string|max:20',
                'time' => 'required|date_format:H:i',
                'date' => 'required|date',
                'members' => 'required|integer|min:1',
                'amount' => 'required|numeric|min:0',
                'darshan_id' => 'required|exists:darshan_timings,id',
                'package_id' => 'nullable|exists:packages,id',
            ]);

            $booking = Booking::create($request->only([
                'customer_name',
                'email',
                'phone_number',
                'time',
                'date',
                'members',
                'amount',
                'darshan_id',
                'package_id'
            ]));

            $response = [
                'data' => $booking,
                'message' => 'Booking created successfully',
                'code' => 201
            ];

            return response()->json($response, 201);
        } catch (Exception $e) {
            $response = [
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500
            ];
            return response()->json($response, 500);
        }
    }

    public function getBookingById($id)
    {
        try {
            $booking = Booking::where('is_active', 1)
                ->where('is_deleted', 0)
                ->where('id', $id)
                ->first();

            $response = [
                'data' => $booking,
                'message' => 'Booking fetched successfully',
                'code' => 200
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500
            ];
            return response()->json($response, 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'customer_name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|nullable|email|max:255',
                'phone_number' => 'sometimes|required|string|max:20',
                'time' => 'sometimes|required|date_format:H:i',
                'date' => 'sometimes|required|date',
                'members' => 'sometimes|required|integer|min:1',
                'amount' => 'sometimes|required|numeric|min:0',
                'darshan_id' => 'sometimes|required|exists:darshan_timings,id',
                'package_id' => 'sometimes|nullable|exists:packages,id',
            ]);

            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found.'
                ], 404);
            }

            $booking->update($request->only([
                'customer_name',
                'email',
                'phone_number',
                'time',
                'date',
                'members',
                'amount',
                'darshan_id',
                'package_id'
            ]));

            $response = [
                'data' => $booking,
                'message' => 'Booking updated successfully',
                'code' => 200
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500
            ];
            return response()->json($response, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found.'
                ], 404);
            }

            $booking->is_active = 0;
            $booking->is_deleted = 1;
            $booking->save();

            $response = [
                'data' => [],
                'message' => 'Booking deleted successfully',
                'code' => 200
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500
            ];
            return response()->json($response, 500);
        }
    }
}

