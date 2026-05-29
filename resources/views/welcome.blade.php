<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JejakDonasi - Transparansi Tanpa Kompromi</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
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
                        slate: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 800: '#1e293b', 900: '#0f172a' }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        [x-cloak] { display: none !important; }
        .glass-nav { background: rgba(248, 250, 252, 0.9); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .receipt-edge { background-image: radial-gradient(circle at 10px 0, transparent 10px, white 11px); background-size: 20px 20px; background-repeat: repeat-x; height: 10px; }
        .receipt-edge-bottom { background-image: radial-gradient(circle at 10px 10px, transparent 10px, white 11px); background-size: 20px 20px; background-repeat: repeat-x; height: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased overflow-x-hidden selection:bg-slate-900 selection:text-white" x-data="appData()">

    <!-- Flash Message Success Indicator -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-emerald-600 text-white px-6 py-3 rounded-full font-bold text-sm shadow-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- LATAR BELAKANG MINIMALIS BERSIH -->
    <div class="fixed inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wMikiLz48L3N2Zz4=')] pointer-events-none z-0"></div>

    <!-- NAVBAR LIGHT -->
    <nav class="fixed top-0 w-full z-40 glass-nav border-b border-slate-200 transition-all duration-300">
        <div class="max-w-[90rem] mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold tracking-tighter flex items-center gap-3 relative z-10 text-slate-900">
                <div class="w-6 h-6 bg-slate-900 rounded-full flex items-center justify-center">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                </div>
                JejakDonasi
            </div>
            
            <div class="flex items-center gap-3 md:gap-4 relative z-10">
                <a href="#ledger" class="hidden md:block text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors mr-2">Ledger Publik</a>
                <button @click="isReportOpen = true" class="text-sm font-bold text-red-600 hover:text-red-700 transition-colors duration-300 border border-red-200 hover:bg-red-50 px-4 md:px-5 py-2 md:py-2.5 rounded-full bg-white shadow-sm">
                    Lapor Kejanggalan
                </button>
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-white transition-colors duration-300 border border-slate-300 hover:border-slate-900 px-4 md:px-5 py-2 md:py-2.5 rounded-full bg-white hover:bg-slate-900 shadow-sm">
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative min-h-[95vh] flex flex-col justify-center items-center text-center px-6 pt-32 pb-20 z-10">
        <div class="max-w-5xl" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-200 bg-white shadow-sm text-xs font-bold text-slate-600 mb-8 transition-all duration-1000 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Web2.5 Public Ledger Aktif
            </div>
            
            <h1 class="text-6xl md:text-8xl lg:text-[7.5rem] font-black tracking-tighter text-slate-900 leading-[1.05] mb-8 transition-all duration-1000 delay-100 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                Jejak Kebaikan <br class="hidden md:block"> <span class="text-slate-400">Permanen.</span>
            </h1>
            
            <p class="text-lg md:text-2xl text-slate-600 mb-12 max-w-3xl mx-auto font-medium leading-relaxed transition-all duration-1000 delay-200 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                Platform pendanaan sosial yang memastikan setiap rupiah Anda terekam utuh di buku besar digital. Lacak aliran dana Anda secara transparan.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 md:gap-5 transition-all duration-1000 delay-300 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <a href="#initiatives" class="w-full sm:w-auto bg-slate-900 text-white px-10 py-4.5 rounded-full text-sm md:text-base font-bold hover:bg-slate-800 transition-all duration-300 transform hover:scale-105 shadow-xl flex justify-center">
                    Lihat Inisiatif
                </a>
                <a href="#how-it-works" class="w-full sm:w-auto bg-white border border-slate-300 text-slate-700 px-10 py-4.5 rounded-full text-sm md:text-base font-bold hover:bg-slate-50 transition-all duration-300 flex justify-center shadow-sm">
                    Cara Kerja
                </a>
            </div>
        </div>
    </header>

    <!-- CARA KERJA -->
    <section id="how-it-works" class="py-32 px-6 max-w-[90rem] mx-auto relative z-10 border-t border-slate-200">
        <div class="mb-20 text-center md:text-left">
            <h2 class="text-4xl md:text-5xl font-black tracking-tighter text-slate-900 mb-4">Bagaimana Kami Menjaga Amanah?</h2>
            <p class="text-slate-500 text-lg font-medium">Proses transparan dari dompet Anda hingga ke tangan mereka yang membutuhkan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-16 relative">
            <div class="hidden md:block absolute top-12 left-[10%] right-[10%] h-[2px] z-0 border-dashed border-t-2 border-slate-300"></div>

            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black text-xl mb-6 shadow-md">1</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Donasi Rupiah Biasa</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Menyumbang menggunakan Rupiah via transfer Bank atau QRIS. Sangat praktis.</p>
            </div>
            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black text-xl mb-6 shadow-md">2</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Penyaluran Dana</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Dana disalurkan ke relawan lapangan untuk dibelanjakan sesuai kebutuhan.</p>
            </div>
            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black text-xl mb-6 shadow-md">3</div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Unggah Bukti Nota</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Relawan wajib mengunggah foto BUKTI NOTA ke sistem JejakDonasi.</p>
            </div>
            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-900 font-black text-xl mb-6 shadow-md">4</div>
                <h3 class="text-xl font-bold text-white mb-3">Kunci Permanen</h3>
                <p class="text-slate-300 text-sm leading-relaxed">Bukti nota <strong class="text-white">dikunci permanen menggunakan teknologi Blockchain</strong>. Tak bisa diubah.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-3 rounded-[2.5rem] border border-slate-200 shadow-sm">
            <div class="bg-emerald-50 border border-emerald-100 rounded-[2rem] p-8 md:p-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-emerald-200/50 rounded-full flex items-center justify-center text-emerald-600"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <h4 class="text-xl font-bold text-emerald-900">Kelebihan: Anti-Korupsi</h4>
                </div>
                <p class="text-emerald-800 leading-relaxed font-medium">Setiap pengeluaran dicatat di "Buku Besar Digital" yang tak bisa diedit. Bukti nota bisa diaudit oleh siapa saja.</p>
            </div>
            <div class="bg-amber-50 border border-amber-100 rounded-[2rem] p-8 md:p-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-amber-200/50 rounded-full flex items-center justify-center text-amber-600"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <h4 class="text-xl font-bold text-amber-900">Kekurangan: Validasi Lama</h4>
                </div>
                <p class="text-amber-800 leading-relaxed font-medium">Karena sistem keamanan ketat, relawan harus melalui proses validasi bukti nota dari sistem kami sebelum dana cair.</p>
            </div>
        </div>
    </section>

    <!-- PROGRAM KEMANUSIAAN -->
    <section id="initiatives" class="py-24 px-6 max-w-[90rem] mx-auto relative z-10">
        <div class="mb-16 text-center md:text-left" x-data="{ shown: false }" x-intersect.once="shown = true">
            <h2 class="text-4xl md:text-5xl font-black tracking-tighter text-slate-900 mb-4 transition-all duration-1000 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">Program Kemanusiaan</h2>
            <p class="text-slate-500 text-lg font-medium transition-all duration-1000 delay-100 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">Salurkan empati Anda ke wilayah yang membutuhkan hari ini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($campaigns ?? [] as $campaign)
                @php
                    $percent = $campaign->target_amount > 0 ? min(100, round(($campaign->collected_amount / $campaign->target_amount) * 100)) : 0;
                    $fallbackImage = asset('images/bg1.avif');
                    $imageUrl = $campaign->image ? asset('storage/' . $campaign->image) : $fallbackImage;
                @endphp
                <div class="group bg-white border border-slate-200 rounded-[2rem] overflow-hidden hover:border-slate-300 hover:shadow-xl hover:-translate-y-1 transition-all duration-500 p-3 flex flex-col">
                    <div class="h-56 w-full overflow-hidden rounded-[1.5rem] relative mb-4">
                        <img src="{{ $imageUrl }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="px-3 pb-3 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold tracking-tight text-slate-900 mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2 font-medium">{{ \Illuminate\Support\Str::limit($campaign->description, 80) }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between text-xs font-bold mb-2">
                                <span class="text-slate-900">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                <span class="text-emerald-600">{{ $percent }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 mb-6 overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <button @click="openDonation('{{ addslashes($campaign->title) }}', {{ $campaign->id }})" class="w-full bg-slate-900 text-white py-3.5 rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors shadow-md hover:shadow-lg">
                                Bantu Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-500 font-bold bg-white border border-slate-200 rounded-[2rem]">
                    Belum ada kampanye kemanusiaan yang aktif saat ini.
                </div>
            @endforelse
        </div>
    </section>

    <!-- TRANSPARANSI PENYALURAN DANA (PUBLIC LEDGER) -->
    <section id="ledger" class="py-32 px-6 max-w-[90rem] mx-auto relative z-10 border-t border-slate-200">
        <div class="mb-12" x-data="{ shown: false }" x-intersect.once="shown = true">
            <h2 class="text-3xl md:text-5xl font-black tracking-tighter text-slate-900 mb-4 transition-all duration-1000 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">Transparansi Penyaluran Dana</h2>
            <p class="text-slate-600 text-lg font-medium max-w-3xl transition-all duration-1000 delay-100 transform" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">Setiap pengeluaran dari donasi yang terkumpul akan ditampilkan di sini beserta nota aslinya. Data dikunci mati oleh sistem (Ledger Publik).</p>
        </div>

        <div class="w-full overflow-x-auto bg-white border border-slate-200 rounded-[2rem] shadow-sm">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500 font-bold tracking-wider uppercase bg-slate-50">
                        <th class="p-6 w-32">Tanggal</th>
                        <th class="p-6">Barang/Jasa Penyaluran</th>
                        <th class="p-6">Kampanye</th>
                        <th class="p-6">Nominal</th>
                        <th class="p-6 text-center">Bukti Nota</th>
                        <th class="p-6 text-right">Status Ledger</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($publicLedgers ?? [] as $tx)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="p-6 text-slate-500 font-medium whitespace-nowrap">{{ $tx->created_at->format('d M Y') }}</td>
                            <td class="p-6 font-bold text-slate-900">{{ $tx->donor_name ?? 'Penyaluran Lapangan' }}</td>
                            <td class="p-6 text-slate-600 font-medium">{{ $tx->campaign->title ?? '-' }}</td>
                            <td class="p-6 text-slate-900 font-mono font-bold whitespace-nowrap">Rp {{ number_format($tx->amount, 0, ',', '.') }}</td>
                            <td class="p-6 text-center">
                                <button @click="openReceipt({ store: 'Relawan Lapangan', date: '{{ $tx->created_at->format('d/m/Y H:i') }}', purpose: '{{ addslashes($tx->donor_name) }}', amount: '{{ number_format($tx->amount, 0, ',', '.') }}', hash: '{{ $tx->tx_hash }}' })" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2.5 rounded-lg border border-blue-200 transition-colors shadow-sm whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg> Lihat Nota
                                </button>
                            </td>
                            <td class="p-6 text-right">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5" fill="solid" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Terkunci Permanen
                                </span>
                                <div class="mt-3 text-[11px] font-mono text-slate-500 bg-slate-100 p-2 rounded-lg border border-slate-200 flex items-center justify-between gap-2 max-w-[200px] ml-auto">
                                    <span class="truncate">{{ substr($tx->tx_hash, 0, 10) }}...{{ substr($tx->tx_hash, -10) }}</span>
                                    <button onclick="navigator.clipboard.writeText('{{ $tx->tx_hash }}'); alert('Tx Hash berhasil disalin!')" class="text-slate-400 hover:text-slate-700 shrink-0"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500 font-bold bg-white">Belum ada penyaluran dana yang dicatat di Ledger Publik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-slate-200 bg-white py-12 px-6 relative z-10">
        <div class="max-w-[90rem] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-lg font-bold tracking-tighter flex items-center gap-2 text-slate-900">
                <div class="w-4 h-4 bg-slate-900 rounded-full"></div>
                JejakDonasi.
            </div>
            <div class="text-sm font-semibold text-slate-500">
                Teknologi Ledger Web2.5 &copy; 2026. Prototipe Juara Vibe Coding.
            </div>
        </div>
    </footer>

    <!-- MODAL DONASI -->
    <div x-show="isDonationOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="isDonationOpen" x-transition.opacity.duration.300ms class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="isDonationOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4 sm:p-0 relative z-10">
            <div x-show="isDonationOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="relative transform overflow-hidden rounded-[2.5rem] bg-white border border-slate-200 text-left shadow-2xl transition-all sm:my-8 w-full max-w-xl p-8 sm:p-10">
                
                <button @click="isDonationOpen = false" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 p-2.5 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <h3 class="text-2xl font-black tracking-tighter text-slate-900 mb-2">Bantu Saudara Kita</h3>
                <p class="text-slate-500 text-sm mb-8 font-medium">Anda menyumbang untuk: <strong class="text-slate-900" x-text="selectedCampaignName"></strong></p>

                <form action="{{ route('donate') }}" method="POST" x-data="{ amount: '' }" class="space-y-6">
                    @csrf
                    <input type="hidden" name="campaign_id" x-bind:value="selectedCampaignId">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3">Pilih Nominal Donasi</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <button type="button" @click="amount = 50000" class="border border-slate-300 bg-white text-slate-700 rounded-xl py-3 text-sm font-bold hover:border-slate-900 focus:bg-slate-900 focus:text-white transition-colors">Rp 50.000</button>
                            <button type="button" @click="amount = 100000" class="border border-slate-300 bg-white text-slate-700 rounded-xl py-3 text-sm font-bold hover:border-slate-900 focus:bg-slate-900 focus:text-white transition-colors">Rp 100.000</button>
                            <button type="button" @click="amount = 250000" class="border border-slate-300 bg-white text-slate-700 rounded-xl py-3 text-sm font-bold hover:border-slate-900 focus:bg-slate-900 focus:text-white transition-colors">Rp 250.000</button>
                            <button type="button" @click="amount = 500000" class="border border-slate-300 bg-white text-slate-700 rounded-xl py-3 text-sm font-bold hover:border-slate-900 focus:bg-slate-900 focus:text-white transition-colors">Rp 500.000</button>
                            <button type="button" @click="amount = 1000000" class="border border-slate-300 bg-white text-slate-700 rounded-xl py-3 text-sm font-bold hover:border-slate-900 focus:bg-slate-900 focus:text-white transition-colors">Rp 1.000.000</button>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 font-bold text-sm">Rp</span>
                                <input type="number" name="amount" x-model="amount" required placeholder="Lainnya" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl py-3 pl-9 pr-3 text-sm font-bold focus:outline-none focus:border-slate-900 transition-colors">
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Anda</label>
                            <input type="text" name="donor_name" placeholder="Masukkan nama (Boleh kosong)" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors">
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="is_anonymous" value="1" class="w-5 h-5 rounded border-slate-300 bg-white checked:bg-slate-900 focus:ring-0 text-slate-900 cursor-pointer">
                            <span class="text-sm text-slate-500 font-medium group-hover:text-slate-900 transition-colors">Sembunyikan nama (Anonim)</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 transition-colors cursor-pointer">
                            <option value="QRIS">QRIS (Semua e-Wallet & M-Banking)</option>
                            <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                            <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                            <option value="Transfer Bank BNI">Transfer Bank BNI</option>
                        </select>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl text-base font-bold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/20">Lanjutkan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL LAPOR KEJANGGALAN -->
    <div x-show="isReportOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="isReportOpen" x-transition.opacity.duration.300ms class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="isReportOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4 sm:p-0 relative z-10">
            <div x-show="isReportOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="relative transform overflow-hidden rounded-[2.5rem] bg-white border border-red-200 text-left shadow-2xl transition-all sm:my-8 w-full max-w-xl p-8 sm:p-10">
                
                <button @click="isReportOpen = false" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 p-2.5 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h3 class="text-2xl font-black tracking-tighter text-slate-900">Lapor Kejanggalan</h3>
                </div>
                <p class="text-slate-500 text-sm mb-8 font-medium">Bantu kami menjaga transparansi. Laporkan jika Anda menemukan ketidaksesuaian antara nota belanja dan barang di lapangan.</p>

                <form action="{{ route('reports.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pelapor</label>
                            <input type="text" name="name" required placeholder="Nama Anda" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 font-medium">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" required placeholder="Email untuk dihubungi" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 font-medium">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kampanye yang Dicurigai</label>
                        <select name="campaign_name" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 cursor-pointer font-medium">
                            <option value="">-- Pilih Kampanye --</option>
                            @foreach($campaigns ?? [] as $camp)
                                <option value="{{ $camp->title }}">{{ $camp->title }}</option>
                            @endforeach
                            <option value="Umum / Lainnya">Umum / Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Bukti / Alasan</label>
                        <textarea name="description" required rows="4" placeholder="Jelaskan secara detail kejanggalan pada nota yang Anda temukan..." class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 resize-none font-medium"></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-xl text-sm font-bold hover:bg-red-700 shadow-lg shadow-red-600/20">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL NOTA DIGITAL -->
    <div x-show="isReceiptOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="isReceiptOpen" x-transition.opacity.duration.300ms class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="isReceiptOpen = false"></div>
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
                            <h3 class="font-bold text-xl uppercase tracking-widest mb-1" x-text="selectedLedger.store"></h3>
                            <p class="text-xs text-slate-500 font-medium">Sistem Validasi JejakDonasi</p>
                            <p class="text-xs text-slate-500 font-medium">NPWP: 01.234.567.8-901.000</p>
                        </div>
                        
                        <div class="flex justify-between items-center mb-1 text-xs font-bold">
                            <span>No. Ref:</span>
                            <span>WEB25-SYS</span>
                        </div>
                        <div class="flex justify-between items-center mb-5 text-xs text-slate-500 font-medium">
                            <span>Waktu Validasi:</span>
                            <span x-text="selectedLedger.date"></span>
                        </div>
                        
                        <div class="border-b-2 border-dashed border-slate-300 pb-5 mb-5 space-y-3">
                            <div class="flex justify-between font-bold text-xs uppercase tracking-wider mb-2">
                                <span>Item Lapangan</span>
                                <span>Nominal</span>
                            </div>
                            <div class="flex justify-between items-start text-xs font-bold">
                                <span class="pr-4 leading-relaxed uppercase" x-text="selectedLedger.purpose"></span>
                                <span class="whitespace-nowrap" x-text="selectedLedger.amount"></span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between font-black text-lg pb-5 mb-5 border-b-2 border-slate-800">
                            <span>TOTAL</span>
                            <span x-text="selectedLedger.amount"></span>
                        </div>
                        
                        <div class="text-center space-y-2">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500">Tx Hash Web2.5 Permanen</p>
                            <p class="text-[9px] bg-slate-100 p-2.5 rounded font-bold break-all text-slate-700 border border-slate-200" x-text="selectedLedger.hash"></p>
                            <p class="text-[10px] mt-4 font-bold text-slate-900">TERIMA KASIH ORANG BAIK</p>
                        </div>

                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 -rotate-12 pointer-events-none opacity-[0.15]">
                            <div class="border-4 border-emerald-600 text-emerald-600 text-3xl font-black p-3 rounded-xl uppercase tracking-widest leading-none text-center">
                                TERVALIDASI<br>LEDGER
                            </div>
                        </div>
                    </div>
                    <div class="receipt-edge-bottom w-full bg-transparent absolute -bottom-[10px] left-0"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ALPINE LOGIC -->
    <script>
        function appData() {
            return {
                scrolled: false,
                isDonationOpen: false,
                isReportOpen: false,
                isReceiptOpen: false,
                selectedCampaignName: '',
                selectedCampaignId: null,
                selectedLedger: {},
                
                openDonation(campaignName, id) {
                    this.selectedCampaignName = campaignName;
                    this.selectedCampaignId = id;
                    this.isDonationOpen = true;
                },
                
                openReceipt(ledgerObj) {
                    this.selectedLedger = ledgerObj;
                    this.isReceiptOpen = true;
                }
            }
        }
    </script>
</body>
</html>