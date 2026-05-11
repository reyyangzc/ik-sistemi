<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group">
                         <span class="font-serif italic text-3xl tracking-tighter text-gray-800 group-hover:text-indigo-600 transition-colors duration-500">RAK</span>
                         <div class="ms-2 w-1 h-1 rounded-full bg-indigo-600 group-hover:bg-black"></div>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[11px] font-black uppercase tracking-widest">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()->role_id == 1)
                        <x-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.*')" class="text-[11px] font-black uppercase tracking-widest text-gray-500">
                            {{ __('Personeller') }}
                        </x-nav-link>

                        <x-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.*')" class="text-[11px] font-black uppercase tracking-widest text-gray-500">
                            {{ __('Departmanlar') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('leaves.index')" :active="request()->routeIs('leaves.*')" class="text-[11px] font-black uppercase tracking-widest text-indigo-600 border-indigo-600">
                        {{ __('İzin Talepleri') }}
                    </x-nav-link>

                    <x-nav-link :href="route('salaries.index')" :active="request()->routeIs('salaries.*')" class="text-[11px] font-black uppercase tracking-widest">
                        {{ __('Maaş Bordroları') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-100 text-[10px] font-black uppercase tracking-[0.2em] rounded-sm text-gray-500 bg-gray-50/50 hover:bg-white transition-all duration-300">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ms-2 h-3 w-3 opacity-30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-[10px] uppercase font-bold tracking-widest">
                            {{ __('Profil Ayarları') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-[10px] uppercase font-bold tracking-widest text-red-600">
                                {{ __('Güvenli Çıkış') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>