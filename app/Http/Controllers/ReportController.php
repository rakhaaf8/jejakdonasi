<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Campaign;
use App\Models\Transaction;

class ReportController extends Controller
{
    /**
     * Menampilkan Dashboard Admin (Kampanye, Validasi, Laporan)
     */
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        
        $pendingExpenditures = Transaction::with('campaign')
            ->where('type', 'keluar')
            ->where('tx_hash', 'like', 'MENUNGGU_VALIDASI_%')
            ->latest()
            ->get();

        // Hanya mengambil laporan yang belum diselesaikan (asumsi menggunakan delete saat resolve)
        $reports = Report::latest()->get();

        return view('dashboard', compact('campaigns', 'pendingExpenditures', 'reports'));
    }

    /**
     * Menerima Laporan Kejanggalan dari Form Publik (welcome.blade.php)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'campaign_name' => 'required|string|max:255',
            'description'   => 'required|string',
        ]);

        $campaign = Campaign::where('title', $validated['campaign_name'])->first();
        $campaignId = $campaign ? $campaign->id : null;

        Report::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'campaign_id' => $campaignId, 
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Laporan Anda berhasil dikirim. Tim Auditor Publik akan segera menindaklanjuti.');
    }

    /**
     * Menyelesaikan Laporan (Menghapus / Menyembunyikan dari antrean)
     */
    public function resolve($id)
    {
        $report = Report::findOrFail($id);
        
        // Menghapus laporan setelah diinvestigasi (sebagai penyelesaian)
        $report->delete();

        return redirect()->back()->with('success', 'Laporan berhasil ditandai selesai dan telah diarsipkan.');
    }
}