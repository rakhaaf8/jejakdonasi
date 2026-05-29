<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| UI Publik & Donatur
|--------------------------------------------------------------------------
*/
// Halaman Utama Publik
Route::get('/', [CampaignController::class, 'index'])->name('home');

// Form Submit Donasi Masuk
Route::post('/donate', [TransactionController::class, 'storeDonation'])->name('donate');

// Form Submit Laporan Kejanggalan (Whistleblower)
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');


/*
|--------------------------------------------------------------------------
| Autentikasi (UI / Simulasi)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/logout', function () {
    return redirect()->route('home');
})->name('logout');


/*
|--------------------------------------------------------------------------
| Dashboard Admin & Manajemen
|--------------------------------------------------------------------------
*/
// Rute Dashboard Utama (Memuat Data via ReportController)
Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

// CRUD Kampanye Kemanusiaan
Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaign.store');
Route::put('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaign.update');
Route::delete('/campaigns/{id}', [CampaignController::class, 'destroy'])->name('campaign.destroy');


/*
|--------------------------------------------------------------------------
| Core Web2.5: Siklus Penyaluran Dana & Ledger
|--------------------------------------------------------------------------
*/
// Relawan mengajukan pencairan + upload nota
Route::post('/expenditures/request', [TransactionController::class, 'requestExpenditure'])->name('expenditures.request');

// Admin memvalidasi pengajuan dan menguncinya menjadi Hash permanen
Route::post('/expenditures/validate', [TransactionController::class, 'storeExpenditure'])->name('expenditures.store');

// API Endpoint Opsional untuk Front-end Ledger
Route::get('/api/ledger', [TransactionController::class, 'getLedger'])->name('api.ledger');