<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;

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

Route::view('/', 'home')->name('home');

// Routes for registration
Route::prefix('register')->group(function() {
	Route::name('register.')->group(function() {
		Route::view('', 'auth.register')->name('view');
		Route::post('email', [RegisterController::class, 'registerEmail'])->name('email');
		Route::post('user', [RegisterController::class, 'registerUser'])->name('user');
		Route::post('validate', [RegisterController::class, 'validateEmail'])->name('validate');
	});
});

// Routes for login
Route::prefix('login')->group(function() {
	Route::name('login.')->group(function() {
		Route::view('', 'auth.login')->name('view');
		Route::post('', [LoginController::class, 'authenticate'])->name('login');
	});
});

// Route to logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function() {
	Route::get('inventory', [InventoryController::class, 'index'])->name('inventory');

	Route::prefix('product')->group(function() {
		Route::name('product.')->group(function() {
			Route::get('create', [ProductController::class, 'create'])->name('create.view');
			Route::get('edit', [ProductController::class, 'edit'])->name('edit.view');
			Route::post('save', [ProductController::class, 'save'])->name('save');
		});
	});
});

Route::post('category/{id}/subcategories', [CategoriesController::class, 'getSubcategories']);