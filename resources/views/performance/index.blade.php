<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                {{ auth()->user()->role_id == 1 ? 'Performans Değerlendirme' : 'Kariyer & Performans' }}
            </h2>
            @if(auth()->user()->role_id == 1)
                <button onclick="document.getElementById('performanceModal').classList.remove('hidden')" class="btn-primary flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Yeni Değerlendirme Ekle</span>
                </button>
            @endif
        </div>
    </x-slot>

    @if(auth()->user()->role_id == 1)
        @push('modals')
        <!-- Performance Modal for Admin -->
        <div id="performanceModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
            <div class="relative max-w-lg w-full mx-4 bg-white rounded-2xl shadow-2xl p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-xl font-bold text-gray-900">Personel Performans Değerlendirmesi</h3>
                    <button onclick="document.getElementById('performanceModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('performance.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Personel</label>
                        <select name="employee_id" required class="input-field">
                            <option value="">Personel Seçin...</option>
                            @if(isset($employees) && count($employees) > 0)
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                                @endforeach
                            @else
                                <option disabled>Kayıtlı personel bulunamadı</option>
                            @endif
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Puan (1-5)</label>
                            <input type="number" name="score" min="1" max="5" required class="input-field" placeholder="Örn: 4">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dönem</label>
                            <input type="text" name="period" required class="input-field" placeholder="Örn: 2026-Q1 veya Mayıs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Değerlendirme Notları / Tavsiyeler</label>
                        <textarea name="comments" rows="3" class="input-field" placeholder="Personelin güçlü yönleri, gelişmesi gereken yönleri..."></textarea>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-primary w-full justify-center">Değerlendirmeyi Kaydet</button>
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
                        <th class="px-6 py-4 font-semibold">Dönem</th>
                        @if(auth()->user()->role_id == 1)
                            <th class="px-6 py-4 font-semibold">Personel</th>
                        @endif
                        <th class="px-6 py-4 font-semibold">Puan</th>
                        <th class="px-6 py-4 font-semibold">Değerlendirme / Yorum</th>
                        <th class="px-6 py-4 font-semibold">Değerlendiren</th>
                        @if(auth()->user()->role_id == 1)
                            <th class="px-6 py-4 font-semibold text-center">İşlem</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $review->period }}</td>
                            @if(auth()->user()->role_id == 1)
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $review->employee->first_name ?? '' }} {{ $review->employee->last_name ?? '' }}
                                </td>
                            @endif
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-1">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $review->score ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 max-w-md truncate" title="{{ $review->comments }}">
                                {{ $review->comments ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ $review->reviewer->name ?? 'HR' }}
                            </td>
                            @if(auth()->user()->role_id == 1)
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('performance.destroy', $review) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Bu değerlendirmeyi silmek istediğinize emin misiniz?')" title="Sil">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role_id == 1 ? 6 : 4 }}" class="px-6 py-12 text-center text-gray-500">
                                Kayıtlı performans değerlendirmesi bulunmuyor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
