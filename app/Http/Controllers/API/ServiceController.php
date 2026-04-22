<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public const CATEGORY_SLUGS = ['hotel', 'restaurant', 'tourist_place'];

    public function index(Request $request)
    {
        try {
            $query = Service::where('is_active', 1)->where('is_deleted', 0);

            $category = $request->query('category');
            if (!empty($category)) {
                $query->where('category', $category);
            }

            $services = $query->orderBy('id', 'desc')->get();

            return response()->json([
                'data' => $services,
                'message' => 'Services fetched successfully',
                'code' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('service.index.failed', [
                'category' => $request->query('category'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'data' => [],
                'message' => 'Something went wrong',
                'code' => 500,
            ], 500);
        }
    }

    public function manage()
    {
        try {
            $services = Service::where('is_deleted', 0)->orderBy('id', 'desc')->get();

            return response()->json([
                'data' => $services,
                'message' => 'Services fetched successfully',
                'code' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('service.manage.failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'data' => [],
                'message' => 'Something went wrong',
                'code' => 500,
            ], 500);
        }
    }

    protected function serviceValidationRules(bool $isUpdate = false): array
    {
        $categoryRule = Rule::in(self::CATEGORY_SLUGS);

        return [
            'name' => $isUpdate ? ['sometimes', 'nullable', 'string'] : ['required', 'string'],
            'category' => $isUpdate ? ['sometimes', 'nullable', 'string', $categoryRule] : ['required', 'string', $categoryRule],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
            'mobile_number' => ['nullable', 'string'],
            'website_url' => ['nullable', 'string', 'url'],
            'google_map_link' => ['nullable', 'string', 'url'],
            'is_active' => ['nullable', 'integer', Rule::in([0, 1])],
            'image' => ['nullable', 'file', 'image', 'max:10240'],
        ];
    }

    protected function multipartInputForValidation(Request $request): array
    {
        return array_merge($request->request->all(), $request->allFiles());
    }

    protected function normalizedServicePayload(Request $request): array
    {
        $payload = $this->multipartInputForValidation($request);

        $payload['name'] = $payload['name'] ?? $payload['service_name'] ?? $payload['title'] ?? null;
        $payload['mobile_number'] = $payload['mobile_number'] ?? $payload['mobile'] ?? $payload['phone'] ?? null;
        $payload['google_map_link'] = $payload['google_map_link'] ?? $payload['map_link'] ?? $payload['googleMapLink'] ?? null;

        return $payload;
    }

    protected function validationErrorResponse($validator)
    {
        return response()->json([
            'data' => [],
            'message' => $validator->errors()->all(),
            'code' => 400,
        ], 400);
    }

    /**
     * Centralized file storage (production safe)
     */
    protected function storeUploadedImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');

        $fileName = (string) Str::uuid();
        $extension = $file->extension(); // safer than client extension

        $finalName = $fileName . '.' . $extension;

        $stored = Storage::disk('public')->putFileAs('services', $file, $finalName);

        if (! $stored) {
            throw new Exception('File upload failed');
        }

        return $finalName;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $payload = $this->normalizedServicePayload($request);

            $validator = Validator::make(
                $payload,
                $this->serviceValidationRules(),
                $this->serviceValidationMessages()
            );

            if ($validator->fails()) {
                return $this->validationErrorResponse($validator);
            }

            $validated = $validator->validated();

            $imageFilename = $this->storeUploadedImage($request);

            $service = Service::create([
                'image' => $imageFilename,
                'name' => $validated['name'] ?? null,
                'category' => $validated['category'] ?? null,
                'rating' => $validated['rating'] ?? null,
                'mobile_number' => $validated['mobile_number'] ?? null,
                'website_url' => $validated['website_url'] ?? null,
                'google_map_link' => $validated['google_map_link'] ?? null,
                'is_active' => array_key_exists('is_active', $validated)
                    ? (int) $validated['is_active']
                    : 1,
            ]);

            DB::commit();

            return response()->json([
                'data' => $service->fresh(),
                'message' => 'Service created successfully',
                'code' => 201,
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('service.store.failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'data' => [],
                'message' => 'Something went wrong',
                'code' => 500,
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $payload = $this->normalizedServicePayload($request);

            $validator = Validator::make(
                $payload,
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

            $validated = $validator->validated();

            foreach ($validated as $key => $value) {
                $service->$key = $value;
            }

            if ($request->hasFile('image')) {

                // store new first
                $newImage = $this->storeUploadedImage($request);

                // delete old safely
                if ($service->image) {
                    Storage::disk('public')->delete('services/' . $service->image);
                }

                $service->image = $newImage;
            }

            $service->save();

            DB::commit();

            return response()->json([
                'data' => $service->fresh(),
                'message' => 'Service updated successfully',
                'code' => 200,
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('service.update.failed', [
                'service_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'data' => [],
                'message' => 'Something went wrong',
                'code' => 500,
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $service = Service::where('id', $id)->where('is_deleted', 0)->first();

            if (! $service) {
                return response()->json([
                    'data' => [],
                    'message' => 'Service not found',
                    'code' => 404,
                ], 404);
            }

            if (! empty($service->image)) {
                Storage::disk('public')->delete('services/' . $service->image);
            }

            $service->is_deleted = 1;
            $service->save();

            DB::commit();

            return response()->json([
                'data' => $service,
                'message' => 'Service deleted successfully',
                'code' => 200,
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('service.destroy.failed', [
                'service_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'data' => [],
                'message' => 'Something went wrong',
                'code' => 500,
            ], 500);
        }
    }

    protected function serviceValidationMessages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'category.required' => 'Category is required.',
            'category.in' => 'Invalid category.',
            'rating.between' => 'Rating must be between 0 and 5.',
        ];
    }
}