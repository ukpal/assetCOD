<?php

use App\Http\Controllers\Administrator\HomeController;
use App\Http\Controllers\Administrator\ModuleController;
use App\Http\Controllers\Administrator\ModulePermissionController;
use App\Http\Controllers\Administrator\SubscriptionController;
use App\Http\Controllers\Administrator\CompanyController;
use App\Http\Controllers\PurchaseController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/','admin/dashboard');


Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/create_subdomain', [HomeController::class, 'createSudomain'])->name('create.subdomain');
    Route::get('/unzip', [HomeController::class, 'unzip'])->name('unzip');
    Route::get('/get-modulepermission/{id}', [ModulePermissionController::class, 'getModulePermissions'])->name('get-modulepermission');
    Route::post('/set-modulepermission', [ModulePermissionController::class, 'setModulePermission'])->name('set-modulepermission');
    Route::post('/purchase', [PurchaseController::class, 'index'])->name('purchase');
    Route::get('/purchase-local', [PurchaseController::class, 'local']);
    // Route::get('/send-mail', [PurchaseController::class, 'sendEmail']);

    Route::prefix('modules')->group(function () {
        Route::controller(ModuleController::class)->group(function () {
            Route::get('/', 'modules')->name('modules');
            Route::get('/create', 'createModule')->name('create.module');
            Route::post('/store', 'storeModule')->name('store.module');
            Route::get('/edit/{module}', 'editModule')->name('edit.module');
            Route::post('/update/{module}', 'updateModule')->name('update.module');
            // Route::get('/delete/{id}', 'deleteModule')->name('delete.module');
            Route::get('/status/update', 'statusUpdate')->name('update.status');
        });
    });
    Route::prefix('subscription')->group(function () {
        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('/', 'subscriptions')->name('subscription');
            Route::get('/new', 'createSubscription');
            Route::post('/store', 'storeSubscription');
            Route::get('/edit/{subscription}', 'editSubscription');
            Route::post('/update/{subscription_id}', 'updateSubscription');
            Route::get('/status/update', 'statusUpdate')->name('subscription.update.status');
        });
    });

    Route::prefix('companies')->group(function () {
        Route::controller(CompanyController::class)->group(function () {
            Route::get('/', 'companies')->name('companies');
            Route::get('/status/update', 'statusUpdate')->name('companies.update.status');
            Route::get('/new', 'create_company')->name('companies.new');
            Route::post('/register', 'store_company')->name('companies.register');
            Route::get('/off', 'offCompanyStatus');
        });
    });
});
