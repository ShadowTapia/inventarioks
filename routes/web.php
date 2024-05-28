<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrintCodebarAll;
use App\Http\Controllers\PrintCodebaru;
use App\Livewire\Companies;
use App\Http\Controllers\PrintPDF;
use App\Livewire\Department;
use App\Livewire\DepaSave;
use App\Livewire\Devicelist;
use App\Livewire\ProductsList;
use App\Livewire\Productype;
use App\Livewire\Role;
use App\Livewire\RoleSave;
use App\Livewire\SaveCompany;
use App\Livewire\SaveProduct;
use App\Livewire\SaveProductype;
use App\Livewire\Supplier;
use App\Livewire\SupplierSave;
use App\Livewire\UserSave;
use App\Livewire\UsersList;
use Illuminate\Support\Facades\App;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

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
    //Companies
    Route::get('ccomp', Companies::class)->middleware('can:companies')->name('companies');
    Route::get('create-comp', SaveCompany::class)->middleware('can:companies')->name('comp.create');
    Route::get('update-comp/{id}', SaveCompany::class)->middleware('can:companies')->name('comp.edit');
    //Productype
    Route::get('cprodype', Productype::class)->middleware('can:productype')->name('productype');
    Route::get('protype.create', SaveProductype::class)->middleware('can:productype')->name('prtype.create');
    Route::get('protype.update/{id}', SaveProductype::class)->middleware('can:productype')->name('prtype.edit');
    //Productos
    Route::get('cproducts', ProductsList::class)->middleware('can:productslist')->name('productslist');
    Route::get('create.prduct', SaveProduct::class)->middleware('can:productslist')->name('pro.create');
    Route::get('print.prduct', [PrintPDF::class, 'printPDF'])->middleware('can:productslist')->name('print.product');
    //Devices
    Route::get('cdevices', Devicelist::class)->middleware('can:devicelist')->name('devicelist');
    Route::get('create.device/{id}', ProductsList::class)->middleware('can:devicelist')->name('devi.create');
    Route::get('edit.device/{id}', Devicelist::class)->middleware('can:devicelist')->name('devi.edit');
    Route::get('show.device/{id}', ProductsList::class)->middleware('can:devicelist')->name('devi.show');
    Route::get('print.barra/{id}', [PrintCodebaru::class, 'printCodeBar'])->middleware('can:devicelist')->name('print.barra');
    Route::get('print.barraAll', [PrintCodebarAll::class, 'printCodeAll'])->middleware('can:devicelist')->name('print.barraAll');
});
