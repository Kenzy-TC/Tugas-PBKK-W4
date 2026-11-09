<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/beranda', [PageController::class, 'home'])->name('beranda');
Route::get('/profil-mahasiswa', [PageController::class, 'profile'])->name('profil');
Route::get('/ide-agent', [PageController::class, 'agent'])->name('ide-agent');
Route::post('/ide-agent', [PageController::class, 'submitIdea'])->name('ide-agent.submit');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    Route::resource('mahasiswa', StudentController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['mahasiswa' => 'student'])
        ->names('students');
});

require __DIR__ . '/auth.php';
