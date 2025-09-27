<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // ✅ Create booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'mobile'     => 'required|string|max:15',
            'time'       => 'required|string',
            'date'       => 'required|date',
            'guests'     => 'required|integer|min:1',
            'package_id' => 'required|integer',
        ]);

        // Map frontend field names to DB column names
        $bookingData = [
            'customer_name' => $validated['name'],
            'phone_number'  => $validated['mobile'],
            'time'          => $validated['time'],
            'date'          => $validated['date'],
            'members'       => $validated['guests'],
            'package_id'    => $validated['package_id'],
            'amount'        => 0, // Should be calculated based on package
            'darshan_id'    => 1, // Default darshan_id
        ];

        $booking = Booking::create($bookingData);

        return response()->json([
            'status'  => true,
            'message' => 'Booking created successfully!',
            'data'    => $booking
        ], 200);
    }

    // ✅ Get all bookings
    public function index()
    {
        $bookings = Booking::all();

        return response()->json([
            'status' => true,
            'data'   => $bookings
        ], 200);
    }

    // ✅ Get booking by ID
    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'status'  => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $booking
        ], 200);
    }
    // ✅ Delete booking by ID 
    public function destroy($id)
    {
         $booking = Booking::find($id);
         if (!$booking) {
            return response()->json([
                'status'  => false,
                'message' => 'Booking not found'
            ], 404);
        }
        $booking->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Booking deleted successfully!'
        ], 200);
        
    } 
    // ✅ Update booking
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'status'  => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $validated = $request->validate([
            'name'       => 'sometimes|string|max:255',
            'mobile'     => 'sometimes|string|max:15',
            'time'       => 'sometimes|string',
            'date'       => 'sometimes|date',
            'guests'     => 'sometimes|integer|min:1',
            'package_id' => 'sometimes|integer',
          
            'amount'     => 'sometimes|numeric|min:0',
            'darshan_id' => 'sometimes|integer',
        ]);

        // Map frontend → DB fields if present
        $updateData = [];
        if (isset($validated['name']))       $updateData['customer_name'] = $validated['name'];
        if (isset($validated['mobile']))     $updateData['phone_number']  = $validated['mobile'];
        if (isset($validated['time']))       $updateData['time']          = $validated['time'];
        if (isset($validated['date']))       $updateData['date']          = $validated['date'];
        if (isset($validated['guests']))     $updateData['members']       = $validated['guests'];
        if (isset($validated['package_id'])) $updateData['package_id']    = $validated['package_id'];
         
        if (isset($validated['amount']))     $updateData['amount']        = $validated['amount'];
        if (isset($validated['darshan_id'])) $updateData['darshan_id']    = $validated['darshan_id'];

        $booking->update($updateData);

        return response()->json([
            'status'  => true,
            'message' => 'Booking updated successfully!',
            'data'    => $booking
        ], 200);
    }
}
