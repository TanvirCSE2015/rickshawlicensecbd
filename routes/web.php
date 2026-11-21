<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\PrintReportController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\JanataPayController;

Route::get('/',        [ApplicantController::class, 'home'])->name('home');
Route::get('/apply',   [ApplicantController::class, 'create'])->name('applicant.create');
Route::get('/status',  [ApplicantController::class, 'status'])->name('applicant.status');
// Route::get('/', [ApplicantController::class, 'create'])->name('home');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicant.store');
Route::post('/applicant/search', [ApplicantController::class, 'search'])->name('applicant.search');
Route::get('/applicant/{id}/details', [ApplicantController::class, 'viewDetails'])
    ->name('applicant.details');
Route::get('/applicant/{id}/edit', [ApplicantController::class, 'edit'])
    ->name('applicant.edit');
Route::put('/applicant/{applicant}', [ApplicantController::class, 'update'])
    ->name('applicant.update');
Route::get('/application/print', [ApplicantController::class, 'print'])->name('applicant.print');
Route::post('/applicant/{applicant}/yearly-fee/payment', [
    ApplicantController::class,
    'payYearlyFee'
])->name('applicant.yearly-fee.payment');


//Receipt Routes
Route::get('/print-receipt', [ReceiptController::class, 'PrintReceipt'])->name('applicant.receipt');

// Application Report Print Route
Route::get('/application-report/print', [PrintReportController::class, 'PrintApplicationReport'])
    ->name('application-report-print');

Route::get('/category-application-report/print', [PrintReportController::class, 'PrintCategoryApplicationReport'])
    ->name('category-application-report-print');

Route::get('/summery-application-report/print', [PrintReportController::class, 'PrintSummeryApplicationReport'])
    ->name('summery-application-report-print');

Route::get('/lottery-token/print', [PrintReportController::class, 'PrintLotteryToken'])
    ->name('lottery-token-print');

Route::get('/tokens', function(){
    return view('receipt.tokens_print');
});

// Route::get(
//     '/payments/success',
//     [JanataPayController::class, 'callback']
// )->name('janatapay.callback');
Route::get('/payment/callback', [JanataPayController::class, 'callback'])->name('janatapay.callback'); 
Route::get('/payment-result', [JanataPayController::class, 'result'])->name('payment.result');

