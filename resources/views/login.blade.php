<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - JejakDonasi</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased h-screen flex items-center justify-center selection:bg-slate-900 selection:text-white relative overflow-hidden">

    <!-- Latar Belakang Grid Halus -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wNSkiLz48L3N2Zz4=')] pointer-events-none"></div>

    <div class="w-full max-w-md p-8 relative z-10" x-data="{ isLoading: false }">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center shadow-md">
                    <div class="w-3 h-3 bg-white rounded-full"></div>
                </div>
                <span class="text-2xl font-black tracking-tighter text-slate-900">JejakDonasi.</span>
            </div>
        </div>

        <!-- Box Login -->
        <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-xl shadow-slate-200/50">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-900 mb-1">Masuk ke Admin Panel</h2>
                <p class="text-sm text-slate-500 font-medium">Otorisasi akses ke sistem Web2.5</p>
            </div>

            <!-- Form Interaktif Alpine.js menuju /dashboard -->
            <form @submit.prevent="isLoading = true; setTimeout(() => window.location.href = '/dashboard', 800)" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email / ID Staf</label>
                    <input type="text" required value="admin@jejakdonasi.id" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors">
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-bold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">Lupa sandi?</a>
                    </div>
                    <input type="password" required value="password123" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-xl px-4 py-3.5 text-sm font-medium focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-colors tracking-widest">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/20 flex items-center justify-center gap-2">
                        <span x-show="!isLoading">Masuk Dashboard</span>
                        <svg x-show="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-xs font-medium text-slate-500 mt-8">
            &copy; 2026 JejakDonasi. Restricted Access.
        </p>
    </div>

</body>
</html>