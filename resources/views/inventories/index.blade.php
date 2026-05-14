<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Zimmet (Demirbaş) Yönetimi
            </h2>
            <button onclick="document.getElementById('addInventoryModal').classList.remove('hidden')" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Yeni Demirbaş</span>
            </button>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="m-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Demirbaş Bilgisi</th>
                        <th class="px-6 py-4 font-semibold">Seri Numarası</th>
                        <th class="px-6 py-4 font-semibold">Durum</th>
                        <th class="px-6 py-4 font-semibold">Zimmetli Personel</th>
                        <th class="px-6 py-4 font-semibold text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($inventories as $inv)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $inv->name }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $inv->type }}</div>
                            </td>
                            <td class="px-6 py-4 font-mono text-gray-600">
                                {{ $inv->serial_number ?: '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($inv->status == 'available')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Müsait</span>
                                @elseif($inv->status == 'assigned')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Zimmetli</span>
                                @elseif($inv->status == 'maintenance')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Bakımda</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Hurda/Kullanımdışı</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($inv->status == 'assigned' && $inv->currentAssignment)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                            {{ substr($inv->currentAssignment->employee->first_name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $inv->currentAssignment->employee->first_name }} {{ $inv->currentAssignment->employee->last_name }}</span>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">Veriliş: {{ \Carbon\Carbon::parse($inv->currentAssignment->assigned_at)->format('d.m.Y') }}</div>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="document.getElementById('editModal-{{ $inv->id }}').classList.remove('hidden')" class="text-gray-500 hover:text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                
                                @if($inv->status == 'available')
                                    <button onclick="document.getElementById('assignModal-{{ $inv->id }}').classList.remove('hidden')" class="px-3 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-xs font-semibold transition-colors">
                                        Personele Ata
                                    </button>
                                @elseif($inv->status == 'assigned')
                                    <button onclick="document.getElementById('returnModal-{{ $inv->id }}').classList.remove('hidden')" class="px-3 py-1 bg-orange-50 text-orange-700 hover:bg-orange-100 rounded-lg text-xs font-semibold transition-colors">
                                        İade Al
                                    </button>
                                @endif
                            </td>
                        </tr>

                        @push('modals')
                        <!-- Edit Modal -->
                        <div id="editModal-{{ $inv->id }}" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
                            <div class="relative max-w-md w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
                                <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-4">
                                    <h3 class="text-xl font-bold text-gray-900">Demirbaş Düzenle</h3>
                                    <button onclick="document.getElementById('editModal-{{ $inv->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <form action="{{ route('inventories.update', $inv) }}" method="POST" class="space-y-4">
                                    @csrf @method('PUT')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Demirbaş Adı / Marka Model</label>
                                        <input type="text" name="name" class="input-field mt-1" value="{{ $inv->name }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Türü (Laptop, Telefon vs.)</label>
                                        <input type="text" name="type" class="input-field mt-1" value="{{ $inv->type }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Seri Numarası</label>
                                        <input type="text" name="serial_number" class="input-field mt-1" value="{{ $inv->serial_number }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Durumu</label>
                                        <select name="status" class="input-field mt-1" required>
                                            <option value="available" {{ $inv->status == 'available' ? 'selected' : '' }}>Müsait</option>
                                            <option value="assigned" {{ $inv->status == 'assigned' ? 'selected' : '' }}>Zimmetli</option>
                                            <option value="maintenance" {{ $inv->status == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                                            <option value="retired" {{ $inv->status == 'retired' ? 'selected' : '' }}>Hurda / Kullanımdışı</option>
                                        </select>
                                    </div>
                                    <div class="pt-4 flex justify-end">
                                        <button type="submit" class="btn-primary">Güncelle</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Assign Modal -->
                        @if($inv->status == 'available')
                        <div id="assignModal-{{ $inv->id }}" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
                            <div class="relative max-w-md w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
                                <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-4">
                                    <h3 class="text-xl font-bold text-gray-900">Personele Zimmetle</h3>
                                    <button onclick="document.getElementById('assignModal-{{ $inv->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <form action="{{ route('inventories.assign', $inv) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="bg-gray-50 p-3 rounded-lg mb-4 text-sm">
                                        <strong>Seçilen:</strong> {{ $inv->name }} ({{ $inv->type }})
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Personel Seçin</label>
                                        <select name="employee_id" class="input-field mt-1" required>
                                            <option value="">Seçiniz...</option>
                                            @foreach($employees as $emp)
                                                <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->department->name ?? '' }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Veriliş Tarihi</label>
                                        <input type="date" name="assigned_at" class="input-field mt-1" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Teslim Notu (Opsiyonel)</label>
                                        <textarea name="notes" rows="2" class="input-field mt-1" placeholder="Adaptör, çanta vb. ekler..."></textarea>
                                    </div>
                                    <div class="pt-4 flex justify-end">
                                        <button type="submit" class="btn-primary w-full justify-center">Zimmetle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        <!-- Return Modal -->
                        @if($inv->status == 'assigned')
                        <div id="returnModal-{{ $inv->id }}" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
                            <div class="relative max-w-md w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
                                <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-4">
                                    <h3 class="text-xl font-bold text-gray-900">Zimmet İadesi Al</h3>
                                    <button onclick="document.getElementById('returnModal-{{ $inv->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <form action="{{ route('inventories.return', $inv) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="bg-gray-50 p-3 rounded-lg mb-4 text-sm">
                                        <strong>Demirbaş:</strong> {{ $inv->name }} <br>
                                        <strong>Teslim Eden:</strong> {{ $inv->currentAssignment->employee->first_name ?? '' }} {{ $inv->currentAssignment->employee->last_name ?? '' }}
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Yeni Durumu</label>
                                        <select name="status" class="input-field mt-1" required>
                                            <option value="available">Müsait (Başkasına Verilebilir)</option>
                                            <option value="maintenance">Bakıma Gönderilecek</option>
                                            <option value="retired">Hurdaya Ayrılacak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">İade Notu / Hasar Durumu (Opsiyonel)</label>
                                        <textarea name="notes" rows="2" class="input-field mt-1" placeholder="Cihaz sağlam teslim alındı..."></textarea>
                                    </div>
                                    <div class="pt-4 flex justify-end">
                                        <button type="submit" class="w-full px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all text-center">İadeyi Tamamla</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        @endpush
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Kayıtlı demirbaş bulunmuyor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
    <!-- Add Inventory Modal -->
    <div id="addInventoryModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
        <div class="relative max-w-md w-full mx-4 bg-white rounded-2xl shadow-2xl p-6 text-left">
            <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-4">
                <h3 class="text-xl font-bold text-gray-900">Yeni Demirbaş Ekle</h3>
                <button onclick="document.getElementById('addInventoryModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('inventories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Demirbaş Adı / Marka Model</label>
                    <input type="text" name="name" class="input-field mt-1" placeholder="Örn: Macbook Pro M2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Türü</label>
                    <input type="text" name="type" class="input-field mt-1" placeholder="Örn: Laptop, Telefon, Monitör" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Seri Numarası (Opsiyonel)</label>
                    <input type="text" name="serial_number" class="input-field mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Genel Notlar (Opsiyonel)</label>
                    <textarea name="notes" rows="2" class="input-field mt-1"></textarea>
                </div>
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="btn-primary w-full justify-center">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
    @endpush
</x-app-layout>
