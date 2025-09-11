<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Package;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    // Fetch all packages
    public function index(Request $request)
    {
        try {
            $packages = Package::with('features')->get();
            return response()->json([
                'success' => true,
                'data' => $packages
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch packages.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Create a new package
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $package = Package::create([
                'name' => $request->name,
                'amount' => $request->amount,
                'description' => $request->description,
                'is_active' => 1,
                'is_deleted' => 0,
            ]);

            if ($request->has('features')) {
                $package->features()->sync($request->features);
            }

            return response()->json([
                'success' => true,
                'message' => 'Package created successfully.',
                'data' => $package
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create package.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Fetch single package with features
    public function getFeatureById($id)
    {
        try {
            $package = Package::with('features')->find($id);

            if (!$package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Package not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $package
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch package.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update package
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $package = Package::find($id);

            if (!$package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Package not found.'
                ], 404);
            }

            if ($request->has('name')) {
                $package->name = $request->name;
            }
            if ($request->has('amount')) {
                $package->amount = $request->amount;
            }
            if ($request->has('description')) {
                $package->description = $request->description;
            }
            $package->save();

            if ($request->has('features')) {
                $package->features()->sync($request->features);
            }

            return response()->json([
                'success' => true,
                'message' => 'Package updated successfully.',
                'data' => $package
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update package.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Soft delete package
    public function destroy($id)
    {
        try {
            $package = Package::find($id);

            if (!$package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Package not found.'
                ], 404);
            }

            $package->is_active = 0;
            $package->is_deleted = 1;
            $package->save();

            return response()->json([
                'success' => true,
                'message' => 'Package deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete package.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

