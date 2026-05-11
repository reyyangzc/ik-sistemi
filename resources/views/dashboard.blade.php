<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end border-b border-gray-100 pb-6">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-indigo-600 mb-1">RAK Strategic Systems</p>
                <h2 class="font-serif italic text-3xl text-gray-800 leading-tight">{{ __('Yönetim Paneli') }}</h2>
            </div>
            <div class="text-right">
                <span class="text-[10px] text-gray-400 font-mono uppercase tracking-widest block mb-1">{{ now()->translatedFormat('d F Y') }}</span>
                <span class="text-[10px] text-indigo-500 font-mono font-black border border-indigo-100 px-2 py-1 rounded-sm bg-indigo-50/30">{{ now()->format('H:i') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfcfc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white p-8 border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:border-gray-300 transition-all duration-500">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 group-hover:scale-110 transition-all duration-500">
                        <svg class="w-16 h-16 text-black" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1V16a5 5 0 015-5z"></path></svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-2 font-black">Toplam Kadro</p>
                    <p class="text-5xl font-serif text-gray-900 leading-none">{{ $stats['employee_count'] ?? 4 }}</p>
                </div>

                <div class="bg-white p-8 border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:border-indigo-100 transition-all duration-500">
                    <p class="text-[10px] uppercase tracking-[0.3em] text-indigo-600 mb-2 font-black">Bekleyen Talepler</p>
                    <div class="flex items-end space-x-2">
                        <p class="text-5xl font-serif text-indigo-600 leading-none">{{ $stats['pending_leaves'] ?? 0 }}</p>
                        <span class="text-xs text-gray-400 mb-1 italic font-light">onay bekliyor</span>
                    </div>
                </div>

                <div class="bg-white p-8 border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:border-emerald-100 transition-all duration-500">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.06] group-hover:scale-110 transition-all duration-700">
                        <svg class="w-32 h-32 text-black" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-2.597 9.181-6.5 11.5a11.954 11.954 0 01-6.5-11.5c0-.68.056-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-3 font-black">Güvenlik Durumu</p>
                    <div class="flex items-center space-x-3">
                        <p class="text-2xl font-serif text-gray-900 italic tracking-tight">RAK Secure</p>
                        <div class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-[9px] text-emerald-600 font-mono uppercase font-black tracking-widest">Sistem Aktif</p>
                        <p class="text-[9px] text-gray-300 font-mono uppercase tracking-tighter mt-1">AES-256 Encryption Active</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white border border-gray-100 p-8 shadow-sm rounded-sm">
                    <div class="flex justify-between items-center mb-8 border-b border-gray-50 pb-4">
                        <h3 class="text-[11px] font-black uppercase tracking-[0.4em] text-gray-800">Kurumsal Duyurular</h3>
                        <button class="text-[9px] text-indigo-600 font-bold uppercase tracking-widest hover:text-indigo-800 transition-colors">Yönet</button>
                    </div>
                    <div class="space-y-8">
                        @forelse($announcements ?? [] as $announcement)
                            <div class="group cursor-pointer">
                                <h4 class="text-lg font-serif italic group-hover:text-indigo-600 transition-all duration-300">{{ $announcement->title }}</h4>
                                <p class="text-xs text-gray-400 mt-2 line-clamp-2 leading-relaxed font-light">{{ $announcement->content }}</p>
                            </div>
                        @empty
                            <div class="py-12 text-center border-2 border-dashed border-gray-50 rounded-lg">
                                <p class="text-[10px] font-mono text-gray-300 uppercase tracking-[0.3em]">Henüz yayınlanmış bir duyuru bulunmuyor</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white border border-gray-100 p-8 shadow-sm rounded-sm">
                    <div class="flex justify-between items-center mb-8 border-b border-gray-50 pb-4">
                        <h3 class="text-[11px] font-black uppercase tracking-[0.4em] text-gray-800">Sistem Logları</h3>
                        <div class="flex space-x-1">
                            <span class="w-1 h-1 bg-emerald-500 rounded-full"></span>
                            <span class="w-1 h-1 bg-emerald-500 rounded-full opacity-50"></span>
                            <span class="w-1 h-1 bg-emerald-500 rounded-full opacity-25"></span>
                        </div>
                    </div>
                    <div class="space-y-6">
                        @php $logs = \App\Models\Log::with('user')->latest()->take(5)->get(); @endphp
                        @forelse($logs as $lokg)
                            <div class="flex justify-between items-start group">
                                <div class="flex items-start space-x-4">
                                    <div class="w-1 h-10 bg-gray-50 group-hover:bg-indigo-500 transition-all duration-500"></div>
                                    <div>
                                        <span class="text-[10px] font-black block text-gray-900 uppercase tracking-tight mb-1 group-hover:text-indigo-600 transition-colors">{{ $log->action }}</span>
                                        <span class="text-[11px] text-gray-400 font-light italic leading-none">{{ $log->description }}</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-mono text-gray-300 bg-gray-50 px-2 py-1 rounded-full">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="py-12 text-center border-2 border-dashed border-gray-50 rounded-lg">
                                <p class="text-[10px] font-mono text-gray-300 uppercase tracking-[0.3em]">Aktivite kaydı bulunamadı</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>