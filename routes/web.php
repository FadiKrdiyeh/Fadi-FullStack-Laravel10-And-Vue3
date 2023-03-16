<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
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

Route::get('/', [AccountController::class, 'index'])->name('app');
Route::get('/home', [AccountController::class, 'index'])->name('app.home');



Route::prefix('admin')->group(function () {
  Route::get('login', [AdminController::class, 'index'])->name('login');

  Route::get('register', [AdminController::class, 'index'])->name('register');

  Route::get('categories', [AdminController::class, 'index'])->name('categories');

  Route::get('blogs', [AdminController::class, 'index'])->name('admin.blogs');

  Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
});

Route::get('/login', [AccountController::class, 'index'])->name('user.login');
Route::get('/blogs', [AccountController::class, 'index'])->name('user.blogs.index');
Route::get('/blogs/{slug}', [AccountController::class, 'index'])->name('user.blogs.index');
Route::get('/blogs/create', [AccountController::class, 'index'])->name('user.blogs.create');
Route::get('/blogs/edit/{id}', [AccountController::class, 'index'])->name('user.blogs.create');

Route::get('/test', [AdminController::class, 'index'])->name('test');
Route::get('/test-user', [AccountController::class, 'index'])->name('test.user');



Route::prefix('app')->group(function () {
  Route::resource('blogs', BlogController::class)->except(['create']);
  Route::resource('comments/', CommentController::class)->except(['create']);
  Route::get('comments/{id}', [CommentController::class, 'index']);

  Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);

  Route::prefix('admin')->group(function () {
      Route::post('login', [AdminController::class, 'login']);
      Route::post('register', [AdminController::class, 'register']);
      Route::get('logout', [AdminController::class, 'logout'])->name('logout');

      Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
      Route::get('count-categories', [CategoryController::class, 'countCategories']);

      Route::get('blogs', [AdminController::class, 'blogs']);
      Route::get('count-blogs', [BlogController::class, 'countBlogs']);
      Route::post('blogs/accept/{id}', [AdminController::class, 'acceptBlog']);
      Route::delete('blogs/delete/{id}', [AdminController::class, 'deleteBlog']);
      // Route::resource('blogs', BlogController::class)->except(['create', 'edit', 'show']);

      Route::get('count-users', [AdminController::class, 'countUsers']);
  });

  Route::controller(AccountController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('logout', 'logout');
  });
});

Route::any('{slug}', function () {
  return redirect()->route('app');
});
