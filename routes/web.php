<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AdminController::class, 'index'])->name('app');



Route::prefix('admin')->group(function () {
  Route::get('login', [AdminController::class, 'index'])->name('login');

  Route::get('register', [AdminController::class, 'index'])->name('register');

  Route::get('categories', [AdminController::class, 'index'])->name('categories');

  Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
});

Route::get('/test', [AdminController::class, 'index'])->name('test');



Route::prefix('app')->group(function () {
  Route::prefix('admin')->group(function () {
      Route::post('login', [AdminController::class, 'login']);
      Route::post('register', [AdminController::class, 'register']);
      Route::get('logout', [AdminController::class, 'logout'])->name('logout');

      Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
      Route::get('count-categories', [CategoryController::class, 'countCategories']);

      Route::get('count-users', [AdminController::class, 'countUsers']);
  });

  Route::resource('blogs', CategoryController::class)->except(['create', 'edit', 'show']);
});

Route::any('{slug}', function () {
  return redirect()->route('app');
});
