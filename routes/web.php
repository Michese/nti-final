<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Controllers\Dispatcher\DispatcherController;
use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Warehousman\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::name('auth')
    ->prefix('/auth')
    ->middleware('guest')
    ->group(function () {

        Route::name('.login')
            ->prefix('/login')
            ->group(function () {
                Route::get('/', [LoginController::class, 'index'])
                    ->name('.index');

                Route::post('/', [LoginController::class, 'sign_in'])
                    ->name('.sign_in')
                    ->middleware('checkVerify');
            });

        Route::name('.register')
            ->prefix('/register')
            ->group(function () {
                Route::get('/', [RegisterController::class, 'index'])
                    ->name('.index');

                Route::post('/', [RegisterController::class, 'create'])
                    ->name('.create');
            });

        Route::get('/verify/{hash}', [VerifyController::class, 'index'])
            ->name('.verify')
            ->where('hash', '.+');

        Route::get('/verified/{hash}', [VerifyController::class, 'verified'])
            ->name('.verified')
            ->where('hash', '.+');

        Route::get('/forgotPassword', [LoginController::class, 'forgotPasswordPage'])
            ->name('.forgotPassword');

        Route::post('/forgotPassword', [LoginController::class, 'forgotPassword'])
            ->name('.forgotPassword')
            ->middleware('checkVerify');

        Route::get('/confirmedPassword/{hash}', [LoginController::class, 'confirmedPassword'])
            ->name('.confirmedPassword')
            ->where('hash', '.+');
    });


Route::group([], function () {
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');


    Route::prefix('/profile')
        ->name('profile')
        ->middleware('checkAuth')
        ->middleware('checkVerify')
        ->group(function () {
            Route::get('/', [ProfileController::class, 'index'])
                ->name('.index');

            Route::post('/', [ProfileController::class, 'update'])
                ->name('.update');

            Route::get('/change_password', [ProfileController::class, 'changePasswordPage'])
                ->name('.changePassword');

            Route::post('/change_password', [ProfileController::class, 'changePassword'])
                ->name('.changePassword');
        });


    Route::prefix('/admin')
        ->name('admin')
        ->middleware('checkAuth')
        ->middleware('checkVerify')
        ->middleware('checkIsAdmin')
        ->group(function () {
            Route::get('/users', [AdminController::class, 'users'])
                ->name('.users');

            Route::put('/users/changeRole', [AdminController::class, 'changeRole'])
                ->name('.users.changeRole');
        });


    Route::prefix('/director')
        ->name('director')
        ->middleware('checkAuth')
        ->middleware('checkVerify')
        ->middleware('checkIsDirector')
        ->group(function () {
            Route::get('/users', [DirectorController::class, 'users'])
                ->name('.users');

            Route::put('/users/changeRole', [DirectorController::class, 'changeRole'])
                ->name('.users.changeRole');
        });

    Route::prefix('/dispatcher')
        ->name('dispatcher')
        ->middleware('checkAuth')
        ->middleware('checkVerify')
        ->middleware('checkIsDispatcher')
        ->group(function () {
            Route::get('/map', [DispatcherController::class, 'mapPage'])
                ->name('.map');

            Route::post('/map/getAllOrders', [DispatcherController::class, 'getAllOrders']);

            Route::put('/map/changeStatus', [DispatcherController::class, 'changeStatus']);
            Route::put('/map/shiped', [DispatcherController::class, 'shiped']);
            Route::put('/map/moveToWarehouse', [DispatcherController::class, 'moveToWarehouse']);

        });

    Route::prefix('/driver')
        ->name('driver')
        ->middleware('checkAuth')
        ->middleware('checkVerify')
        ->middleware('checkIsDriver')
        ->group(function () {
            Route::get('/orderStatus', [DriverController::class, 'orderStatusPage'])
                ->name('.orderStatus');

            Route::put('/orderStatus', [DriverController::class, 'orderStatus'])
                ->name('.orderStatus');
        });

    Route::prefix('/client')
        ->middleware('checkAuth')
        ->middleware('checkVerify')
        ->middleware('checkIsClient')
        ->name('client')
        ->group(function () {
            Route::get('/order', [ClientController::class, 'orderPage'])
                ->name('.order');

            Route::post('/order', [ClientController::class, 'createOrder'])
                ->name('.order.create');

            Route::get('/card', [ClientController::class, 'cardPage'])
                ->name('.card');

            Route::post('/card', [ClientController::class, 'addOrder'])
                ->name('.order.add');

            Route::get('/orderStatus', [ClientController::class, 'orderStatus'])
                ->name('.orderStatus');
        });

    Route::prefix('/warehouseman')
        ->middleware('checkAuth')
        ->middleware('checkVerify')
        ->middleware('checkIsWarehouseman')
        ->name('warehouseman')
        ->group(function () {
            Route::get('/map', [WarehouseController::class, 'map'])
                ->name('.map');

            Route::post('/map/getAllOrders', [WarehouseController::class, 'getAllOrders']);

            Route::put('/map/changeStatus', [WarehouseController::class, 'changeStatus']);
            Route::put('/map/shiped', [WarehouseController::class, 'shiped']);

        });
});



