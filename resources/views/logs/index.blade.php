<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-xl text-gray-800 leading-tight">— Sistem Denetim Kayıtları</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 text-[10px] font-bold uppercase text-gray-400 tracking-widest">Kullanıcı</th>
                        <th class="p-4 text-[10px] font-bold uppercase text-gray-400 tracking-widest">İşlem</th>
                        <th class="p-4 text-[10px] font-bold uppercase text-gray-400 tracking-widest">Tarih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr>
                        <td class="p-4 text-sm font-bold">{{ $log->user->name ?? 'Sistem' }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $log->action }} - {{ $log->description }}</td>
                        <td class="p-4 text-xs font-mono text-gray-400">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-8 text-center text-gray-400 italic">Henüz bir hareket kaydedilmedi.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 bg-gray-50 border-t">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>