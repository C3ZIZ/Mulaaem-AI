<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\PublicApplicationController;

Route::get('/', [PublicJobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job:slug}', [PublicJobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{job:slug}/apply', [PublicApplicationController::class, 'store'])->name('applications.store');