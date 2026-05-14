<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            Şikayet ve İstek Kutusu (Admin)
        </h2>
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
                        <th class="px-6 py-4 font-semibold">Tarih</th>
                        <th class="px-6 py-4 font-semibold">Personel</th>
                        <th class="px-6 py-4 font-semibold">Konu</th>
                        <th class="px-6 py-4 font-semibold w-1/3">Mesaj</th>
                        <th class="px-6 py-4 font-semibold">Durum</th>
                        <th class="px-6 py-4 font-semibold text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($complaints as $complaint)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">
                            {{ $complaint->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $complaint->employee->first_name ?? '' }} {{ $complaint->employee->last_name ?? 'Bilinmiyor' }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $complaint->subject }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $complaint->message }}
                        </td>
                        <td class="px-6 py-4">
                            @if($complaint->status == 'unread')
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Okunmadı</span>
                            @elseif($complaint->status == 'read')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">İnceleniyor</span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Çözüldü</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                @if($complaint->status != 'read')
                                <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="read">
                                    <button type="submit" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Okundu İşaretle">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </form>
                                @endif
                                @if($complaint->status != 'resolved')
                                <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="resolved">
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Çözüldü İşaretle">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Henüz herhangi bir şikayet/istek bulunmuyor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
