<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FlowerController;
use App\Http\Controllers\Admin\PreMadeBouquetController;
use App\Http\Controllers\Admin\PackagingOptionController;
use App\Http\Controllers\Admin\SaleController;

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
|
| Redirect visitors to the admin dashboard. Unauthenticated visitors
| will be caught by the admin.auth middleware and directed to /admin/login.
|
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Guest Authentication Routes
|--------------------------------------------------------------------------
|
| Accessible ONLY when the administrator is NOT logged in.
| If an already-authenticated admin visits these, admin.guest redirects them.
|
*/

Route::prefix('admin')->name('admin.')->middleware('admin.guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

});

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
|
| ALL administrative actions require the admin.auth middleware.
| Unauthenticated access attempts are immediately redirected to /admin/login.
|
*/

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Flower Inventory Management
    |--------------------------------------------------------------------------
    */

    Route::resource('flowers', FlowerController::class)
        ->except(['show']);


    /*
    |--------------------------------------------------------------------------
    | Pre-Made Bouquet Management
    |--------------------------------------------------------------------------
    */

    Route::resource('bouquets', PreMadeBouquetController::class)
        ->except(['show']);


    /*
    |--------------------------------------------------------------------------
    | Packaging Options Management
    |--------------------------------------------------------------------------
    */

    Route::resource('packaging', PackagingOptionController::class)
        ->except(['show']);


    /*
    |--------------------------------------------------------------------------
    | Sales & Statistics Management
    |--------------------------------------------------------------------------
    */

    Route::resource('sales', SaleController::class)
        ->only(['index', 'create', 'store', 'show', 'destroy']);

    Route::patch('sales/{sale}/status', [SaleController::class, 'updateStatus'])
        ->name('sales.status');

});
