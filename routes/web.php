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
Route::domain('gad.' . config('app.app_host'))->as('gad.')->group(function () {
    Route::get('/', [App\Http\Controllers\Others\GadController::class, 'index']);
    Route::get('/workforce', [App\Http\Controllers\Others\GadController::class, 'workforce']);
    Route::get('/customers', [App\Http\Controllers\Others\GadController::class, 'customers']);
    Route::get('/organizational-chart', [App\Http\Controllers\Others\GadController::class, 'organizationalChart']);
    Route::get('/knowledge-iec', [App\Http\Controllers\Others\GadController::class, 'knowledgeIec']);
});

Route::domain('customer.' . config('app.app_host'))->as('customer.')->group(function () {
    Route::get('/', function () {
        return 'wew';
    });
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [App\Http\Controllers\Customer\LoginController::class, 'index'])->name('login');
        Route::post('/mail', [App\Http\Controllers\Customer\LoginController::class, 'mail']);
        Route::post('/verify', [App\Http\Controllers\Customer\LoginController::class, 'verify']);
    });

    Route::middleware('auth:customer')->group(function () {
        Route::post('/logout', [App\Http\Controllers\Customer\LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('tsrs', App\Http\Controllers\Customer\TsrController::class);
        // Route::get('/{folder}/download', [App\Http\Controllers\Viewer\DownloadController::class, 'download'])->name('download');
        // Route::resource('folders', App\Http\Controllers\Viewer\FolderController::class);
        // Route::resource('downloads', App\Http\Controllers\Viewer\DownloadController::class);
        // Route::resource('/files', App\Http\Controllers\Viewer\FileController::class);
    });
});


Route::get('/pnpki', [App\Http\Controllers\Public\VerificationController::class, 'pnpki']);

Route::get('/verification', [App\Http\Controllers\Public\VerificationController::class, 'verification']);
Route::post('/verification', [App\Http\Controllers\Public\VerificationController::class, 'verify']);

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/fetch', [App\Http\Controllers\DashboardController::class, 'fetch']);
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

Route::prefix('insights')->group(function () {
    Route::get('/customers', [App\Http\Controllers\Insights\CustomerController::class, 'index']);
    Route::get('/customer/location', [App\Http\Controllers\Insights\CustomerController::class, 'location']);
    Route::get('/customer/discount', [App\Http\Controllers\Insights\CustomerController::class, 'discount']);
    Route::get('/payments', [App\Http\Controllers\Insights\PaymentController::class, 'index']);
    Route::get('/laboratories', [App\Http\Controllers\Insights\LaboratoryController::class, 'index']);
});

Route::prefix('accomplishments')->group(function () {
    Route::get('/', [App\Http\Controllers\Insights\AccomplishmentController::class, 'index']);
    Route::put('/update', [App\Http\Controllers\Insights\AccomplishmentController::class, 'update']);
});

require __DIR__.'/auth.php';
