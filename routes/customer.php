<?php

use Illuminate\Support\Facades\Route;

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
        Route::get('/fetch', [App\Http\Controllers\Customer\DashboardController::class, 'fetch']);

        Route::get('/verify-document', [App\Http\Controllers\Customer\DocumentVerificationController::class, 'index'])->name('verify-document');
        Route::post('/verify-document', [App\Http\Controllers\Customer\DocumentVerificationController::class, 'store']);

        Route::prefix('egovpay')->name('egovpay.')->group(function () {
            Route::post('/pay', [App\Http\Controllers\Customer\EgovPayController::class, 'pay'])->name('pay');
            Route::post('/callback', [App\Http\Controllers\Customer\EgovPayController::class, 'callback'])->name('callback');
            Route::get('/qr/{id}', [App\Http\Controllers\Customer\EgovPayController::class, 'qr']);
            Route::get('/success', [App\Http\Controllers\Customer\EgovPayController::class, 'success'])->name('success');
            Route::get('/failed', [App\Http\Controllers\Customer\EgovPayController::class, 'failed'])->name('failed');
        });

        Route::resource('tsrs', App\Http\Controllers\Customer\TsrController::class);
        Route::resource('downloads', App\Http\Controllers\Customer\TsrController::class);
        Route::resource('quotation', App\Http\Controllers\Customer\QuotationController::class);
         Route::resource('/categories', App\Http\Controllers\Common\CategoryController::class);
         Route::resource('/analyses', App\Http\Controllers\Major\AnalysisController::class);
        // Route::get('/{folder}/download', [App\Http\Controllers\Viewer\DownloadController::class, 'download'])->name('download');
        // Route::resource('folders', App\Http\Controllers\Viewer\FolderController::class);
        // Route::resource('downloads', App\Http\Controllers\Viewer\DownloadController::class);
        // Route::resource('/files', App\Http\Controllers\Viewer\FileController::class);
        Route::post('/checkout', [App\Http\Controllers\Finance\PaymentController::class, 'checkout']);
        Route::get('/payment/success', [App\Http\Controllers\Finance\PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/cancel', [App\Http\Controllers\Finance\PaymentController::class, 'cancel'])->name('payment.cancel');

        Route::post('/payments/qrph', [App\Http\Controllers\Finance\PaymentController::class, 'createQrph']);
         Route::get('/payments/{id}', [App\Http\Controllers\Finance\PaymentController::class, 'payments']);
        Route::get('/payments/{id}/status', [App\Http\Controllers\Finance\PaymentController::class, 'status']);
        Route::get('/payments/{id}/qr', [App\Http\Controllers\Finance\PaymentController::class, 'qr']);
        Route::post('/payments/webhook', [App\Http\Controllers\Finance\PaymentController::class, 'webhook']);

        
    });
});