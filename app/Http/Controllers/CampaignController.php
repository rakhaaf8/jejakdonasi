<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * Menampilkan halaman utama dengan data kampanye dan ledger publik
     */
    public function index()
    {
        $campaigns = Campaign::where('is_active', true)->latest()->get();
        
        $publicLedgers = Transaction::with('campaign')
            ->where('type', 'keluar')
            ->whereNotNull('tx_hash')
            ->latest()
            ->get();

        return view('welcome', compact('campaigns', 'publicLedgers'));
    }

    /**
     * Menyimpan kampanye baru dari Admin Dashboard
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'description'   => 'required|string',
            'image'         => 'nullable|file|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
        }

        Campaign::create([
            'title'            => $validated['title'],
            'description'      => $validated['description'],
            'target_amount'    => $validated['target_amount'],
            'collected_amount' => 0,
            'is_active'        => true,
            'image'            => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kampanye berhasil dibuat!');
    }

    /**
     * Memperbarui data kampanye (Edit)
     */
    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'description'   => 'required|string',
            'image'         => 'nullable|file|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'is_active'     => 'boolean',
        ]);

        // Cek jika admin mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama agar storage tidak penuh
            if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
                Storage::disk('public')->delete($campaign->image);
            }
            $campaign->image = $request->file('image')->store('campaigns', 'public');
        }

        $campaign->title         = $validated['title'];
        $campaign->description   = $validated['description'];
        $campaign->target_amount = $validated['target_amount'];
        
        // Update status aktif jika dikirim form
        if ($request->has('is_active')) {
            $campaign->is_active = $request->is_active;
        }

        $campaign->save();

        return redirect()->route('dashboard')->with('success', 'Kampanye berhasil diperbarui!');
    }

    /**
     * Menghapus kampanye
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        
        // Bersihkan gambar di storage sebelum menghapus record
        if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
            Storage::disk('public')->delete($campaign->image);
        }
        
        $campaign->delete();

        return redirect()->route('dashboard')->with('success', 'Kampanye berhasil dihapus secara permanen.');
    }
}