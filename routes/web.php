<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Routes for registration
Route::prefix('register')->group(function() {
	Route::name('register.')->group(function() {
		Route::post('email', [RegisterController::class, 'registerEmail'])->name('email');
		Route::post('user', [RegisterController::class, 'registerUser'])->name('user');
		Route::post('validate', [RegisterController::class, 'validateEmail'])->name('validate');
	});
});