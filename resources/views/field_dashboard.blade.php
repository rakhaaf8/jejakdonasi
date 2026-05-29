<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim Lapangan - JejakDonasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased h-screen flex overflow-hidden selection:bg-slate-900 selection:text-white">

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-slate-900 text-white px-6 py-3 rounded-full font-bold text-sm shadow-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <aside class="w-72 border-r border-slate-200 bg-white flex flex-col shrink-0 z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-200">
            <div class="text-xl font-bold tracking-tighter flex items-center gap-3 text-emerald-700">
                <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center"><div class="w-2 h-2 bg-white rounded-full"></div></div>
                Tim Lapangan
            </div>
        </div>
        <nav class="flex-1 py-8 px-4 flex flex-col gap-2">
            <button class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm transition-all border text-left bg-slate-100 text-slate-900 font-bold border-slate-200">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Ajukan Pencairan Dana
            </button>
            <div class="mt-auto pt-8 border-t border-slate-200">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-500 hover:text-red-600 font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg> Keluar (Log Out)
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative bg-slate-50">
        <header class="h-20 px-8 flex justify-between items-center border-b border-slate-200 bg-white sticky top-0 z-10">
            <h1 class="text-xl font-bold text-slate-900">Form Pengajuan Nota Lapangan</h1>
            <div class="h-10 px-4 rounded-full bg-emerald-50 text-emerald-700 font-bold text-sm flex items-center border border-emerald-200">Relawan Aktif</div>
        </header>

        <div class="p-8 max-w-3xl mx-auto w-full z-10 flex flex-col gap-8 pb-20">
            <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 md:p-12 shadow-sm">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-slate-900 mb-2">Ajukan Pencairan Baru</h3>
                    <p class="text-sm text-slate-500 font-medium">Unggah bukti nota/struk belanja dari lapangan agar admin dapat mencatatnya di Ledger Publik.</p>
                </div>

                <form action="{{ route('expenditures.request') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Kampanye</label>
                        <select name="campaign_id" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:border-emerald-600 focus:outline-none cursor-pointer">
                            <option value="">-- Pilih Kampanye Aktif --</option>
                            @foreach($campaigns ?? [] as $camp)
                                <option value="{{ $camp->id }}">{{ $camp->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nominal Pencairan (Rp)</label>
                        <input type="number" name="amount" required placeholder="Misal: 15000000" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:border-emerald-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tujuan / Nama Barang</label>
                        <input type="text" name="purpose" required placeholder="Misal: Beli 100 Karung Beras" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:border-emerald-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Upload Bukti Fisik / Nota Asli</label>
                        <input type="file" name="receipt_file" required accept="image/*,application/pdf" class="w-full bg-slate-50 border border-slate-300 text-slate-500 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 cursor-pointer">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-xl text-base font-bold hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-600/20">
                            Kirim Pengajuan (Menunggu Validasi Admin)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>