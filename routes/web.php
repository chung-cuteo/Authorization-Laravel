<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Controllers\Admin\UsersController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::prefix('posts')->name('posts.')->middleware('can:posts')->group(function () {

        Route::get('/', [PostsController::class, 'index'])->name('index');

        Route::get('/add', [PostsController::class, 'add'])->name('add');

        Route::post('/add', [PostsController::class, 'postAdd']);

        Route::get('/edit/{post}', [PostsController::class, 'edit'])->name('edit');

        Route::post('/edit/{post}', [PostsController::class, 'postEdit']);

        Route::get('/delete/{post}', [PostsController::class, 'delete'])->name('delete');
    });

    Route::prefix('groups')->name('groups.')->middleware('can:groups')->group(function () {

        Route::get('/', [GroupsController::class, 'index'])->name('index');

        Route::get('/add', [GroupsController::class, 'add'])->name('add');

        Route::post('/add', [GroupsController::class, 'postAdd']);

        Route::get('/edit/{group}', [GroupsController::class, 'edit'])->name('edit');

        Route::post('/edit/{group}', [GroupsController::class, 'postEdit']);

        Route::get('/delete/{group}', [GroupsController::class, 'delete'])->name('delete');

        Route::get('/permission/{group}', [GroupsController::class, 'permission'])->name('permission');

        Route::post('/permission/{group}', [GroupsController::class, 'postPermission']);

    });

    Route::prefix('users')->name('users.')->middleware('can:users')->group(function () {

        Route::get('/', [UsersController::class, 'index'])->name('index');

        Route::get('/add', [UsersController::class, 'add'])->name('add');

        Route::post('/add', [UsersController::class, 'postAdd']);

        Route::get('/edit/{user}', [UsersController::class, 'edit'])->name('edit');

        Route::post('/edit/{user}', [UsersController::class, 'postEdit']);

        Route::get('/delete/{user}', [UsersController::class, 'delete'])->name('delete');
    });
});
