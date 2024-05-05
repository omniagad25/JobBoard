<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureIsCandidate;
use App\Http\Middleware\EnsureIsEmployer;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Routes for only verified users
Route::middleware('verified')->group(function () {

});

//Routes for admins only
Route::middleware([EnsureIsAdmin::class])->group(function () {

});

//Routes for employers only
Route::middleware([EnsureIsEmployer::class])->group(function () {

});

//Routes for only candidates only
Route::middleware([EnsureIsCandidate::class])->group(function () {
    Route::get('/demo', [DemoController::class, 'index'])->name('demo');
});

require __DIR__ . '/auth.php';