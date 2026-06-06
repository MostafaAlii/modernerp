<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
            Route::get('dashboard', Dashboard\DashboardController::class)->name('dashboard');
            Route::controller(Dashboard\MainSettingsController::class)->prefix('mainSettings')->as('mainSettings.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('store', 'store')->name('store');
            });
            Route::middleware(['ensure.owner'])->group(function () {
                Route::resource('clients', Dashboard\ClientController::class);
                Route::post('clients/{client}/companies/store', [Dashboard\ClientController::class, 'storeCompany'])->name('clients.companies.store');
                Route::patch('clients/{client}/companies/{company}/status', [Dashboard\ClientController::class, 'updateCompanyStatus'])->name('clients.companies.updateStatus');
            });
            Route::resource('treasuries', Dashboard\TreasuryController::class);
            Route::patch('treasuries/{treasury}/toggle-status', [Dashboard\TreasuryController::class, 'toggleStatus'])->name('treasuries.toggleStatus');
            Route::patch('treasuries/{treasury}/toggle-master', [Dashboard\TreasuryController::class, 'toggleMaster'])->name('treasuries.toggleMaster');
            Route::post('treasuries/{treasury}/delivery', [Dashboard\TreasuryController::class, 'storeDelivery'])->name('treasuries.storeDelivery');
            Route::get('treasuries/{treasury}/delivery', [Dashboard\TreasuryController::class, 'getDeliveries'])->name('treasuries.getDeliveries');
            Route::delete('treasuries/delivery/{detail}', [Dashboard\TreasuryController::class, 'destroyDelivery'])->name('treasuries.destroyDelivery');

            // salesMatrialTypes
            Route::resource('salesMatrialTypes', Dashboard\SalesMatrialTypeController::class)->except(['show']);
            Route::patch('salesMatrialTypes/{salesMatrialType}/toggle-status',[Dashboard\SalesMatrialTypeController::class, 'toggleStatus'])->name('salesMatrialTypes.toggleStatus');
            // stores
            Route::resource('stores', Dashboard\StoreController::class)->except(['show']);
            Route::patch('stores/{store}/toggle-status', [Dashboard\StoreController::class, 'toggleStatus'])->name('stores.toggleStatus');
            // Inv Uoms Routes
            Route::resource('invUoms', Dashboard\InvUomController::class)->except(['show']);
            Route::patch('invUoms/{invUom}/toggle-status', [Dashboard\InvUomController::class, 'toggleStatus'])->name('invUoms.toggleStatus');
            Route::patch('invUoms/{invUom}/toggle-master', [Dashboard\InvUomController::class, 'toggleMaster'])->name('invUoms.toggleMaster');
            Route::resource('categories', Dashboard\CategoryController::class)->except(['show']);
            // Sales Units
            Route::resource('sales_units', Dashboard\SalesUnitController::class)->except(['show']);
            Route::resource('sizes', Dashboard\SizeController::class)->except(['show']);
        });
        require __DIR__ . '../../auth.php';
    }
);