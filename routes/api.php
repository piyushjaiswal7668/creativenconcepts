<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('company-settings', [\App\Http\Controllers\Api\V1\CompanySettingsController::class, 'show']);
    Route::get('projects', [\App\Http\Controllers\Api\V1\ProjectController::class, 'index']);
    Route::get('projects/{slug}', [\App\Http\Controllers\Api\V1\ProjectController::class, 'show']);
    Route::get('team', [\App\Http\Controllers\Api\V1\TeamController::class, 'index']);
    Route::get('testimonials', [\App\Http\Controllers\Api\V1\TestimonialController::class, 'index']);
    Route::post('contact-us', [\App\Http\Controllers\Api\V1\LeadController::class, 'store'])->middleware('throttle:5,1');
});
