<header class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-40 transition-all">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center md:hidden">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none p-2 rounded-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            
            <div class="flex-1 flex items-center justify-end">
                <div class="ml-4 flex items-center md:ml-6 space-x-4">
                    
                    <!-- Notifications -->
                    <button class="p-2 text-gray-400 hover:text-gray-500 relative">
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <div>
                            <button @click="open = !open" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Kullanıcı Menüsü</span>
                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold border border-primary-200">
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                            </button>
                        </div>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Profilim</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem" tabindex="-1">Çıkış Yap</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
