<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                {{ auth()->user()->role_id == 1 ? 'Personel Maaş Takibi' : 'Maaş Geçmişim' }}
            </h2>
            @if(auth()->user()->role_id == 1)
                <button onclick="document.getElementById('paymentModal').classList.remove('hidden')" class="btn-primary flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Maaş Ödemesi Yap</span>
                </button>
            @endif
        </div>
    </x-slot>

    <!-- Payment Modal -->
    @push('modals')
    <div id="paymentModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-start justify-center pt-10 pb-10">
        <div class="relative max-w-md w-full mx-4 bg-white rounded-2xl shadow-2xl p-6">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-gray-900">Yeni Maaş Ödemesi</h3>
                <button onclick="document.getElementById('paymentModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('salaries.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Personel</label>
                    <select name="employee_id" required class="input-field">
                        <option value="">Personel Seçin...</option>
                        @if(isset($employees) && count($employees) > 0)
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }} ({{ number_format($emp->base_salary, 2) }} ₺)</option>
                            @endforeach
                        @else
                            <option disabled>Kayıtlı personel bulunamadı</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Temel Maaş / Brüt Tutar (₺)</label>
                    <input type="number" name="amount" step="0.01" required class="input-field" placeholder="Örn: 25000">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prim (₺)</label>
                        <input type="number" name="bonus" step="0.01" value="0" class="input-field" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kesinti (₺)</label>
                        <input type="number" name="deduction" step="0.01" value="0" class="input-field" placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama (Opsiyonel)</label>
                    <input type="text" name="notes" class="input-field" placeholder="Avans kesintisi, performans primi vb.">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ödeme Tarihi</label>
                    <input type="date" name="payment_date" required class="input-field" value="{{ date('Y-m-d') }}">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="btn-primary w-full justify-center">Ödemeyi Kaydet</button>
                </div>
            </form>
        </div>
    </div>
    @endpush

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
                        @if(auth()->user()->role_id == 1)
                            <th class="px-6 py-4 font-semibold">Personel</th>
                            <th class="px-6 py-4 font-semibold">Departman / Ünvan</th>
                            <th class="px-6 py-4 font-semibold text-right">Mevcut Maaş</th>
                            <th class="px-6 py-4 font-semibold text-center">Son Ödeme</th>
                        @else
                            <th class="px-6 py-4 font-semibold">Dönem</th>
                            <th class="px-6 py-4 font-semibold">Tutar</th>
                            <th class="px-6 py-4 font-semibold">Açıklama</th>
                            <th class="px-6 py-4 font-semibold text-center">İşlem</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @if(auth()->user()->role_id == 1)
                        @forelse($employees as $emp)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $emp->first_name }} {{ $emp->last_name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 font-semibold">{{ $emp->department->name ?? 'Bilinmiyor' }}</div>
                                    <div class="text-gray-500 text-xs">{{ $emp->position->name ?? 'Bilinmiyor' }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900 text-right">
                                    {{ number_format($emp->base_salary, 2) }} ₺
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $lastSalary = $emp->salaries->sortByDesc('payment_date')->first();
                                    @endphp
                                    @if($lastSalary)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            {{ \Carbon\Carbon::parse($lastSalary->payment_date)->format('M Y') }} Ödendi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Ödeme Kaydı Yok</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">Kayıtlı personel bulunmuyor.</td>
                            </tr>
                        @endforelse
                    @else
                        @forelse($salaries as $salary)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-gray-800 font-medium">
                                    {{ \Carbon\Carbon::parse($salary->payment_date)->format('F Y') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    <div class="text-lg text-green-600">{{ number_format($salary->net_salary, 2) }} ₺</div>
                                    <div class="text-xs text-gray-500 font-normal mt-1">
                                        Brüt: {{ number_format($salary->amount, 2) }} ₺ | 
                                        Prim: +{{ number_format($salary->bonus, 2) }} ₺ | 
                                        Kesinti: -{{ number_format($salary->deduction, 2) }} ₺
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $salary->notes ?? 'Düzenli Maaş Ödemesi' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('salaries.pdf', $salary) }}" target="_blank" class="inline-flex items-center space-x-2 px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-semibold transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span>PDF İndir</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">Maaş geçmişiniz bulunmuyor.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>