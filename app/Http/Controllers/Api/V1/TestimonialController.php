<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::query()
            ->active()
            ->ordered()
            ->get()
            ->map(fn (Testimonial $testimonial) => [
                'name' => $testimonial->name,
                'role' => $testimonial->role ?: '',
                'content' => $testimonial->content,
                'rating' => $testimonial->rating,
                'order' => $testimonial->sort_order,
                'status' => $testimonial->status,
                'avatar' => $testimonial->getFirstMediaUrl('avatar') ?: '',
            ])
            ->values()
            ->all();

        return response()->json([
            'success' => true,
            'data' => [
                'testimonials' => $testimonials,
            ],
            'message' => null,
        ]);
    }
}
