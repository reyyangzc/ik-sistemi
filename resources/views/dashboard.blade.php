<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-xl text-gray-800 leading-tight">
            — {{ __('Genel Bakış') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(auth()->user()->role_id == 1)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-6 border border-gray-200 shadow-sm flex justify-between items-center">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Toplam Personel</span>
                    <span class="text-2xl font-serif">{{ $stats['employee_count'] }}</span>
                </div>
                <div class="bg-white p-6 border border-gray-200 shadow-sm flex justify-between items-center">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Bekleyen İzinler</span>
                    <span class="text-2xl font-serif text-amber-600">{{ $stats['pending_leaves'] }}</span>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm border border-gray-200 p-8">
                <h3 class="text-xs font-black uppercase tracking-[0.3em] mb-8 border-b pb-4">Kurumsal Duyurular</h3>
                
                <div class="space-y-8">
                    @forelse($announcements as $announcement)
                        <div class="group">
                            <div class="flex justify-between items-baseline">
                                <h4 class="text-lg font-serif italic text-gray-900 group-hover:text-indigo-600 transition">
                                    {{ $announcement->title }}
                                </h4>
                                <span class="text-[10px] font-mono text-gray-400">{{ $announcement->created_at->format('d.m.Y') }}</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed text-justify">
                                {{ $announcement->content }}
                            </p>
                            <div class="mt-4 flex items-center pt-4 border-t border-gray-50">
                                <span class="text-[9px] uppercase tracking-widest text-gray-400 font-bold">Yayınlayan: {{ $announcement->user->name }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm italic text-gray-500">Henüz yayınlanmış bir duyuru bulunmuyor.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-medium">
                    Oturum Açan: <span class="text-gray-900">{{ auth()->user()->name }}</span> | 
                    Yetki: <span class="text-gray-900">{{ auth()->user()->role_id == 1 ? 'Yönetici' : 'Personel' }}</span>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>