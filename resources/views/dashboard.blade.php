<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JejakDonasi Web2.5</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], mono: ['"Space Mono"', 'monospace'] } } } }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased h-screen flex overflow-hidden selection:bg-slate-900 selection:text-white" x-data="{ tab: 'overview', isCampaignModalOpen: false, isEditMode: false, currentCampaign: {} }">

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-slate-900 text-white px-6 py-3 rounded-full font-bold text-sm shadow-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <aside class="w-72 border-r border-slate-200 bg-white flex flex-col shrink-0 z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-200">
            <div class="text-xl font-bold tracking-tighter flex items-center gap-3 text-slate-900">
                <div class="w-6 h-6 bg-slate-900 rounded-full flex items-center justify-center"><div class="w-2 h-2 bg-white rounded-full"></div></div>
                Admin Panel
            </div>
        </div>
        
        <nav class="flex-1 py-8 px-4 flex flex-col gap-2">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 px-4">Menu Dashboard</div>
            
            <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg> Overview
            </button>

            <button @click="tab = 'campaigns'" :class="tab === 'campaigns' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg> Kelola Kampanye
            </button>
            
            <button @click="tab = 'validations'" :class="tab === 'validations' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left relative">
                <svg class="w-5 h-5" :class="tab === 'validations' ? 'text-emerald-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Validasi Pengeluaran
                @if(isset($pendingExpenditures) && $pendingExpenditures->count() > 0)
                    <span class="absolute right-4 w-5 h-5 bg-amber-500 text-white rounded-full flex items-center justify-center text-[10px] font-bold">{{ $pendingExpenditures->count() }}</span>
                @endif
            </button>

            <button @click="tab = 'reports'" :class="tab === 'reports' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left relative">
                <svg class="w-5 h-5" :class="tab === 'reports' ? 'text-red-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Laporan Masuk
                @if(isset($reports) && $reports->count() > 0)
                    <span class="absolute right-4 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-[10px] font-bold">{{ $reports->count() }}</span>
                @endif
            </button>
            
            <div class="mt-auto pt-8 border-t border-slate-200">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-500 hover:text-red-600 hover:bg-red-50 font-bold text-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg> Keluar (Log Out)
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative bg-slate-50">
        <header class="h-20 px-8 flex justify-between items-center border-b border-slate-200 bg-white/80 backdrop-blur-md sticky top-0 z-10">
            <h1 class="text-xl font-bold tracking-tight text-slate-900 capitalize" x-text="tab === 'validations' ? 'Validasi Pengeluaran' : (tab === 'campaigns' ? 'Kelola Kampanye' : (tab === 'reports' ? 'Laporan Masuk' : 'Overview Dashboard'))"></h1>
            <div class="h-10 px-4 rounded-full bg-slate-100 border border-slate-200 text-slate-900 flex items-center gap-3 text-sm font-bold">
                <div class="w-6 h-6 bg-slate-900 text-white rounded-full flex items-center justify-center text-xs font-bold">A</div> Admin Jejak
            </div>
        </header>

        <div class="p-8 max-w-[100rem] mx-auto w-full z-10 flex flex-col gap-8 pb-20">

            <!-- TAB 1: OVERVIEW -->
            <div x-show="tab === 'overview'" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
                        <p class="text-sm text-slate-500 font-bold mb-1">Total Donasi Terkumpul</p>
                        <h2 class="text-3xl font-black text-slate-900 font-mono">Rp {{ isset($campaigns) ? number_format($campaigns->sum('collected_amount'), 0, ',', '.') : '0' }}</h2>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
                        <p class="text-sm text-slate-500 font-bold mb-1">Kampanye Aktif</p>
                        <h2 class="text-3xl font-black text-slate-900">{{ isset($campaigns) ? $campaigns->where('is_active', true)->count() : 0 }} Program</h2>
                    </div>
                    <div class="bg-amber-50 border border-amber-100 rounded-[2rem] p-6 shadow-sm">
                        <p class="text-sm text-amber-700 font-bold mb-1">Menunggu Validasi</p>
                        <h2 class="text-3xl font-black text-amber-600">{{ isset($pendingExpenditures) ? $pendingExpenditures->count() : 0 }} Antrean</h2>
                    </div>
                    <div class="bg-red-50 border border-red-100 rounded-[2rem] p-6 shadow-sm">
                        <p class="text-sm text-red-700 font-bold mb-1">Laporan Kejanggalan</p>
                        <h2 class="text-3xl font-black text-red-600">{{ isset($reports) ? $reports->count() : 0 }} Laporan</h2>
                    </div>
                </div>
            </div>

            <!-- TAB 2: KELOLA KAMPANYE -->
            <div x-show="tab === 'campaigns'" x-cloak>
                <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 md:p-8 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 mb-1">Daftar Kampanye</h3>
                            <p class="text-sm text-slate-500 font-medium">Buat, edit, atau tutup program.</p>
                        </div>
                        <button @click="isCampaignModalOpen = true; isEditMode = false; currentCampaign = {}" class="bg-slate-900 text-white px-6 py-3.5 rounded-xl text-sm font-bold hover:bg-slate-800 shadow-md">
                            + Buat Kampanye Baru
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs text-slate-500 font-bold uppercase">
                                    <th class="p-5 pl-8">Judul Kampanye</th>
                                    <th class="p-5">Target Dana</th>
                                    <th class="p-5 text-center">Status</th>
                                    <th class="p-5 pr-8 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($campaigns ?? [] as $campaign)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-5 pl-8 font-bold text-slate-900 text-sm">{{ $campaign->title }}</td>
                                        <td class="p-5 text-slate-600 font-mono text-sm font-bold whitespace-nowrap">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                                        <td class="p-5 text-center">
                                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase {{ $campaign->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                                {{ $campaign->is_active ? 'Aktif' : 'Ditutup' }}
                                            </span>
                                        </td>
                                        <td class="p-5 pr-8 text-right">
                                            <button @click="isCampaignModalOpen = true; isEditMode = true; currentCampaign = {id: {{ $campaign->id }}, title: '{{ addslashes($campaign->title) }}', target_amount: '{{ $campaign->target_amount }}', description: '{{ addslashes($campaign->description) }}'}" class="px-3 py-2 text-xs font-bold text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50">Edit</button>
                                            <form action="{{ route('campaign.destroy', $campaign->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kampanye ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-2 text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 hover:text-red-600">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-8 text-center text-slate-500 font-bold">Belum ada kampanye.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: VALIDASI PENGELUARAN -->
            <div x-show="tab === 'validations'" x-cloak>
                <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 md:p-8 border-b border-slate-200 bg-slate-50">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-slate-200 text-xs font-bold text-slate-600 mb-4 shadow-sm">Core Web2.5 Feature</div>
                        <h3 class="text-xl font-black text-slate-900 mb-2">Antrean Pencairan Dana</h3>
                        <p class="text-sm text-slate-500 font-medium">Validasi nota dari relawan untuk dikunci ke Ledger menggunakan Cryptographic Hash.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs text-slate-500 font-bold uppercase">
                                    <th class="p-6 pl-8">Tujuan Belanja</th>
                                    <th class="p-6">Nominal</th>
                                    <th class="p-6 text-center">Bukti Fisik</th>
                                    <th class="p-6 text-right pr-8">Aksi Sistem</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($pendingExpenditures ?? [] as $item)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-6 pl-8 align-top">
                                            <p class="font-bold text-slate-900 mb-1">{{ $item->donor_name }}</p>
                                            <p class="text-sm text-slate-500 font-medium">{{ $item->campaign->title ?? '-' }}</p>
                                        </td>
                                        <td class="p-6 align-top whitespace-nowrap">
                                            <span class="text-sm font-bold text-slate-900 font-mono bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="p-6 align-top text-center">
                                            <!-- Buka gambar asli di tab baru krn ini adalah bukti yang diupload relawan -->
                                            <a href="{{ asset('storage/' . $item->proof_of_receipt) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-600 bg-blue-50 px-4 py-2.5 rounded-xl border border-blue-200">
                                                Lihat Nota Relawan
                                            </a>
                                        </td>
                                        <td class="p-6 pr-8 text-right align-top">
                                            <form method="POST" action="{{ route('expenditures.store') }}" class="flex flex-col items-end">
                                                @csrf
                                                <input type="hidden" name="transaction_id" value="{{ $item->id }}">
                                                <button type="submit" class="bg-slate-900 text-white px-5 py-3 rounded-xl text-sm font-bold hover:bg-slate-800 shadow-md">
                                                    Validasi & Kunci ke Ledger
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-8 text-center text-slate-500 font-bold">Antrean bersih.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 4: LAPORAN MASUK -->
            <div x-show="tab === 'reports'" x-cloak>
                <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 md:p-8 border-b border-slate-200 bg-slate-50">
                        <h3 class="text-xl font-black text-slate-900 mb-1">Daftar Laporan Kejanggalan</h3>
                        <p class="text-sm text-slate-500 font-medium">Tindak lanjuti laporan dari donatur (Whistleblower).</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs text-slate-500 font-bold uppercase">
                                    <th class="p-5 pl-8 w-1/4">Pelapor</th>
                                    <th class="p-5 w-1/4">Kampanye</th>
                                    <th class="p-5 w-2/4">Deskripsi</th>
                                    <th class="p-5 pr-8 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($reports ?? [] as $report)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-5 pl-8 align-top">
                                            <p class="font-bold text-slate-900 text-sm mb-1">{{ $report->name }}</p>
                                            <p class="text-slate-500 text-xs font-medium">{{ $report->email }}</p>
                                        </td>
                                        <td class="p-5 text-slate-700 font-bold text-sm align-top">
                                            {{ $report->campaign_id ? ($report->campaign->title ?? 'Umum') : 'Umum / Lainnya' }}
                                        </td>
                                        <td class="p-5 text-slate-600 text-sm leading-relaxed align-top">
                                            {{ $report->description }}
                                        </td>
                                        <td class="p-5 pr-8 text-right align-top">
                                            <!-- FORM PATCH UNTUK MENYELESAIKAN LAPORAN -->
                                            <form action="{{ route('reports.resolve', $report->id) }}" method="POST" onsubmit="return confirm('Tandai laporan ini telah diinvestigasi/selesai?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-4 py-2.5 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 whitespace-nowrap">
                                                    Tandai Selesai
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-8 text-center text-slate-500 font-bold">Tidak ada laporan. Sistem aman.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- MODAL FORM KAMPANYE (CREATE/EDIT) -->
    <div x-show="isCampaignModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div x-show="isCampaignModalOpen" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="isCampaignModalOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform bg-white border border-slate-200 rounded-[2.5rem] shadow-2xl w-full max-w-2xl p-8 sm:p-10 z-10">
                <button @click="isCampaignModalOpen = false" type="button" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 p-2.5 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <h3 class="text-2xl font-black text-slate-900 mb-6" x-text="isEditMode ? 'Edit Kampanye' : 'Buat Kampanye Baru'"></h3>
                
                <form :action="isEditMode ? '/campaigns/' + currentCampaign.id : '{{ route('campaign.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <template x-if="isEditMode"><input type="hidden" name="_method" value="PUT"></template>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul Kampanye</label>
                        <input type="text" name="title" x-model="currentCampaign.title" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Dana (Rp)</label>
                        <input type="number" name="target_amount" x-model="currentCampaign.target_amount" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Upload Gambar (.avif/jpg)</label>
                        <input type="file" name="image" class="w-full bg-slate-50 border border-slate-300 text-slate-500 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="description" x-model="currentCampaign.description" required rows="4" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl text-sm font-bold hover:bg-slate-800 shadow-lg">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>