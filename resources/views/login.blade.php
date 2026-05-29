<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JejakDonasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased h-screen flex items-center justify-center selection:bg-slate-900 selection:text-white relative overflow-hidden">
    
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wNSkiLz48L3N2Zz4=')] pointer-events-none"></div>

    <div class="w-full max-w-md p-8 relative z-10">
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center shadow-md">
                    <div class="w-3 h-3 bg-white rounded-full"></div>
                </div>
                <span class="text-3xl font-black tracking-tighter text-slate-900">JejakDonasi.</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-10 shadow-xl text-center">
            <h2 class="text-2xl font-black text-slate-900 mb-2">Simulasi Akses Role</h2>
            <p class="text-sm text-slate-500 font-medium mb-8">Silakan masuk ke antarmuka yang sesuai.</p>

            <div class="space-y-4">
                <a href="{{ route('dashboard') }}" class="w-full bg-slate-900 text-white py-4 rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/20 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    Masuk sebagai Admin
                </a>

                <a href="{{ route('field.dashboard') }}" class="w-full bg-emerald-50 border border-emerald-200 text-emerald-700 py-4 rounded-xl text-sm font-bold hover:bg-emerald-100 transition-colors shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" /></svg>
                    Masuk sebagai Tim Lapangan
                </a>
            </div>
            
            <a href="{{ route('home') }}" class="mt-8 inline-block text-xs font-bold text-slate-500 hover:text-slate-900 transition-colors">&larr; Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>