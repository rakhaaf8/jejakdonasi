<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Campaign;
use App\Models\Transaction;

class ReportController extends Controller
{
    /**
     * Merender Dashboard Admin dengan menyuplai seluruh Data secara Komprehensif
     */
    public function index()
    {
        // 1. Data Kampanye
        $campaigns = Campaign::latest()->get();
        
        // 2. Data Antrean Pengeluaran (Ambil data yang memiliki string MENUNGGU_VALIDASI)
        $pendingExpenditures = Transaction::with('campaign')
            ->where('type', 'keluar')
            ->where('tx_hash', 'like', 'MENUNGGU_VALIDASI_%')
            ->latest()
            ->get();

        // 3. Data Laporan Kejanggalan (Whistleblower)
        $reports = Report::latest()->get();

        return view('dashboard', compact('campaigns', 'pendingExpenditures', 'reports'));
    }

    /**
     * Menyimpan laporan kejanggalan dari Form Publik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'campaign_name' => 'required|string|max:255', // UI mengirim nama kampanye
            'description'   => 'required|string',
        ]);

        // Lookup ID Kampanye (Opsional, menyesuaikan relasi database)
        $campaign = Campaign::where('title', $validated['campaign_name'])->first();
        $campaignId = $campaign ? $campaign->id : null;

        // Menyimpan data laporan
        Report::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'campaign_id' => $campaignId, 
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Laporan Anda berhasil dikirim secara aman. Tim Auditor Publik kami akan segera melakukan investigasi.');
    }
}