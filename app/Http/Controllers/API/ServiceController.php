<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public const CATEGORY_SLUGS = ['hotel', 'restaurant', 'tourist_place'];

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

    /**
     * Merge parsed POST fields and uploaded files for multipart validation.
     * (Laravel's all() already merges files when PHP parsed the body correctly.)
     */
    protected function multipartInputForValidation(Request $request): array
    {
        return array_merge($request->request->all(), $request->allFiles());
    }

    protected function normalizedServicePayload(Request $request): array
    {
        $payload = $this->multipartInputForValidation($request);

        if (! array_key_exists('name', $payload)) {
            $payload['name'] = $payload['service_name']
                ?? $payload['title']
                ?? null;
        }

        if (! array_key_exists('mobile_number', $payload)) {
            $payload['mobile_number'] = $payload['mobile']
                ?? $payload['phone']
                ?? null;
        }

        if (! array_key_exists('google_map_link', $payload)) {
            $payload['google_map_link'] = $payload['map_link']
                ?? $payload['googleMapLink']
                ?? null;
        }

        return $payload;
    }

    /**
     * When the client sends a body but PHP/Laravel did not populate input/files,
     * explain the usual causes (Ionic/Angular setting Content-Type without boundary, PHP limits).
     */
    protected function unparsedMultipartHint(Request $request): ?string
    {
        $contentType = (string) $request->header('Content-Type', '');
        $length = (int) $request->header('Content-Length', 0);

        if (stripos($contentType, 'multipart/form-data') !== false
            && stripos($contentType, 'boundary=') === false) {
            return 'Content-Type is multipart/form-data but has no boundary. '
                . 'In Angular/Ionic HttpClient, do not set Content-Type for FormData; '
                . 'let the browser set multipart/form-data with the boundary automatically.';
        }

        if ($contentType === '' && $length > 0 && empty($request->request->all()) && ! $request->allFiles()) {
            return 'Missing Content-Type while a body was sent; fields were not parsed. '
                . 'Send multipart/form-data (with boundary) for this endpoint.';
        }

        if ($length > 0 && empty($request->request->all()) && ! $request->allFiles()) {
            if (stripos($contentType, 'application/json') !== false) {
                return 'Content-Type is application/json. File uploads must use multipart/form-data.';
            }

            return 'Request has a Content-Length but no parsed fields or files. '
                . 'Typical fixes: (1) remove manual multipart Content-Type on the client, '
                . '(2) increase PHP post_max_size and upload_max_filesize above the request size, '
                . '(3) ensure you POST as multipart/form-data with a valid boundary.';
        }

        return null;
    }

    protected function serviceValidationMessages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'category.required' => 'Category is required.',
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
        $safeBase = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($file->getClientOriginalName()));
        $filename = time() . '_' . $safeBase;
        $file->move(public_path('uploads/services/'), $filename);

        return $filename;
    }

    public function index(Request $request)
    {
        try {
            if ($request->filled('category')) {
                $category = (string) $request->query('category');
                if (! in_array($category, self::CATEGORY_SLUGS, true)) {
                    return response()->json([
                        'data' => [],
                        'message' => 'Invalid category. Allowed values: hotel, restaurant, tourist_place.',
                        'code' => 400,
                    ], 400);
                }
            }

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
            if (config('app.debug') && $request->boolean('_dump_multipart')) {
                dd([
                    'request_bag' => $request->request->all(),
                    'files' => $request->allFiles(),
                    'file_image' => $request->file('image'),
                    'content_type' => $request->header('Content-Type'),
                    'content_length' => $request->header('Content-Length'),
                ]);
            }

            if ($hint = $this->unparsedMultipartHint($request)) {
                Log::warning('service.store.multipart_unparsed', [
                    'hint' => $hint,
                    'content_type' => $request->header('Content-Type'),
                    'content_length' => $request->header('Content-Length'),
                ]);

                return response()->json([
                    'data' => [],
                    'message' => $hint,
                    'code' => 422,
                ], 422);
            }

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

            return response()->json([
                'data' => $service->fresh(),
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
            if (config('app.debug') && $request->boolean('_dump_multipart')) {
                dd([
                    'request_bag' => $request->request->all(),
                    'files' => $request->allFiles(),
                    'file_image' => $request->file('image'),
                    'content_type' => $request->header('Content-Type'),
                ]);
            }

            if ($hint = $this->unparsedMultipartHint($request)) {
                Log::warning('service.update.multipart_unparsed', [
                    'hint' => $hint,
                    'service_id' => $id,
                    'content_type' => $request->header('Content-Type'),
                ]);

                return response()->json([
                    'data' => [],
                    'message' => $hint,
                    'code' => 422,
                ], 422);
            }

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

            if (array_key_exists('name', $validated)) {
                $service->name = $validated['name'];
            }
            if (array_key_exists('category', $validated)) {
                $service->category = $validated['category'];
            }
            if (array_key_exists('rating', $validated)) {
                $service->rating = $validated['rating'];
            }
            if (array_key_exists('mobile_number', $validated)) {
                $service->mobile_number = $validated['mobile_number'];
            }
            if (array_key_exists('website_url', $validated)) {
                $service->website_url = $validated['website_url'];
            }
            if (array_key_exists('google_map_link', $validated)) {
                $service->google_map_link = $validated['google_map_link'];
            }
            if (array_key_exists('is_active', $validated)) {
                $service->is_active = (int) $validated['is_active'];
            }

            if ($request->hasFile('image')) {
                $service->image = $this->storeUploadedImage($request);
            }

            $service->save();

            return response()->json([
                'data' => $service->fresh(),
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
