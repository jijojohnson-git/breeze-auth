<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web'])->name('dashboard');

//ADMIN ROUTES\\
Route::prefix('admin')->name('admin.')->group(function(){
    Route::view('login', 'auth.admin.login')->name('login.show')->middleware('guest:admin');
    Route::post('login', [AdminController::class, 'login'])->name('login')->middleware('guest:admin');

    Route::controller(AdminController::class)->middleware(['auth:admin'])->group( function(){

        Route::view('home', 'admin-dashboard')->name('home');
        Route::post('logout', 'logout')->name('logout');
    });

});


//VENDOR ROUTES\\
Route::prefix('vendor')->name('vendor.')->group(function(){
    Route::view('login', 'auth.vendor.login')->name('login.show')->middleware('guest:vendor');
    Route::post('login', [VendorController::class, 'login'])->name('login')->middleware('guest:vendor');
    Route::view('register', 'auth.vendor.register')->name('register.show')->middleware('guest:vendor');
    Route::post('register', [VendorController::class, 'register'])->name('register')->middleware('guest:vendor');

    Route::middleware(['auth:vendor' ])->controller(VendorController::class)->group(function(){

            Route::view('home', 'vendor-dashboard')->name('home');
            Route::post('logout', 'logout')->name('logout');
    });

});



require __DIR__.'/auth.php';
