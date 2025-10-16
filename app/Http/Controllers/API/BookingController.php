<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Package;
use App\Services\FirebaseService;

class BookingController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendNotification($deviceToken, $title, $body)
    {
        try {
            $result = $this->firebaseService->sendNotification($deviceToken, $title, $body);
            return response()->json(['success' => 'Notification sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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
            'is_verified'=> 'sometimes|boolean',
        ]);

        // Retrieve the package to get its price
        $package = Package::find($validated['package_id']);
        
        if (!$package) {
            return response()->json([
                'status'  => false,
                'message' => 'Package not found'
            ], 404);
        }

        // Calculate amount: package price * number of guests
        $amount = $package->price * $validated['guests'];

        // Map frontend field names to DB column names
        $bookingData = [
            'customer_name' => $validated['name'],
            'phone_number'  => $validated['mobile'],
            'time'          => $validated['time'],
            'date'          => $validated['date'],
            'members'       => $validated['guests'],
            'package_id'    => $validated['package_id'],
            'is_verified'  => $validated['is_verified'] ?? false,
            'amount'        => $amount, // Calculated amount
            'darshan_id'    => 1, // Default darshan_id
        ];

        $booking = Booking::create($bookingData);

        $tokens = auth()->user()->device_tokens ?? [];
        foreach ($tokens as $token) {
            $this->sendNotification($token, 'Booking Confirmed', 'New booking has been successfully created.');
        }
        // Send notification to the user (for demo, using request device_token)
        // $this->sendNotification($request->device_token, 'Booking Confirmed', 'New booking has been successfully created.');
        
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
            'is_verified'=> 'sometimes|boolean',
          
            'amount'     => 'sometimes|numeric|min:0',
            'darshan_id' => 'sometimes|integer',
        ]);

        // If package_id or guests are being updated, recalculate amount
        $amount = $booking->amount; // Default to current amount
        if (isset($validated['package_id']) || isset($validated['guests'])) {
            $packageId = $validated['package_id'] ?? $booking->package_id;
            $guests = $validated['guests'] ?? $booking->members;
            
            $package = Package::find($packageId);
            if ($package) {
                $amount = $package->price * $guests;
            }
        } else if (isset($validated['amount'])) {
            $amount = $validated['amount'];
        }

        // Map frontend → DB fields if present
        $updateData = [];
        if (isset($validated['name']))       $updateData['customer_name'] = $validated['name'];
        if (isset($validated['mobile']))     $updateData['phone_number']  = $validated['mobile'];
        if (isset($validated['time']))       $updateData['time']          = $validated['time'];
        if (isset($validated['date']))       $updateData['date']          = $validated['date'];
        if (isset($validated['guests']))     $updateData['members']       = $validated['guests'];
        if (isset($validated['package_id'])) $updateData['package_id']    = $validated['package_id'];
        if (isset($validated['is_verified'])) $updateData['is_verified']  = $validated['is_verified'];
         
        $updateData['amount'] = $amount;
        if (isset($validated['darshan_id'])) $updateData['darshan_id']    = $validated['darshan_id'];

        $booking->update($updateData);

        return response()->json([
            'status'  => true,
            'message' => 'Booking updated successfully!',
            'data'    => $booking
        ], 200);
    }
}