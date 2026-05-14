<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Kurumsal Eğitimler
            </h2>
            @if(auth()->user()->role_id == 1)
                <button onclick="document.getElementById('trainingModal').classList.remove('hidden')" class="btn-primary flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Yeni Eğitim Ekle</span>
                </button>
            @endif
        </div>
    </x-slot>

    @if(auth()->user()->role_id == 1)
        @push('modals')
        <!-- Training Modal for Admin -->
        <div id="trainingModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
            <div class="relative max-w-lg w-full mx-4 bg-white rounded-2xl shadow-2xl p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-xl font-bold text-gray-900">Kurumsal Eğitim Ekle</h3>
                    <button onclick="document.getElementById('trainingModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('trainings.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Eğitim Başlığı</label>
                        <input type="text" name="title" required class="input-field" placeholder="Örn: İleri Düzey İletişim Becerileri">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Eğitim Tarihi</label>
                            <input type="date" name="training_date" required class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Eğitmen / Kurum</label>
                            <input type="text" name="instructor" class="input-field" placeholder="Örn: Dr. Ali Yılmaz">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Eğitim Detayı (Opsiyonel)</label>
                        <textarea name="description" rows="3" class="input-field" placeholder="Eğitim içeriği hakkında bilgi..."></textarea>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-primary w-full justify-center">Eğitimi Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
        @endpush
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-6 overflow-hidden">
        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tarih</th>
                        <th class="px-6 py-4 font-semibold">Eğitim Başlığı</th>
                        <th class="px-6 py-4 font-semibold">Eğitmen</th>
                        <th class="px-6 py-4 font-semibold">Detaylar</th>
                        @if(auth()->user()->role_id == 1)
                            <th class="px-6 py-4 font-semibold text-center">İşlem</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($trainings as $training)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-800 font-medium whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($training->training_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $training->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $training->instructor ?: '-' }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs max-w-sm truncate" title="{{ $training->description }}">
                                {{ $training->description ?: '-' }}
                            </td>
                            @if(auth()->user()->role_id == 1)
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('trainings.destroy', $training) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Bu eğitimi silmek istediğinize emin misiniz?')" title="Sil">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role_id == 1 ? 5 : 4 }}" class="px-6 py-12 text-center text-gray-500">
                                Sistemde tanımlı bir eğitim bulunmuyor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
