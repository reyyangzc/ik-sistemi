<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                İşe Alım ve İlan Yönetimi
            </h2>
            <button onclick="document.getElementById('addPostingModal').classList.remove('hidden')" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Yeni İlan Oluştur</span>
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
                        <th class="px-6 py-4 font-semibold">İlan Başlığı / Departman</th>
                        <th class="px-6 py-4 font-semibold text-center">Durum</th>
                        <th class="px-6 py-4 font-semibold text-center">Aday Sayısı</th>
                        <th class="px-6 py-4 font-semibold text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($postings as $posting)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $posting->title }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $posting->department->name ?? 'Departman Belirtilmedi' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($posting->status == 'active')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif İlan</span>
                                @elseif($posting->status == 'closed')
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Kapalı</span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Taslak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900">
                                {{ $posting->candidates_count }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('recruitment.candidates', $posting) }}" class="inline-flex items-center space-x-2 px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span>Aday Havuzu</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">Açık pozisyon ilanı bulunmamaktadır.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
    <div id="addPostingModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
        <div class="relative max-w-lg w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
            <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-gray-900">Yeni İş İlanı</h3>
                <button onclick="document.getElementById('addPostingModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('recruitment.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">İlan Başlığı</label>
                    <input type="text" name="title" class="input-field" placeholder="Örn: Senior PHP Developer" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Departman</label>
                    <select name="department_id" class="input-field" required>
                        <option value="">Departman Seçin...</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama / Nitelikler</label>
                    <textarea name="description" rows="4" class="input-field" placeholder="Aranan nitelikler, iş tanımı vb." required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                    <select name="status" class="input-field" required>
                        <option value="active">Aktif (Yayınla)</option>
                        <option value="draft">Taslak</option>
                        <option value="closed">Kapalı</option>
                    </select>
                </div>

                <div class="pt-4 flex justify-end border-t border-gray-100">
                    <button type="submit" class="btn-primary">İlanı Kaydet</button>
                </div>
            </form>
        </div>
    </div>
    @endpush
</x-app-layout>
