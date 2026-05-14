<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Masraf ve Avans Taleplerim
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Sol: Yeni Talep Formu -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Yeni Talep Oluştur</h3>
                
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

                <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Talep Türü</label>
                        <select name="type" class="input-field" required>
                            <option value="expense">Masraf (Harcama Beyanı)</option>
                            <option value="advance">Avans Talebi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tutar (TL)</label>
                        <input type="number" step="0.01" name="amount" min="0.01" class="input-field" placeholder="0.00" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                        <textarea name="description" rows="3" class="input-field" placeholder="Masraf veya avansın kullanım amacı..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fatura / Fiş / Belge (Opsiyonel)</label>
                        <input type="file" name="receipt" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-all cursor-pointer border border-gray-200 rounded-xl p-1" accept=".jpg,.jpeg,.png,.pdf">
                        <p class="text-xs text-gray-500 mt-1">Maksimum 5MB. PDF, JPG, PNG.</p>
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
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Tarih</th>
                                <th class="px-6 py-4 font-semibold">Talep Tipi / Tutar</th>
                                <th class="px-6 py-4 font-semibold">Açıklama</th>
                                <th class="px-6 py-4 font-semibold text-center">Durum</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($requests as $req)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                        {{ $req->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold {{ $req->type == 'expense' ? 'text-purple-600' : 'text-blue-600' }}">
                                            {{ $req->type == 'expense' ? 'Masraf' : 'Avans' }}
                                        </div>
                                        <div class="text-lg font-bold text-gray-900 mt-1">{{ number_format($req->amount, 2) }} ₺</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-800 line-clamp-2" title="{{ $req->description }}">{{ $req->description }}</p>
                                        @if($req->receipt_path)
                                            <a href="{{ Storage::url($req->receipt_path) }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-700 font-medium inline-flex items-center space-x-1 mt-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                <span>Belgeyi Gör</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($req->status == 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Bekliyor</span>
                                        @elseif($req->status == 'approved')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Onaylandı</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Reddedildi</span>
                                        @endif
                                        
                                        @if($req->admin_note)
                                            <div class="mt-2 text-xs text-gray-500 italic" title="{{ $req->admin_note }}">
                                                "{{ Str::limit($req->admin_note, 30) }}"
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Geçmiş masraf/avans talebiniz bulunmuyor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
