<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Anket Yönetimi
            </h2>
            <button onclick="document.getElementById('addSurveyModal').classList.remove('hidden')" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Yeni Anket Oluştur</span>
            </button>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-6">
        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Anket Başlığı</th>
                        <th class="px-6 py-4 font-semibold">Durum</th>
                        <th class="px-6 py-4 font-semibold">Bitiş Tarihi</th>
                        <th class="px-6 py-4 font-semibold text-center">Katılım Sayısı</th>
                        <th class="px-6 py-4 font-semibold text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($surveys as $survey)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $survey->title }}</div>
                                <div class="text-xs text-gray-500 mt-1 line-clamp-1" title="{{ $survey->description }}">{{ $survey->description }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($survey->status == 'active' && (!$survey->expires_at || $survey->expires_at > now()))
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Süresi Doldu / Kapalı</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $survey->expires_at ? $survey->expires_at->format('d.m.Y H:i') : 'Süresiz' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900">
                                {{ $survey->responses_count }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('surveys.show', $survey) }}" class="px-3 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold transition-colors">
                                    Sonuçları Gör
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Oluşturulmuş anket bulunmuyor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
    <div id="addSurveyModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
        <div class="relative max-w-2xl w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
            <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-gray-900">Yeni Anket Oluştur</h3>
                <button onclick="document.getElementById('addSurveyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('surveys.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Anket Başlığı</label>
                        <input type="text" name="title" class="input-field" placeholder="Örn: 2026 Q2 Çalışan Memnuniyet Anketi" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                        <textarea name="description" rows="2" class="input-field" placeholder="Anketin amacı..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bitiş Tarihi (Opsiyonel)</label>
                        <input type="datetime-local" name="expires_at" class="input-field">
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h4 class="font-bold text-lg text-gray-900 mb-4 flex justify-between items-center">
                        Sorular
                        <button type="button" onclick="addQuestion()" class="text-sm px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">+ Soru Ekle</button>
                    </h4>
                    
                    <div id="questions-container" class="space-y-4">
                        <div class="question-item bg-gray-50 p-4 rounded-xl border border-gray-200 relative">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Soru Metni</label>
                                    <input type="text" name="questions[0][text]" class="input-field py-1.5 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Soru Tipi</label>
                                    <select name="questions[0][type]" onchange="toggleOptions(this, 0)" class="input-field py-1.5 text-sm" required>
                                        <option value="text">Açık Uçlu (Metin)</option>
                                        <option value="choice">Çoktan Seçmeli</option>
                                    </select>
                                </div>
                            </div>
                            <div id="options-div-0" class="mt-3 hidden">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Seçenekler (Virgülle Ayırın)</label>
                                <input type="text" name="questions[0][options]" class="input-field py-1 text-sm" placeholder="Evet, Hayır, Belki">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end border-t border-gray-100">
                    <button type="submit" class="btn-primary">Anketi Yayınla</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let qCount = 1;
        function addQuestion() {
            const container = document.getElementById('questions-container');
            const html = `
                <div class="question-item bg-gray-50 p-4 rounded-xl border border-gray-200 relative mt-4">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Soru Metni</label>
                            <input type="text" name="questions[${qCount}][text]" class="input-field py-1.5 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Soru Tipi</label>
                            <select name="questions[${qCount}][type]" onchange="toggleOptions(this, ${qCount})" class="input-field py-1.5 text-sm" required>
                                <option value="text">Açık Uçlu (Metin)</option>
                                <option value="choice">Çoktan Seçmeli</option>
                            </select>
                        </div>
                    </div>
                    <div id="options-div-${qCount}" class="mt-3 hidden">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Seçenekler (Virgülle Ayırın)</label>
                        <input type="text" name="questions[${qCount}][options]" class="input-field py-1 text-sm" placeholder="Örn: 1, 2, 3, 4, 5">
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            qCount++;
        }

        function toggleOptions(select, index) {
            const div = document.getElementById(`options-div-${index}`);
            if (select.value === 'choice') {
                div.classList.remove('hidden');
            } else {
                div.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-app-layout>
