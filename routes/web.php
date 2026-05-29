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
Route::get('/', [CampaignController::class, 'index'])->name('home');
Route::post('/donate', [TransactionController::class, 'storeDonation'])->name('donate');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

/*
|--------------------------------------------------------------------------
| Autentikasi (UI Simulasi Role)
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
| Dashboard Admin (Manajemen, Ledger, Laporan)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

// CRUD Kampanye
Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaign.store');
Route::put('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaign.update');
Route::delete('/campaigns/{id}', [CampaignController::class, 'destroy'])->name('campaign.destroy');

// Laporan Kejanggalan (Tandai Selesai)
Route::patch('/reports/{id}/resolve', [ReportController::class, 'resolve'])->name('reports.resolve');

// Admin Validasi Pengeluaran -> Kunci ke Ledger (Hashing)
Route::post('/expenditures/validate', [TransactionController::class, 'storeExpenditure'])->name('expenditures.store');

/*
|--------------------------------------------------------------------------
| Dashboard Tim Lapangan (Hanya Pengajuan Dana)
|--------------------------------------------------------------------------
*/
Route::get('/field-dashboard', function () {
    $campaigns = \App\Models\Campaign::where('is_active', true)->get();
    return view('field_dashboard', compact('campaigns'));
})->name('field.dashboard');

// Tim Lapangan Mengajukan Pencairan + Nota
Route::post('/expenditures/request', [TransactionController::class, 'requestExpenditure'])->name('expenditures.request');

/*
|--------------------------------------------------------------------------
| API Endpoint
|--------------------------------------------------------------------------
*/
Route::get('/api/ledger', [TransactionController::class, 'getLedger'])->name('api.ledger');