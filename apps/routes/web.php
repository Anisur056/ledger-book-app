<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\LedgerBookController;
use App\Http\Controllers\AccountsHeadController;
use App\Http\Controllers\VoucherTransectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Business Routes
Route::resource('businesses', BusinessController::class);

// Ledger Book Routes (nested under businesses)
Route::prefix('businesses/{business}')->group(function () {
    Route::get('ledger-books', [LedgerBookController::class, 'index'])->name('businesses.ledger-books.index');
    Route::get('ledger-books/create', [LedgerBookController::class, 'create'])->name('businesses.ledger-books.create');
    Route::post('ledger-books', [LedgerBookController::class, 'store'])->name('businesses.ledger-books.store');
    Route::get('ledger-books/{ledgerBook}', [LedgerBookController::class, 'show'])->name('businesses.ledger-books.show');
    Route::get('ledger-books/{ledgerBook}/edit', [LedgerBookController::class, 'edit'])->name('businesses.ledger-books.edit');
    Route::put('ledger-books/{ledgerBook}', [LedgerBookController::class, 'update'])->name('businesses.ledger-books.update');
    Route::delete('ledger-books/{ledgerBook}', [LedgerBookController::class, 'destroy'])->name('businesses.ledger-books.destroy');
    
    // Accounts Head Routes (nested under businesses)
    Route::get('accounts-heads', [AccountsHeadController::class, 'index'])->name('businesses.accounts-heads.index');
    Route::get('accounts-heads/create', [AccountsHeadController::class, 'create'])->name('businesses.accounts-heads.create');
    Route::post('accounts-heads', [AccountsHeadController::class, 'store'])->name('businesses.accounts-heads.store');
    Route::get('accounts-heads/{accountsHead}', [AccountsHeadController::class, 'show'])->name('businesses.accounts-heads.show');
    Route::get('accounts-heads/{accountsHead}/edit', [AccountsHeadController::class, 'edit'])->name('businesses.accounts-heads.edit');
    Route::put('accounts-heads/{accountsHead}', [AccountsHeadController::class, 'update'])->name('businesses.accounts-heads.update');
    Route::delete('accounts-heads/{accountsHead}', [AccountsHeadController::class, 'destroy'])->name('businesses.accounts-heads.destroy');
});

// Voucher Transaction Routes (nested under ledger-books)
Route::prefix('ledger-books/{ledgerBook}')->group(function () {
    Route::get('voucher-transections', [VoucherTransectionController::class, 'index'])->name('ledger-books.voucher-transections.index');
    Route::get('voucher-transections/create', [VoucherTransectionController::class, 'create'])->name('ledger-books.voucher-transections.create');
    Route::post('voucher-transections', [VoucherTransectionController::class, 'store'])->name('ledger-books.voucher-transections.store');
    Route::get('voucher-transections/{voucherTransection}', [VoucherTransectionController::class, 'show'])->name('ledger-books.voucher-transections.show');
    Route::get('voucher-transections/{voucherTransection}/edit', [VoucherTransectionController::class, 'edit'])->name('ledger-books.voucher-transections.edit');
    Route::put('voucher-transections/{voucherTransection}', [VoucherTransectionController::class, 'update'])->name('ledger-books.voucher-transections.update');
    Route::delete('voucher-transections/{voucherTransection}', [VoucherTransectionController::class, 'destroy'])->name('ledger-books.voucher-transections.destroy');
    
    // Monthly Statement
    Route::get('monthly-statement', [VoucherTransectionController::class, 'monthlyStatement'])->name('ledger-books.monthly-statement');
});