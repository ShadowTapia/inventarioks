<?php

use App\Livewire\UserSave;
use App\Livewire\UsersList;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth:sanctum', 'verified'], 'prefix' => 'dashboard'], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
        Route::resource('user', UserController::class);
        // Route::get('cuser', function () {
        //     return view('admin.users.cindex');
        // })->name('usuarios');
        // Route::get('csave', function () {
        //     return view('admin.users.csave');
        // });
        // Route::get('cupdate/{id}', function () {
        //     return view('admin.users.cupdate');
        // });
    });
    Route::get('cuser', UsersList::class)->name('usuarios');
    Route::get('create-user', UserSave::class)->name('user.create');
    Route::get('update-user/{id}', UserSave::class)->name('user.edit');
});
