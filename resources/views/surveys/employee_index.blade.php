<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Anketler ve Geri Bildirimler
        </h2>
    </x-slot>

    <div class="mb-6">
        <p class="text-gray-500">Şirketimizin gelişimi için fikirleriniz bizim için çok değerli. Lütfen aktif anketlere katılım sağlayın.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($surveys as $survey)
            @php
                $isCompleted = in_array($survey->id, $completedSurveys);
            @endphp
            <div class="border {{ $isCompleted ? 'border-gray-200 bg-gray-50' : 'border-indigo-100 bg-white shadow-sm hover:shadow-md' }} rounded-2xl p-6 transition-all relative overflow-hidden">
                
                @if($isCompleted)
                    <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                        <div class="bg-gray-400 text-white text-[10px] font-bold py-1 px-8 transform rotate-45 translate-x-3 translate-y-2 shadow-sm text-center">TAMAMLANDI</div>
                    </div>
                @else
                    <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                        <div class="bg-indigo-500 text-white text-[10px] font-bold py-1 px-8 transform rotate-45 translate-x-3 translate-y-2 shadow-sm text-center">YENİ</div>
                    </div>
                @endif

                <div class="flex items-start space-x-4 mb-4">
                    <div class="w-12 h-12 rounded-xl {{ $isCompleted ? 'bg-gray-200 text-gray-500' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg {{ $isCompleted ? 'text-gray-600' : 'text-gray-900' }}">{{ $survey->title }}</h3>
                        @if($survey->expires_at)
                            <p class="text-xs {{ $isCompleted ? 'text-gray-400' : 'text-orange-500 font-medium' }} mt-1">Son Katılım: {{ $survey->expires_at->format('d.m.Y H:i') }}</p>
                        @endif
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-6 line-clamp-3 min-h-[60px]">
                    {{ $survey->description ?: 'Bu anket için detaylı açıklama girilmemiştir.' }}
                </p>

                @if($isCompleted)
                    <button disabled class="w-full py-2 bg-gray-200 text-gray-500 rounded-xl font-semibold cursor-not-allowed text-center text-sm">
                        Katılım Sağlandı
                    </button>
                @else
                    <a href="{{ route('surveys.show', $survey) }}" class="block w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all text-center text-sm">
                        Ankete Katıl
                    </a>
                @endif
            </div>
        @empty
            <div class="col-span-full py-12 text-center border-2 border-dashed border-gray-200 rounded-2xl">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">Aktif Anket Yok</h3>
                <p class="mt-1 text-sm text-gray-500">Şu anda yanıtlamanız gereken aktif bir anket bulunmuyor.</p>
            </div>
        @endforelse
    </div>

</x-app-layout>
