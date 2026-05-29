<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'campaign_id'    => 'required|exists:campaigns,id',
            'amount'         => 'required|numeric|min:1000',
            'donor_name'     => 'nullable|string|max:255',
            'is_anonymous'   => 'nullable|boolean',
            'payment_method' => 'required|string',
        ]);

        $campaign = Campaign::findOrFail($validated['campaign_id']);
        $donorName = !empty($validated['is_anonymous']) ? 'Orang Baik (Anonim)' : ($validated['donor_name'] ?? 'Orang Baik');

        $payload = "IN|{$campaign->id}|{$validated['amount']}|{$donorName}|" . now()->timestamp;
        $txHash  = '0x' . hash('sha256', $payload);

        Transaction::create([
            'campaign_id'      => $campaign->id,
            'type'             => 'masuk',
            'amount'           => $validated['amount'],
            'donor_name'       => $donorName,
            'proof_of_receipt' => $validated['payment_method'],
            'tx_hash'          => $txHash,
        ]);

        $campaign->increment('collected_amount', $validated['amount']);

        return redirect()->back()->with('success', 'Terima kasih! Donasi Anda senilai Rp ' . number_format($validated['amount'], 0, ',', '.') . ' berhasil dicatat di Ledger.');
    }

    /**
     * Tim Lapangan mengajukan pengeluaran baru
     */
    public function requestExpenditure(Request $request)
    {
        $validated = $request->validate([
            'campaign_id'  => 'required|exists:campaigns,id',
            'amount'       => 'required|numeric|min:1',
            'purpose'      => 'required|string|max:255',
            'receipt_file' => 'required|file|mimes:jpg,jpeg,png,pdf,avif|max:2048',
        ]);

        $receiptPath = $request->file('receipt_file')->store('receipts', 'public');
        
        $pendingHash = 'MENUNGGU_VALIDASI_' . time() . '_' . Str::random(8);

        Transaction::create([
            'campaign_id'      => $validated['campaign_id'],
            'type'             => 'keluar',
            'amount'           => $validated['amount'],
            'donor_name'       => $validated['purpose'], 
            'proof_of_receipt' => $receiptPath,
            'tx_hash'          => $pendingHash, 
        ]);

        // REVISI: Mengarahkan kembali ke field.dashboard
        return redirect()->route('field.dashboard')->with('success', 'Pengajuan pengeluaran berhasil dikirim ke Admin untuk divalidasi.');
    }

    public function storeExpenditure(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        $transaction = Transaction::findOrFail($validated['transaction_id']);

        $timestamp = now()->timestamp;
        $payload   = "OUT|{$transaction->campaign_id}|{$transaction->amount}|{$transaction->donor_name}|{$timestamp}";
        $txHash    = hash('sha256', $payload);

        $transaction->update([
            'tx_hash' => '0x' . $txHash
        ]);

        return redirect()->route('dashboard')->with('success', 'Validasi sukses! Data pengeluaran telah dikunci permanen ke Ledger.');
    }

    public function getLedger()
    {
        $ledgers = Transaction::with('campaign')
            ->where('type', 'keluar')
            ->where('tx_hash', 'not like', 'MENUNGGU_VALIDASI_%')
            ->latest()
            ->get();

        return response()->json(['status' => 'success', 'data' => $ledgers]);
    }
}