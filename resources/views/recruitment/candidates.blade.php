<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('recruitment.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                    Aday Havuzu
                </h2>
                <p class="text-sm text-gray-500 mt-1">İlan: <span class="font-semibold text-indigo-600">{{ $posting->title }}</span></p>
            </div>
            
            <div class="ml-auto">
                <button onclick="document.getElementById('addCandidateModal').classList.remove('hidden')" class="btn-primary flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    <span>Yeni Aday Ekle</span>
                </button>
            </div>
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
                        <th class="px-6 py-4 font-semibold">Ad Soyad</th>
                        <th class="px-6 py-4 font-semibold">İletişim</th>
                        <th class="px-6 py-4 font-semibold text-center">Durum</th>
                        <th class="px-6 py-4 font-semibold text-center">Başvuru Tarihi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($posting->candidates as $candidate)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-900">{{ $candidate->email }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $candidate->phone }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('recruitment.candidates.status', $candidate) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-semibold
                                        @if($candidate->status == 'applied') bg-gray-50 text-gray-700
                                        @elseif($candidate->status == 'reviewing') bg-blue-50 text-blue-700
                                        @elseif($candidate->status == 'interviewed') bg-purple-50 text-purple-700
                                        @elseif($candidate->status == 'hired') bg-green-50 text-green-700
                                        @elseif($candidate->status == 'rejected') bg-red-50 text-red-700
                                        @endif
                                    ">
                                        <option value="applied" {{ $candidate->status == 'applied' ? 'selected' : '' }}>Yeni Başvuru</option>
                                        <option value="reviewing" {{ $candidate->status == 'reviewing' ? 'selected' : '' }}>İnceleniyor</option>
                                        <option value="interviewed" {{ $candidate->status == 'interviewed' ? 'selected' : '' }}>Mülakat Yapıldı</option>
                                        <option value="hired" {{ $candidate->status == 'hired' ? 'selected' : '' }}>İşe Alındı</option>
                                        <option value="rejected" {{ $candidate->status == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $candidate->created_at->format('d.m.Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">Bu ilana henüz aday eklenmedi/başvurmadı.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
    <div id="addCandidateModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
        <div class="relative max-w-lg w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
            <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-gray-900">Aday Ekle</h3>
                <button onclick="document.getElementById('addCandidateModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('recruitment.candidates.store', $posting) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ad</label>
                        <input type="text" name="first_name" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Soyad</label>
                        <input type="text" name="last_name" class="input-field" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                    <input type="email" name="email" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                    <input type="text" name="phone" class="input-field" required>
                </div>

                <div class="pt-4 flex justify-end border-t border-gray-100">
                    <button type="submit" class="btn-primary">Adayı Kaydet</button>
                </div>
            </form>
        </div>
    </div>
    @endpush
</x-app-layout>
