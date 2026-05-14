<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Zimmetlerim
        </h2>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900">Bana Atanan Demirbaşlar</h3>
            <p class="text-gray-500 text-sm mt-1">Şirket tarafından kullanımınıza sunulan demirbaşların listesi aşağıdadır. Lütfen zimmetlerinizi özenle kullanınız.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($assignments as $assignment)
                <div class="border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow bg-gray-50/30 relative overflow-hidden">
                    @if(is_null($assignment->returned_at))
                        <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                            <div class="bg-green-500 text-white text-[10px] font-bold py-1 px-8 transform rotate-45 translate-x-3 translate-y-2 shadow-sm text-center">AKTİF</div>
                        </div>
                    @else
                        <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                            <div class="bg-gray-400 text-white text-[10px] font-bold py-1 px-8 transform rotate-45 translate-x-3 translate-y-2 shadow-sm text-center">İADE</div>
                        </div>
                    @endif

                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                            @if(strtolower($assignment->inventory->type) == 'laptop' || strtolower($assignment->inventory->type) == 'bilgisayar')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            @elseif(strtolower($assignment->inventory->type) == 'telefon' || strtolower($assignment->inventory->type) == 'cep telefonu')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $assignment->inventory->name }}</h4>
                            <p class="text-xs text-gray-500 font-medium">{{ $assignment->inventory->type }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="font-medium text-gray-500">Seri Numarası:</span>
                            <span class="font-mono text-xs">{{ $assignment->inventory->serial_number ?: 'Belirtilmemiş' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="font-medium text-gray-500">Veriliş Tarihi:</span>
                            <span>{{ \Carbon\Carbon::parse($assignment->assigned_at)->format('d.m.Y') }}</span>
                        </div>
                        
                        @if($assignment->returned_at)
                            <div class="flex justify-between border-b border-gray-100 pb-1">
                                <span class="font-medium text-gray-500">İade Tarihi:</span>
                                <span class="text-gray-900">{{ \Carbon\Carbon::parse($assignment->returned_at)->format('d.m.Y') }}</span>
                            </div>
                        @endif

                        @if($assignment->notes)
                            <div class="pt-2">
                                <span class="font-medium text-gray-500 block text-xs mb-1">Teslim Notu:</span>
                                <p class="text-xs bg-white p-2 rounded border border-gray-100">{{ $assignment->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center border-2 border-dashed border-gray-200 rounded-xl">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900">Zimmet Bulunmuyor</h3>
                    <p class="mt-1 text-sm text-gray-500">Üzerinize kayıtlı herhangi bir şirket demirbaşı bulunmamaktadır.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
