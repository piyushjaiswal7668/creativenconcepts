<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $service)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->list(),
            'message' => null,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->findBySlug($slug),
            'message' => null,
        ]);
    }
}
