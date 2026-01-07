<?php

namespace App\Http\Controllers;

use App\Enums\LeadStatus;
use App\Enums\PropertyType;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactSubmissionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string', 'min:5'],
            'source' => ['nullable', 'string', 'max:255'],
            'property_type' => ['nullable', 'string', Rule::in(array_column(PropertyType::cases(), 'value'))],
        ]);

        $propertyType = $data['property_type'] ?? PropertyType::Other->value;

        $lead = Lead::create([
            'source_page' => $data['source'] ?? null,
            'product_id' => null,
            'property_type' => $propertyType,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'message' => $data['message'],
            'status' => LeadStatus::New,
            'utm_json' => null,
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        activity()->performedOn($lead)->log('created');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $lead->id,
            ],
            'message' => 'Thanks, we will contact you shortly.',
        ], 201);
    }
}
