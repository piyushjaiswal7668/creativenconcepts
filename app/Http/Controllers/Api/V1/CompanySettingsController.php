<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CompanySettingsService;
use Illuminate\Http\JsonResponse;

class CompanySettingsController extends Controller
{
    public function __construct(private readonly CompanySettingsService $service)
    {
    }

    public function show(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->getSettings(),
            'message' => null,
        ]);
    }
}
