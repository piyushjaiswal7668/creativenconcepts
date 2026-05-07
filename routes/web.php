<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactSubmissionController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/c', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/generate-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link generated successfully';
});

Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return '<pre>' . Artisan::output() . '</pre>';
});

Route::get('/run-optimize', function () {
    Artisan::call('optimize');
    return '<pre>' . Artisan::output() . '</pre>';
});

Route::get('/run-optimize-clear', function () {
    Artisan::call('optimize:clear');
    return '<pre>' . Artisan::output() . '</pre>';
});

Route::get('/run-queue', function () {
    Artisan::call('queue:work', [
        '--once'     => true,
        '--tries'    => 3,
        '--timeout'  => 60,
    ]);
    return '<pre>' . Artisan::output() . '</pre>';
});

Route::post('/contact/submit', [ContactSubmissionController::class, 'store'])
    ->middleware('throttle:10,1');

// One-time cleanup: trim whitespace/tab from corrupted avatar values in DB
Route::get('/fix-avatars', function () {
    $fixed = \App\Models\User::whereRaw("avatar != TRIM(avatar)")->get()
        ->each(fn ($u) => $u->update(['avatar' => trim($u->avatar)]));
    return 'Fixed ' . $fixed->count() . ' avatar(s).';
});
