<!-- Sidebar -->
<aside class="glass-panel-dark w-64 flex-shrink-0 flex flex-col transition-all duration-300 z-20 hidden md:flex border-r border-gray-800/50 m-4 rounded-3xl bg-gray-900/90 backdrop-blur-xl shadow-2xl">
    <div class="h-24 flex items-center justify-center border-b border-gray-800/50">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-gradient-to-tr from-primary-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(99,102,241,0.5)] transform group-hover:rotate-12 transition-all duration-300">
                <span class="text-white font-bold text-xl">İK</span>
            </div>
            <span class="text-xl font-bold tracking-wider text-white group-hover:text-primary-300 transition-colors">SİSTEMİ</span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-6">
        
        @if(auth()->check() && auth()->user()->role_id == 1)
        <!-- ADMIN (İK VE YÖNETİCİ) PANELİ -->
        <div>
            <p class="px-2 text-[10px] font-black text-primary-400 uppercase tracking-widest mb-3 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Admin Paneli
            </p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-primary-500/20 text-primary-400 shadow-[inset_0_0_10px_rgba(99,102,241,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
                <a href="{{ route('employees.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('employees.*', 'departments.*', 'positions.*') ? 'bg-primary-500/20 text-primary-400 shadow-[inset_0_0_10px_rgba(99,102,241,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-medium text-sm">Personel Yönetimi</span>
                </a>
                <a href="{{ route('leaves.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('leaves.*') ? 'bg-primary-500/20 text-primary-400 shadow-[inset_0_0_10px_rgba(99,102,241,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium text-sm">İzin ve Devamsızlık</span>
                </a>
                <a href="{{ route('salaries.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('salaries.*') ? 'bg-primary-500/20 text-primary-400 shadow-[inset_0_0_10px_rgba(99,102,241,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-sm">Bordro ve Yan Haklar</span>
                </a>
                <a href="{{ route('recruitment.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('recruitment.*') ? 'bg-primary-500/20 text-primary-400 shadow-[inset_0_0_10px_rgba(99,102,241,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="font-medium text-sm">İşe Alım Süreçleri</span>
                </a>
                <a href="{{ route('performance.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('performance.*') ? 'bg-primary-500/20 text-primary-400 shadow-[inset_0_0_10px_rgba(99,102,241,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span class="font-medium text-sm">Performans ve KPI</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="font-medium text-sm">Raporlama ve Analitik</span>
                </a>
                <a href="{{ route('inventories.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('inventories.*') ? 'bg-primary-500/20 text-primary-400 shadow-[inset_0_0_10px_rgba(99,102,241,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="font-medium text-sm">Zimmet Takibi</span>
                </a>
            </div>
        </div>
        <div class="h-px bg-gray-800/50 w-full"></div>
        @endif

        <!-- PERSONEL (SELF-SERVIS) PANELİ -->
        <div>
            <p class="px-2 text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-3 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Personel Paneli
            </p>
            <div class="space-y-1">
                @if(auth()->check() && auth()->user()->role_id != 1)
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('profile.edit', 'profile.requests.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    <span class="font-medium text-sm">Profilim</span>
                </a>
                @if(auth()->check() && auth()->user()->role_id != 1)
                <a href="{{ route('leaves.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('leaves.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium text-sm">İzin Talebim</span>
                </a>
                @endif
                <a href="{{ route('salaries.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('salaries.*') && auth()->user()->role_id != 1 ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-sm">Bordro Görüntüleme</span>
                </a>
                <a href="{{ route('expenses.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('expenses.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-sm">Harcama ve Avans</span>
                </a>
                @if(auth()->check() && auth()->user()->role_id != 1)
                <a href="{{ route('inventories.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('inventories.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="font-medium text-sm">Zimmetlerim</span>
                </a>
                @endif
                <a href="{{ route('trainings.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('trainings.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477-4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span class="font-medium text-sm">Eğitim ve Gelişim</span>
                </a>
                <a href="{{ route('directory.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('directory.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-medium text-sm">Şirket Rehberi</span>
                </a>
                <a href="{{ route('announcements.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('announcements.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    <span class="font-medium text-sm">Duyurular</span>
                </a>
                <a href="{{ route('surveys.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('surveys.*') ? 'bg-emerald-500/20 text-emerald-400 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span class="font-medium text-sm">Anketler</span>
                </a>
            </div>
        </div>
    </div>

    <!-- User Mini Profile -->
    <div class="p-4 border-t border-gray-800/50 bg-gray-900/50 rounded-b-3xl">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center text-white font-bold border border-gray-600 shadow-inner">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest truncate">{{ auth()->check() && auth()->user()->role_id == 1 ? 'Yönetici' : 'Personel' }}</p>
            </div>
        </div>
    </div>
</aside>

