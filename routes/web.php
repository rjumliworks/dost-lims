<?php

use App\Http\Controllers\VelzonRoutesController;
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

Route::get('/verification', [App\Http\Controllers\Public\VerificationController::class, 'verification']);
Route::post('/verification', [App\Http\Controllers\Public\VerificationController::class, 'verify']);

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/fetch', [App\Http\Controllers\DashboardController::class, 'search']);
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'search']);

    Route::resource('/customers', App\Http\Controllers\Common\CustomerController::class);
    Route::resource('/categories', App\Http\Controllers\Common\CategoryController::class);
    Route::resource('/testservices', App\Http\Controllers\Common\TestserviceController::class);
    Route::resource('/packages', App\Http\Controllers\Common\PackageController::class);

    Route::resource('/tsrs', App\Http\Controllers\Major\TsrController::class);
    Route::resource('/quotations', App\Http\Controllers\Major\QuotationController::class);
    Route::resource('/samples', App\Http\Controllers\Major\SampleController::class);
    Route::resource('/analyses', App\Http\Controllers\Major\AnalysisController::class);
    Route::resource('/testreports', App\Http\Controllers\Major\TestreportController::class);
});

Route::middleware(['role:Laboratory Analyst,Calibration Officer,Technical Manager,Laboratory Head'])->group(function () {

});

Route::middleware(['role:Accountant,Cashier'])->group(function () {
    Route::resource('/orderofpayments', App\Http\Controllers\Finance\OpController::class);
    Route::resource('/receipts', App\Http\Controllers\Finance\OrController::class);
    Route::resource('/nonlabreceipts', App\Http\Controllers\Finance\NonlabController::class);
    Route::resource('/cashiering', App\Http\Controllers\Finance\CashieringController::class);
    Route::get('/orseries', [App\Http\Controllers\Finance\CashieringController::class, 'orseries']);
    Route::get('/names', [App\Http\Controllers\Finance\CashieringController::class, 'names']);
});

Route::middleware(['role:Administrator'])->group(function () {
    Route::resource('/users', App\Http\Controllers\Executive\UserController::class);
    Route::resource('/agencies', App\Http\Controllers\Executive\AgencyController::class);
    Route::resource('/references', App\Http\Controllers\Executive\ReferenceController::class);
    Route::resource('/discounts', App\Http\Controllers\Executive\DiscountController::class);
});

Route::get('/customer/login', [App\Http\Controllers\Public\CustomerController::class, 'login'])->name('customer.login');
Route::middleware('auth:customer')->group(function () {
    Route::get('/customer', [App\Http\Controllers\Public\CustomerController::class, 'view'])->name('customer.dashboard');
    Route::get('/customer/tsrs', [App\Http\Controllers\Public\CustomerController::class, 'tsrs']);
    Route::get('/customer/profile', [App\Http\Controllers\Public\CustomerController::class, 'profile']);
    Route::get('/customer/logout', [App\Http\Controllers\Public\CustomerController::class, 'logout'])->name('customer.logout');
});
Route::post('/mail', [App\Http\Controllers\Public\OtpController::class, 'mail']);
Route::post('/verify', [App\Http\Controllers\Public\OtpController::class, 'verify']);

require __DIR__.'/auth.php';
