<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Talep Havuzu (İzinler)
            </h2>
            <a href="{{ route('leaves.create') }}" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>İzin Talep Et</span>
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center space-x-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Personel</th>
                        <th class="px-6 py-4 font-semibold">İzin Türü</th>
                        <th class="px-6 py-4 font-semibold">Açıklama</th>
                        <th class="px-6 py-4 font-semibold">Başlangıç - Bitiş</th>
                        <th class="px-6 py-4 font-semibold">Durum</th>
                        <th class="px-6 py-4 font-semibold text-right">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($leaves as $leave)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $leave->employee->first_name ?? 'Bilinmiyor' }} {{ $leave->employee->last_name ?? '' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $leave->type ?? 'Diğer' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate" title="{{ $leave->reason }}">
                            {{ $leave->reason ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($leave->status == 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Onaylandı</span>
                            @elseif($leave->status == 'rejected')
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Reddedildi</span>
                            @elseif($leave->status == 'suspended')
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Bekletiliyor</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Beklemede</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(auth()->user()->role_id == 1 && $leave->status == 'pending')
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('leaves.status', $leave) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Onayla">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('leaves.status', $leave) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="suspended">
                                        <button type="submit" class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors" title="Beklet">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('leaves.status', $leave) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Reddet">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Sistemde izin talebi bulunmuyor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>