<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public const CATEGORY_SLUGS = ['hotel', 'restaurant', 'tourist_place'];

    protected function serviceValidationRules(bool $isUpdate = false): array
    {
        $categoryRule = Rule::in(self::CATEGORY_SLUGS);

        return [
            'name' => ['nullable', 'string'],
            'category' => ['nullable', 'string', $categoryRule],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
            'mobile_number' => ['nullable', 'string'],
            'website_url' => ['nullable', 'string', 'url'],
            'google_map_link' => ['nullable', 'string', 'url'],
            'is_active' => ['nullable', 'integer', Rule::in([0, 1])],
            'image' => ['nullable', 'file'],
        ];
    }

    protected function serviceValidationMessages(): array
    {
        return [
            'category.in' => 'Category must be one of: hotel, restaurant, tourist_place.',
            'rating.between' => 'Rating must be between 0 and 5.',
            'website_url.url' => 'Website URL must be a valid URL.',
            'google_map_link.url' => 'Google map link must be a valid URL.',
            'is_active.in' => 'is_active must be 0 or 1.',
        ];
    }

    protected function validationErrorResponse($validator)
    {
        $errors = collect();
        foreach ($validator->errors()->all() as $error) {
            $errors->push($error);
        }

        return response()->json([
            'data' => [],
            'message' => $errors,
            'code' => 400,
        ], 400);
    }

    protected function ensureUploadsDirectory(): void
    {
        $path = public_path('uploads/services');
        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    protected function storeUploadedImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }
        $this->ensureUploadsDirectory();
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/services/'), $filename);

        return $filename;
    }

    public function index(Request $request)
    {
        try {
            $query = Service::where('is_active', 1)->where('is_deleted', 0);

            if ($request->filled('category')) {
                $query->where('category', $request->query('category'));
            }

            $services = $query->orderBy('updated_at', 'desc')->get();

            $response = [];
            $response['data'] = $services;
            $response['message'] = 'Services fetched successfully';
            $response['code'] = 200;

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500,
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $service = Service::where('is_active', 1)
                ->where('is_deleted', 0)
                ->where('id', $id)
                ->first();

            if (! $service) {
                return response()->json([
                    'data' => [],
                    'message' => 'Service not found',
                    'code' => 404,
                ], 404);
            }

            return response()->json([
                'data' => $service,
                'message' => 'Service fetched successfully',
                'code' => 200,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500,
            ], 500);
        }
    }

    public function manage(Request $request)
    {
        try {
            $query = Service::where('is_deleted', 0);

            if ($request->filled('category')) {
                $query->where('category', $request->query('category'));
            }

            $services = $query->orderBy('updated_at', 'desc')->get();

            return response()->json([
                'data' => $services,
                'message' => 'Services fetched successfully',
                'code' => 200,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500,
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                $this->serviceValidationRules(),
                $this->serviceValidationMessages()
            );

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator);
            }

            $image = $this->storeUploadedImage($request);

            $service = Service::create([
                'image' => $image,
                'name' => $request->input('name'),
                'category' => $request->input('category'),
                'rating' => $request->input('rating'),
                'mobile_number' => $request->input('mobile_number'),
                'website_url' => $request->input('website_url'),
                'google_map_link' => $request->input('google_map_link'),
                'is_active' => $request->has('is_active') ? (int) $request->input('is_active') : 1,
            ]);

            return response()->json([
                'data' => $service,
                'message' => 'Service created successfully',
                'code' => 201,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500,
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                $this->serviceValidationRules(true),
                $this->serviceValidationMessages()
            );

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator);
            }

            $service = Service::where('id', $id)->where('is_deleted', 0)->first();

            if (! $service) {
                return response()->json([
                    'data' => [],
                    'message' => 'Service not found',
                    'code' => 404,
                ], 404);
            }

            if ($request->exists('name')) {
                $service->name = $request->input('name');
            }
            if ($request->exists('category')) {
                $service->category = $request->input('category');
            }
            if ($request->exists('rating')) {
                $service->rating = $request->input('rating');
            }
            if ($request->exists('mobile_number')) {
                $service->mobile_number = $request->input('mobile_number');
            }
            if ($request->exists('website_url')) {
                $service->website_url = $request->input('website_url');
            }
            if ($request->exists('google_map_link')) {
                $service->google_map_link = $request->input('google_map_link');
            }
            if ($request->exists('is_active')) {
                $service->is_active = (int) $request->input('is_active');
            }

            if ($request->hasFile('image')) {
                $service->image = $this->storeUploadedImage($request);
            }

            $service->save();

            return response()->json([
                'data' => $service,
                'message' => 'Service updated successfully',
                'code' => 200,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500,
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::where('id', $id)->where('is_deleted', 0)->first();

            if (! $service) {
                return response()->json([
                    'data' => [],
                    'message' => 'Service not found',
                    'code' => 404,
                ], 404);
            }

            $service->is_deleted = 1;
            $service->is_active = 0;
            $service->save();

            return response()->json([
                'data' => $service,
                'message' => 'Service deleted successfully.',
                'code' => 200,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'code' => 500,
            ], 500);
        }
    }
}
