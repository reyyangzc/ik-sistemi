<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Profil Güncelleme Taleplerim
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Sol: Yeni Talep Formu -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Yeni Güncelleme Talebi</h3>
                
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mb-4 p-3 bg-blue-50 text-blue-700 rounded-xl text-sm">
                    Özlük bilgilerinizdeki güncellemeler İK onayına tabidir. Lütfen sadece değişen bilgilerinizi doldurun.
                </div>

                <form action="{{ route('profile.requests.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yeni Telefon Numarası</label>
                        <input type="text" name="phone" class="input-field" placeholder="Mevcut: {{ $employee->phone ?: 'Yok' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Doğum Tarihi</label>
                        <input type="date" name="birth_date" class="input-field" value="{{ $employee->birth_date }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Medeni Durum</label>
                        <select name="marital_status" class="input-field">
                            <option value="">Değiştirmek istemiyorum</option>
                            <option value="single">Bekar</option>
                            <option value="married">Evli</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Mevcut: {{ $employee->marital_status == 'married' ? 'Evli' : 'Bekar' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Çocuk Sayısı</label>
                        <input type="number" name="children_count" min="0" class="input-field" placeholder="Mevcut: {{ $employee->children_count }}">
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center mt-2">Talebi Gönder</button>
                </form>
            </div>
        </div>

        <!-- Sağ: Geçmiş Talepler -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Talep Geçmişi</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Tarih</th>
                                <th class="px-6 py-4 font-semibold">İstenen Değişiklikler</th>
                                <th class="px-6 py-4 font-semibold text-center">Durum</th>
                                <th class="px-6 py-4 font-semibold">Yönetici Notu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($requests as $req)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                        {{ $req->created_at->format('d.m.Y H:i') }}
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
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $req->admin_note ?: '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Geçmiş talebiniz bulunmuyor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
