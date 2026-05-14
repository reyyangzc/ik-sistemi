<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Personel Profil Güncelleme Talepleri
        </h2>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
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
                        <th class="px-6 py-4 font-semibold">Personel</th>
                        <th class="px-6 py-4 font-semibold">Değişiklik Talepleri</th>
                        <th class="px-6 py-4 font-semibold text-center">Durum</th>
                        <th class="px-6 py-4 font-semibold text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                {{ $req->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $req->employee->first_name ?? '-' }} {{ $req->employee->last_name ?? '' }}
                            </td>
                            <td class="px-6 py-4">
                                <ul class="list-disc list-inside text-gray-800 space-y-1">
                                    @if(isset($req->requested_data['phone']))
                                        <li>Telefon: {{ $req->requested_data['phone'] }}</li>
                                    @endif
                                    @if(isset($req->requested_data['birth_date']))
                                        <li>Doğum T: {{ $req->requested_data['birth_date'] }}</li>
                                    @endif
                                    @if(isset($req->requested_data['marital_status']))
                                        <li>Medeni D: {{ $req->requested_data['marital_status'] == 'married' ? 'Evli' : 'Bekar' }}</li>
                                    @endif
                                    @if(isset($req->requested_data['children_count']))
                                        <li>Çocuk: {{ $req->requested_data['children_count'] }}</li>
                                    @endif
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($req->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Bekliyor</span>
                                @elseif($req->status == 'approved')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Onaylandı</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Reddedildi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($req->status == 'pending')
                                    <button onclick="document.getElementById('actionModal-{{ $req->id }}').classList.remove('hidden')" class="px-3 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold transition-colors">
                                        İncele
                                    </button>

                                    <!-- Action Modal -->
                                    @push('modals')
                                    <div id="actionModal-{{ $req->id }}" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
                                        <div class="relative max-w-lg w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
                                            <div class="flex justify-between items-center mb-5">
                                                <h3 class="text-xl font-bold text-gray-900">Talebi Değerlendir</h3>
                                                <button onclick="document.getElementById('actionModal-{{ $req->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <p class="text-sm text-gray-600 mb-2">Talep Eden: <strong>{{ $req->employee->first_name }} {{ $req->employee->last_name }}</strong></p>
                                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                    <ul class="list-disc list-inside text-sm text-gray-800 space-y-1">
                                                        @if(isset($req->requested_data['phone']))
                                                            <li>Telefon: {{ $req->requested_data['phone'] }}</li>
                                                        @endif
                                                        @if(isset($req->requested_data['birth_date']))
                                                            <li>Doğum T: {{ $req->requested_data['birth_date'] }}</li>
                                                        @endif
                                                        @if(isset($req->requested_data['marital_status']))
                                                            <li>Medeni D: {{ $req->requested_data['marital_status'] == 'married' ? 'Evli' : 'Bekar' }}</li>
                                                        @endif
                                                        @if(isset($req->requested_data['children_count']))
                                                            <li>Çocuk: {{ $req->requested_data['children_count'] }}</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>

                                            <form action="{{ route('profile.requests.approve', $req) }}" method="POST" id="form-approve-{{ $req->id }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="admin_note" id="admin_note_approve_{{ $req->id }}">
                                            </form>
                                            <form action="{{ route('profile.requests.reject', $req) }}" method="POST" id="form-reject-{{ $req->id }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="admin_note" id="admin_note_reject_{{ $req->id }}">
                                            </form>

                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Yönetici Notu (Opsiyonel)</label>
                                                <textarea id="modal_admin_note_{{ $req->id }}" rows="2" class="input-field" placeholder="Personele iletilecek not..."></textarea>
                                            </div>

                                            <div class="flex space-x-3">
                                                <button onclick="document.getElementById('admin_note_reject_{{ $req->id }}').value = document.getElementById('modal_admin_note_{{ $req->id }}').value; document.getElementById('form-reject-{{ $req->id }}').submit();" class="flex-1 px-4 py-2 bg-red-50 text-red-700 hover:bg-red-100 rounded-xl font-semibold transition-colors text-center">Reddet</button>
                                                <button onclick="document.getElementById('admin_note_approve_{{ $req->id }}').value = document.getElementById('modal_admin_note_{{ $req->id }}').value; document.getElementById('form-approve-{{ $req->id }}').submit();" class="flex-1 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold shadow-lg shadow-green-500/30 transition-all text-center">Onayla ve Güncelle</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endpush
                                @else
                                    <span class="text-xs text-gray-400">İşlem Yapıldı</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Bekleyen profil güncelleme talebi bulunmuyor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
