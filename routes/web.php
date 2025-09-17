<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleBasedDashboardController;
use App\Http\Controllers\AdmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group that
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () { 
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});


// Role-based dashboard route
Route::middleware(['auth'])->get('/dashboard', [RoleBasedDashboardController::class, 'index']);

// Route::get('/admission-form', [AdmissionController::class, 'create'])->name('admission.create');
// Route::post('/admission-form', [AdmissionController::class, 'store'])->name('admission.store');
