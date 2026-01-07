<?php

use App\Http\Controllers\ContactSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contact/submit', [ContactSubmissionController::class, 'store'])
    ->middleware('throttle:10,1');
