<?php

use App\Livewire\Department;
use App\Livewire\DepaSave;
use App\Livewire\Role;
use App\Livewire\RoleSave;
use App\Livewire\Supplier;
use App\Livewire\SupplierSave;
use App\Livewire\UserSave;
use App\Livewire\UsersList;
use App\Models\department as ModelsDepartment;
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
    //Pagina de error
    Route::fallback(function () {
        return view('errors.404');
    });
    //Usuarios
    Route::get('cuser', UsersList::class)->middleware('can:usuarios')->name('usuarios');
    Route::get('create-user', UserSave::class)->middleware('can:usuarios')->name('user.create');
    Route::get('update-user/{id}', UserSave::class)->middleware('can:usuarios')->name('user.edit');
    //Roles
    Route::get('croles', Role::class)->middleware('can:roles')->name('roles');
    Route::get('create-rol', RoleSave::class)->middleware('can:roles')->name('rol.create');
    Route::get('update-rol/{id}', RoleSave::class)->middleware('can:roles')->name('rol.edit');
    //Departamentos
    Route::get('cdepas', Department::class)->middleware('can:departamentos')->name('departamentos');
    Route::get('create-depa', DepaSave::class)->middleware('can:departamentos')->name('depa.create');
    Route::get('update-depa/{id}', DepaSave::class)->middleware('can:departamentos')->name('depa.edit');
    //Proveedores
    Route::get('csupp', Supplier::class)->middleware('can:suppliers')->name('suppliers');
    Route::get('create-supp', SupplierSave::class)->middleware('can:suppliers')->name('supp.create');
    Route::get('update-supp/{id}', SupplierSave::class)->middleware('can:suppliers')->name('supp.edit');
});
