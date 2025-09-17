<?php
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return "Welcome to the Student Dashboard";
})->name('dashboard');
