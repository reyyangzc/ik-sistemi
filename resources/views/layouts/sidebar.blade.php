<!-- Sidebar -->
<aside class="glass-panel-dark w-64 flex-shrink-0 flex flex-col transition-all duration-300 z-20 hidden md:flex border-r border-gray-800 m-4 rounded-2xl">
    <div class="h-24 flex items-center justify-center border-b border-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-gradient-to-tr from-primary-500 to-primary-300 rounded-xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-all">
                <span class="text-white font-bold text-xl">İK</span>
            </div>
            <span class="text-xl font-bold tracking-wider text-white">SİSTEMİ</span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Menü</p>
        
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-primary-600/20 text-primary-400 border border-primary-500/30' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="font-medium">Dashboard</span>
        </a>

        @if(auth()->check() && auth()->user()->role_id == 1)
            <div x-data="{ open: {{ request()->routeIs('employees.*') || request()->routeIs('departments.*') || request()->routeIs('positions.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 px-4 py-3 rounded-xl transition-all text-gray-300 hover:bg-gray-800/50 hover:text-white">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-medium">Yönetim Paneli</span>
                    </div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="open" x-transition.opacity class="pl-11 pr-4 mt-1 space-y-1">
                    <a href="{{ route('employees.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('employees.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        Personeller
                    </a>
                    <a href="{{ route('departments.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('departments.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        Departmanlar
                    </a>
                    <a href="{{ route('positions.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('positions.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        Pozisyonlar
                    </a>
                    <a href="{{ route('complaints.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('complaints.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        Şikayetler
                    </a>
                    <a href="{{ route('inventories.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('inventories.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        Zimmet Yönetimi
                    </a>
                    <a href="{{ route('expenses.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('expenses.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        Masraf Yönetimi
                    </a>
                    <a href="{{ route('surveys.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('surveys.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        Anket Yönetimi
                    </a>
                    <a href="{{ route('recruitment.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-all {{ request()->routeIs('recruitment.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        İşe Alım ve İlanlar
                    </a>
                </div>
            </div>
        @endif

        <a href="{{ route('leaves.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('leaves.*') ? 'bg-primary-600/20 text-primary-400 border border-primary-500/30' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="font-medium">Talep Havuzu</span>
        </a>

        <!-- SELF SERVICE (Personel/Ortak) -->
        <div class="mb-6">
            <p class="px-6 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Self Servis</p>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Şifre İşlemleri</span>
                </a>
                <a href="{{ route('profile.requests.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('profile.requests.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    <span>{{ auth()->user()->role_id == 1 ? 'Profil Talepleri' : 'Profilimi Güncelle' }}</span>
                </a>
                
                @if(auth()->user()->role_id != 1)
                <a href="{{ route('inventories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('inventories.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Zimmetlerim</span>
                </a>
                <a href="{{ route('expenses.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('expenses.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Masraf / Avans Talepleri</span>
                </a>
                @endif
                <a href="{{ route('salaries.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('salaries.*') ? 'bg-primary-600/20 text-primary-400' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ auth()->user()->role_id == 1 ? 'Maaşlar' : 'Bordrolarım' }}</span>
                </a>
            </div>
        </div>

        <!-- HR Araçları -->
        <div class="px-4 py-2 mt-4 text-xs font-semibold text-gray-500 tracking-wider uppercase">
            İK & Gelişim
        </div>

        <a href="{{ route('performance.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('performance.*') ? 'bg-primary-600/20 text-primary-400 border border-primary-500/30' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            <span class="font-medium">Performans Yönetimi</span>
        </a>

        <a href="{{ route('trainings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('trainings.*') ? 'bg-primary-600/20 text-primary-400 border border-primary-500/30' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477-4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span class="font-medium">Kurumsal Eğitimler</span>
        </a>
        <a href="{{ route('surveys.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('surveys.*') ? 'bg-primary-600/20 text-primary-400 border border-primary-500/30' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            <span class="font-medium">Anketler ve Geri Bildirim</span>
        </a>
        <a href="{{ route('directory.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('directory.*') ? 'bg-primary-600/20 text-primary-400 border border-primary-500/30' : 'text-gray-300 hover:bg-gray-800/50 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span class="font-medium">Şirket Rehberi</span>
        </a>
    </div>

    <!-- User Mini Profile -->
    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-white font-bold">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'Guest' }}</p>
                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>
    </div>
</aside>
