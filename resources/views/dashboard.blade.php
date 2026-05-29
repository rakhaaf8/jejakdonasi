<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JejakDonasi Web2.5</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['"Space Mono"', 'monospace'],
                    },
                    colors: {
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        [x-cloak] { display: none !important; }

        .receipt-edge {
            background-image: radial-gradient(circle at 10px 0, transparent 10px, white 11px);
            background-size: 20px 20px;
            background-repeat: repeat-x;
            height: 10px;
        }
        .receipt-edge-bottom {
            background-image: radial-gradient(circle at 10px 10px, transparent 10px, white 11px);
            background-size: 20px 20px;
            background-repeat: repeat-x;
            height: 10px;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased h-screen flex overflow-hidden selection:bg-slate-900 selection:text-white" x-data="adminDashboard()">

    <!-- Flash Message Success Indicator -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-slate-900 text-white px-6 py-3 rounded-full font-bold text-sm shadow-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- SIDEBAR -->
    <aside class="w-72 border-r border-slate-200 bg-white flex flex-col shrink-0 z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-200">
            <div class="text-xl font-bold tracking-tighter flex items-center gap-3 text-slate-900">
                <div class="w-6 h-6 bg-slate-900 rounded-full flex items-center justify-center">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                </div>
                Admin Panel
            </div>
        </div>
        
        <nav class="flex-1 py-8 px-4 flex flex-col gap-2">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 px-4">Menu Dashboard</div>
            
            <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                Overview
            </button>

            <button @click="tab = 'campaigns'" :class="tab === 'campaigns' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                Kelola Kampanye
            </button>
            
            <button @click="tab = 'validations'" :class="tab === 'validations' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left relative">
                <svg class="w-5 h-5" :class="tab === 'validations' ? 'text-emerald-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Validasi Pengeluaran
                @if(isset($pendingExpenditures) && $pendingExpenditures->count() > 0)
                    <span class="absolute right-4 w-5 h-5 bg-amber-500 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-sm">{{ $pendingExpenditures->count() }}</span>
                @endif
            </button>

            <!-- TAB BARU: Laporan Kejanggalan -->
            <button @click="tab = 'reports'" :class="tab === 'reports' ? 'bg-slate-100 text-slate-900 font-bold border-slate-200' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 border-transparent'" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left relative">
                <svg class="w-5 h-5" :class="tab === 'reports' ? 'text-red-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Laporan Kejanggalan
                @if(isset($reports) && $reports->count() > 0)
                    <span class="absolute right-4 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-sm">{{ $reports->count() }}</span>
                @endif
            </button>
            
            <div class="mt-auto pt-8 border-t border-slate-200">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-500 hover:text-red-600 hover:bg-red-50 font-bold text-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Keluar (Log Out)
                </a>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative bg-slate-50">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wNSkiLz48L3N2Zz4=')] pointer-events-none z-0"></div>

        <!-- TOPBAR -->
        <header class="h-20 px-8 flex justify-between items-center border-b border-slate-200 bg-white/80 backdrop-blur-md sticky top-0 z-10">
            <h1 class="text-xl font-bold tracking-tight text-slate-900 capitalize" x-text="tab === 'validations' ? 'Validasi Pengeluaran' : (tab === 'campaigns' ? 'Kelola Kampanye' : (tab === 'reports' ? 'Laporan Masuk' : 'Overview Dashboard'))"></h1>
            <div class="flex items-center gap-4">
                <div class="h-10 px-4 rounded-full bg-slate-100 border border-slate-200 text-slate-900 flex items-center gap-3 text-sm font-bold cursor-pointer hover:bg-slate-200 transition-colors">
                    <div class="w-6 h-6 bg-slate-900 text-white rounded-full flex items-center justify-center text-xs font-bold">A</div>
                    Admin Jejak
                </div>
            </div>
        </header>

        <div class="p-8 max-w-[100rem] mx-auto w-full z-10 flex flex-col gap-8 pb-20">

            <!-- TAB 1: OVERVIEW -->
            <div x-show="tab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <div class="bg-white border border-slate-200 rounded-[2rem] p-6 flex flex-col justify-between shadow-sm">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 mb-6">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-bold mb-1">Total Donasi Terkumpul</p>
                            <h2 class="text-3xl font-black text-slate-900 font-mono">Rp {{ isset($campaigns) ? number_format($campaigns->sum('collected_amount'), 0, ',', '.') : '0' }}</h2>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-[2rem] p-6 flex flex-col justify-between shadow-sm">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 mb-6">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-bold mb-1">Dana Tersalurkan</p>
                            <h2 class="text-3xl font-black text-emerald-600 font-mono">Tervalidasi</h2>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-[2rem] p-6 flex flex-col justify-between shadow-sm">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 mb-6">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-bold mb-1">Kampanye Aktif</p>
                            <h2 class="text-3xl font-black text-slate-900">{{ isset($campaigns) ? $campaigns->where('is_active', true)->count() : 0 }} Program</h2>
                        </div>
                    </div>
                    <div class="bg-amber-50 border border-amber-100 rounded-[2rem] p-6 flex flex-col justify-between shadow-sm">
                        <div class="w-10 h-10 rounded-2xl bg-amber-100 border border-amber-200 flex items-center justify-center text-amber-600 mb-6">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-amber-700 font-bold mb-1">Menunggu Validasi</p>
                            <h2 class="text-3xl font-black text-amber-600">{{ isset($pendingExpenditures) ? $pendingExpenditures->count() : 0 }} Antrean</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: KELOLA KAMPANYE -->
            <div x-show="tab === 'campaigns'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 md:p-8 border-b border-slate-200 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-slate-50">
                        <div>
                            <h3 class="text-xl font-black tracking-tight text-slate-900 mb-1">Daftar Kampanye</h3>
                            <p class="text-sm text-slate-500 font-medium">Buat, edit, atau hapus program donasi.</p>
                        </div>
                        <button @click="openCampaignModal(false)" class="bg-slate-900 text-white px-6 py-3.5 rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors shadow-md">
                            + Buat Kampanye Baru
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead>
                                <tr class="bg-white border-b border-slate-200 text-xs text-slate-500 font-bold tracking-wider uppercase">
                                    <th class="p-5 pl-8">Judul Kampanye</th>
                                    <th class="p-5">Target Dana</th>
                                    <th class="p-5">Progress</th>
                                    <th class="p-5 text-center">Status</th>
                                    <th class="p-5 pr-8 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @if(isset($campaigns))
                                    @forelse ($campaigns as $campaign)
                                        @php
                                            $percent = $campaign->target_amount > 0 ? min(100, round(($campaign->collected_amount / $campaign->target_amount) * 100)) : 0;
                                        @endphp
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="p-5 pl-8 font-bold text-slate-900 text-sm">{{ $campaign->title }}</td>
                                            <td class="p-5 text-slate-600 font-mono text-sm font-bold whitespace-nowrap">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                                            <td class="p-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-24 bg-slate-200 rounded-full h-2 overflow-hidden">
                                                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                                    </div>
                                                    <span class="text-xs font-bold text-emerald-600">{{ $percent }}%</span>
                                                </div>
                                            </td>
                                            <td class="p-5 text-center">
                                                <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold tracking-wider uppercase {{ $campaign->is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-red-50 text-red-600 border border-red-200' }}">
                                                    {{ $campaign->is_active ? 'Aktif' : 'Ditutup' }}
                                                </span>
                                            </td>
                                            <td class="p-5 pr-8 text-right">
                                                <div class="flex justify-end gap-2 items-center">
                                                    <button type="button" @click="openCampaignModal(true, {id: {{ $campaign->id }}, title: '{{ addslashes($campaign->title) }}', target_amount: '{{ $campaign->target_amount }}', description: '{{ addslashes($campaign->description) }}'})" class="px-3 py-2 text-xs font-bold text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                                                        Edit
                                                    </button>
                                                    
                                                    <form action="{{ route('campaign.destroy', $campaign->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kampanye ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-2 text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 hover:text-red-600 transition-colors shadow-sm">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-8 text-center text-slate-500 font-bold">Belum ada kampanye. Mulai buat kampanye kebaikan pertama Anda!</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: VALIDASI PENGELUARAN -->
            <div x-show="tab === 'validations'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 md:p-8 border-b border-slate-200 bg-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-slate-200 text-xs font-bold text-slate-600 mb-4 shadow-sm">
                                Core Web2.5 Feature
                            </div>
                            <h3 class="text-xl font-black tracking-tight text-slate-900 mb-2">Antrean Pencairan Dana</h3>
                            <p class="text-sm text-slate-500 font-medium max-w-xl leading-relaxed">
                                Verifikasi nota dari relawan. Klik <strong class="text-slate-900">Validasi & Kunci ke Ledger</strong> untuk menghasilkan cryptographic hash permanen.
                            </p>
                        </div>
                        
                        <button @click="isExpenditureRequestOpen = true" class="bg-emerald-600 text-white px-6 py-3.5 rounded-xl text-sm font-bold hover:bg-emerald-700 transition-colors shadow-md shrink-0">
                            + Ajukan Pengeluaran Baru
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[1000px]">
                            <thead>
                                <tr class="bg-white border-b border-slate-200 text-xs text-slate-500 font-bold tracking-wider uppercase">
                                    <th class="p-6 pl-8 w-[30%]">Tujuan Belanja & Kampanye</th>
                                    <th class="p-6 w-[15%]">Nominal</th>
                                    <th class="p-6 text-center w-[15%]">Bukti Fisik</th>
                                    <th class="p-6 w-[40%] text-right pr-8">Aksi Sistem</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @if(isset($pendingExpenditures))
                                    @forelse ($pendingExpenditures as $item)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="p-6 pl-8 align-top">
                                                <p class="text-base font-bold text-slate-900 mb-1.5">{{ $item->donor_name ?? 'Penyaluran Lapangan' }}</p>
                                                <p class="text-sm text-slate-500 font-medium">Kampanye: <span class="text-slate-700 font-bold">{{ $item->campaign->title ?? '-' }}</span></p>
                                            </td>
                                            
                                            <td class="p-6 align-top whitespace-nowrap">
                                                <span class="text-sm font-bold text-slate-900 font-mono bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
                                            </td>
                                            
                                            <td class="p-6 align-top text-center">
                                                <button @click="openReceipt({ store: 'Relawan Lapangan (Verified)', date: '{{ $item->created_at ? $item->created_at->format('d/m/Y') : date('d/m/Y') }}', purpose: '{{ addslashes($item->donor_name ?? 'Pengeluaran') }}', amount: '{{ number_format($item->amount, 0, ',', '.') }}', hash: 'Belum Terkunci' })" class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2.5 rounded-xl border border-blue-200 transition-colors shadow-sm whitespace-nowrap">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                                    Lihat Nota
                                                </button>
                                            </td>
                                            
                                            <td class="p-6 pr-8 text-right align-top">
                                                <form method="POST" action="{{ route('expenditures.store') }}" @submit="validatingId = {{ $item->id }}" class="flex flex-col items-end gap-2">
                                                    @csrf
                                                    <input type="hidden" name="transaction_id" value="{{ $item->id }}">
                                                    
                                                    <button type="submit" :disabled="validatingId === {{ $item->id }}" class="inline-flex items-center justify-center gap-2 bg-slate-900 text-white px-5 py-3 rounded-xl text-sm font-bold hover:bg-slate-800 transition-all disabled:opacity-50 disabled:cursor-wait shadow-md">
                                                        <span x-show="validatingId !== {{ $item->id }}">Validasi & Kunci ke Ledger</span>
                                                        <span x-show="validatingId === {{ $item->id }}" style="display: none;" class="flex items-center gap-2">
                                                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                            Hashing...
                                                        </span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-8 text-center text-slate-500 font-bold">Belum ada antrean pencairan dana untuk divalidasi.</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 4: LAPORAN MASUK (FITUR BARU) -->
            <div x-show="tab === 'reports'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 md:p-8 border-b border-slate-200 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-slate-50">
                        <div>
                            <h3 class="text-xl font-black tracking-tight text-slate-900 mb-1">Daftar Laporan Kejanggalan</h3>
                            <p class="text-sm text-slate-500 font-medium">Tindak lanjuti laporan dari masyarakat mengenai transparansi.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead>
                                <tr class="bg-white border-b border-slate-200 text-xs text-slate-500 font-bold tracking-wider uppercase">
                                    <th class="p-5 pl-8 w-[20%]">Pelapor</th>
                                    <th class="p-5 w-[20%]">Kampanye Dicurigai</th>
                                    <th class="p-5 w-[40%]">Deskripsi Laporan</th>
                                    <th class="p-5 pr-8 w-[20%] text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @if(isset($reports))
                                    @forelse ($reports as $report)
                                        <tr class="hover:bg-slate-50 transition-colors">
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
                                                <button type="button" onclick="alert('Laporan ditandai telah diinvestigasi/selesai.')" class="px-4 py-2.5 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 hover:text-emerald-700 transition-colors shadow-sm whitespace-nowrap">
                                                    Tandai Selesai
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-8 text-center text-slate-500 font-bold">Tidak ada laporan kejanggalan yang masuk. Sistem aman.</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- MODAL: FORM KAMPANYE WIRING (POST/PUT ACTION ROUTE) -->
    <div x-show="isCampaignModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="isCampaignModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="isCampaignModalOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4 sm:p-0 relative z-10">
            <div x-show="isCampaignModalOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                 class="relative transform overflow-hidden rounded-[2.5rem] bg-white border border-slate-200 text-left shadow-2xl transition-all sm:my-8 w-full max-w-2xl p-8 sm:p-10">
                
                <button @click="isCampaignModalOpen = false" type="button" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 p-2.5 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <h3 class="text-2xl font-black text-slate-900 mb-6" x-text="isEditMode ? 'Edit Kampanye' : 'Buat Kampanye Baru'"></h3>

                <form :action="isEditMode ? '/campaigns/' + currentCampaign.id : '{{ route('campaign.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <template x-if="isEditMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul Kampanye</label>
                        <input type="text" name="title" x-model="currentCampaign.title" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Dana (Rp)</label>
                        <input type="number" name="target_amount" x-model="currentCampaign.target_amount" required placeholder="Misal: 50000000" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Upload Gambar Utama (.avif, .jpg, dll)</label>
                        <input type="file" name="image" class="w-full bg-slate-50 border border-slate-300 text-slate-500 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-slate-900 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-900 hover:file:bg-slate-300 cursor-pointer">
                        <p x-show="isEditMode" class="text-xs text-slate-500 mt-2">*Kosongkan jika tidak ingin mengubah gambar lama</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Kampanye</label>
                        <textarea name="description" x-model="currentCampaign.description" required rows="4" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors resize-none"></textarea>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors shadow-lg">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: AJUKAN PENGELUARAN BARU (LAPANGAN) -->
    <div x-show="isExpenditureRequestOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="isExpenditureRequestOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="isExpenditureRequestOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4 sm:p-0 relative z-10">
            <div x-show="isExpenditureRequestOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                 class="relative transform overflow-hidden rounded-[2.5rem] bg-white border border-slate-200 text-left shadow-2xl transition-all sm:my-8 w-full max-w-xl p-8 sm:p-10">
                
                <button @click="isExpenditureRequestOpen = false" type="button" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 p-2.5 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <h3 class="text-2xl font-black text-slate-900 mb-6">Ajukan Pencairan Dana</h3>

                <form action="{{ route('expenditures.request') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Kampanye</label>
                        <select name="campaign_id" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors cursor-pointer appearance-none">
                            <option value="">-- Pilih Kampanye Aktif --</option>
                            @if(isset($campaigns))
                                @foreach($campaigns->where('is_active', true) as $camp)
                                    <option value="{{ $camp->id }}">{{ $camp->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nominal Pencairan (Rp)</label>
                        <input type="number" name="amount" required placeholder="Misal: 15000000" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tujuan Penggunaan Barang/Jasa</label>
                        <input type="text" name="purpose" required placeholder="Misal: Beli 100 Sak Semen di Toko Jaya" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Upload Bukti Fisik / Nota (.jpg, .pdf)</label>
                        <input type="file" name="receipt_file" required accept="image/*,application/pdf" class="w-full bg-slate-50 border border-slate-300 text-slate-500 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-slate-900 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-900 hover:file:bg-slate-300 cursor-pointer">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-xl text-sm font-bold hover:bg-emerald-700 transition-colors shadow-lg">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: NOTA DIGITAL HTML/CSS -->
    <div x-show="isReceiptOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="isReceiptOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="isReceiptOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4 sm:p-0 relative z-10">
            <div x-show="isReceiptOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="relative transform transition-all w-full max-w-sm mt-10">
                
                <button @click="isReceiptOpen = false" class="absolute -top-12 right-0 text-white hover:text-slate-200 bg-slate-800 p-2 rounded-full transition-colors z-20 shadow-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                
                <div class="bg-white text-slate-900 font-mono text-sm relative shadow-2xl">
                    <div class="receipt-edge w-full bg-transparent absolute -top-[10px] left-0"></div>
                    
                    <div class="p-8 pb-12 relative overflow-hidden">
                        <div class="text-center border-b-2 border-dashed border-slate-300 pb-5 mb-5">
                            <h3 class="font-bold text-xl uppercase tracking-widest mb-1" x-text="selectedReceiptData.store"></h3>
                            <p class="text-xs text-slate-500 font-medium">Sistem Validasi JejakDonasi</p>
                            <p class="text-xs text-slate-500 font-medium">NPWP: 01.234.567.8-901.000</p>
                        </div>
                        
                        <div class="flex justify-between items-center mb-1 text-xs font-bold">
                            <span>No. Ref:</span>
                            <span>WEB25-SYS</span>
                        </div>
                        <div class="flex justify-between items-center mb-5 text-xs text-slate-500 font-medium">
                            <span>Waktu Validasi:</span>
                            <span x-text="selectedReceiptData.date"></span>
                        </div>
                        
                        <div class="border-b-2 border-dashed border-slate-300 pb-5 mb-5 space-y-3">
                            <div class="flex justify-between font-bold text-xs uppercase tracking-wider mb-2">
                                <span>Item Belanja Lapangan</span>
                                <span>Nominal</span>
                            </div>
                            <div class="flex justify-between items-start text-xs font-bold">
                                <span class="pr-4 leading-relaxed uppercase" x-text="selectedReceiptData.purpose"></span>
                                <span class="whitespace-nowrap" x-text="'Rp ' + selectedReceiptData.amount"></span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between font-black text-lg pb-5 mb-5 border-b-2 border-slate-800">
                            <span>TOTAL</span>
                            <span x-text="'Rp ' + selectedReceiptData.amount"></span>
                        </div>
                        
                        <div class="text-center space-y-2">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500">Tx Hash Web2.5 Permanen</p>
                            <p class="text-[9px] bg-slate-100 p-2.5 rounded font-bold break-all text-slate-700 border border-slate-200" x-text="selectedReceiptData.hash"></p>
                            <p class="text-[10px] mt-4 font-bold text-slate-900">TERIMA KASIH ORANG BAIK</p>
                        </div>
                    </div>
                    
                    <div class="receipt-edge-bottom w-full bg-transparent absolute -bottom-[10px] left-0"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ALPINE LOGIC -->
    <script>
        function adminDashboard() {
            return {
                tab: 'overview',
                isCampaignModalOpen: false,
                isExpenditureRequestOpen: false,
                isEditMode: false,
                currentCampaign: { id: null, title: '', target_amount: '', description: '' },
                
                isReceiptOpen: false,
                selectedReceiptData: {},
                validatingId: null,

                openCampaignModal(isEdit, data = null) {
                    this.isEditMode = isEdit;
                    if (isEdit && data) {
                        this.currentCampaign = { ...data };
                    } else {
                        this.currentCampaign = { id: null, title: '', target_amount: '', description: '' };
                    }
                    this.isCampaignModalOpen = true;
                },

                openReceipt(data) {
                    this.selectedReceiptData = data;
                    this.isReceiptOpen = true;
                }
            }
        }
    </script>
</body>
</html>