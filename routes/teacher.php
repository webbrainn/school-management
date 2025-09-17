<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('teacher.dashboard');

