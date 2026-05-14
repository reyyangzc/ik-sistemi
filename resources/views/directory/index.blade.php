<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Şirket Rehberi
        </h2>
    </x-slot>

    <div class="mb-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('directory.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-shadow bg-gray-50 hover:bg-white focus:bg-white text-sm" placeholder="İsim, e-posta, departman veya unvan ile arayın...">
            </div>
            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all">
                Ara
            </button>
            @if(request('search'))
                <a href="{{ route('directory.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all flex items-center justify-center">
                    Temizle
                </a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($employees as $employee)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow relative group">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white text-2xl font-bold mb-4 shadow-lg shadow-indigo-200 group-hover:scale-105 transition-transform">
                    {{ mb_substr($employee->first_name, 0, 1) }}{{ mb_substr($employee->last_name, 0, 1) }}
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                <p class="text-indigo-600 font-medium text-sm mt-1">{{ $employee->position->name ?? 'Unvan Belirtilmedi' }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ $employee->department->name ?? 'Departman Belirtilmedi' }}</p>
                
                <div class="mt-6 w-full space-y-3">
                    <a href="mailto:{{ $employee->email }}" class="flex items-center space-x-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors text-sm text-gray-700 w-full text-left">
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-400 shadow-sm flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="truncate">{{ $employee->email }}</span>
                    </a>
                    
                    <a href="tel:{{ $employee->phone }}" class="flex items-center space-x-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors text-sm text-gray-700 w-full text-left">
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-400 shadow-sm flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <span>{{ $employee->phone ?? 'Belirtilmedi' }}</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">Sonuç Bulunamadı</h3>
                <p class="mt-1 text-sm text-gray-500">Arama kriterlerinize uygun personel bulunamadı.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
