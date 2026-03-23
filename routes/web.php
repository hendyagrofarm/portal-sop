<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Documents - User & Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])
        ->name('documents.index');

    Route::get('/documents/history', [DocumentController::class, 'history'])
        ->name('documents.history');

    Route::get('/documents/{document}/open', [DocumentController::class, 'open'])
        ->name('documents.open');

    
});

/*
|--------------------------------------------------------------------------
| Documents - Admin Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/documents/create', [DocumentController::class, 'create'])
        ->name('documents.create');

    Route::post('/documents', [DocumentController::class, 'store'])
        ->name('documents.store');

    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])
        ->name('documents.edit');

    Route::put('/documents/{document}', [DocumentController::class, 'update'])
        ->name('documents.update');

    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
        ->name('documents.destroy');

    Route::patch('/documents/{document}/revoke', [DocumentController::class, 'revoke'])
        ->name('documents.revoke');

    Route::patch('/documents/{document}/restore', [DocumentController::class, 'restore'])
        ->name('documents.restore');

    Route::get('/admin', function () {
        return Inertia::render('AdminDashboard');
    })->name('admin.dashboard');

    Route::get('/admin-test', function () {
        return 'OK ADMIN';
    });
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::get('/tutorial', function () {
        return Inertia::render('Tutorial/Index');
    })->name('tutorial.index');
    
require __DIR__ . '/auth.php';