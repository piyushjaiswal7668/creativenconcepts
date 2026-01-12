<?php

use App\Http\Controllers\ContactSubmissionController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});


Route::get('/generate-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link generated successfully';
});

Route::post('/contact/submit', [ContactSubmissionController::class, 'store'])
    ->middleware('throttle:10,1');
