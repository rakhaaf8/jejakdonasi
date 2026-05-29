<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Menerima Donasi Masuk (Otomatis Hashes & Tambah Saldo)
     */
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

        // Hash instan sebagai bukti penerimaan dana dari Payment Gateway
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

        // CORE LOGIC: Tambahkan saldo terkumpul pada kampanye
        $campaign->increment('collected_amount', $validated['amount']);

        return redirect()->back()->with('success', 'Terima kasih! Donasi Anda senilai Rp ' . number_format($validated['amount'], 0, ',', '.') . ' berhasil dicatat di Ledger.');
    }

    /**
     * Relawan Lapangan mengajukan pengeluaran baru (Mencegah error 'tx_hash cannot be null')
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
        
        // Mencegah Error Null Constraint: Kita isi dengan identifier unik sementara
        $pendingHash = 'MENUNGGU_VALIDASI_' . time() . '_' . Str::random(8);

        Transaction::create([
            'campaign_id'      => $validated['campaign_id'],
            'type'             => 'keluar',
            'amount'           => $validated['amount'],
            'donor_name'       => $validated['purpose'], 
            'proof_of_receipt' => $receiptPath,
            'tx_hash'          => $pendingHash, 
        ]);

        return redirect()->back()->with('success', 'Pengajuan pengeluaran berhasil dikirim dan menunggu validasi Admin.');
    }

    /**
     * CORE WEB2.5: Admin memvalidasi pengeluaran (Update Status menjadi Hashed)
     */
    public function storeExpenditure(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        // Ambil data transaksi yang statusnya masih 'MENUNGGU_VALIDASI'
        $transaction = Transaction::findOrFail($validated['transaction_id']);

        // 1. Ekstraksi Payload Data
        $timestamp = now()->timestamp;
        $payload   = "OUT|{$transaction->campaign_id}|{$transaction->amount}|{$transaction->donor_name}|{$timestamp}";

        // 2. Cryptographic Hashing Process (SHA-256)
        $txHash = hash('sha256', $payload);

        // 3. Timpa baris string 'MENUNGGU_VALIDASI_...' dengan format Hash aslinya
        $transaction->update([
            'tx_hash' => '0x' . $txHash
        ]);

        return redirect()->route('dashboard')->with('success', 'Validasi sukses! Data pengeluaran telah dikunci permanen ke Ledger.');
    }

    /**
     * Endpoint API JSON Public Ledger
     */
    public function getLedger()
    {
        $ledgers = Transaction::with('campaign')
            ->where('type', 'keluar')
            ->where('tx_hash', 'not like', 'MENUNGGU_VALIDASI_%') // Pastikan data pending tidak bocor ke publik
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $ledgers
        ]);
    }
}