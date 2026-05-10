<x-app-layout>
    <x-slot name="header"><h2 class="font-serif italic text-xl">İzin Yönetimi</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-8 border border-gray-200">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b uppercase text-[10px] tracking-widest text-gray-400">
                        <th class="pb-4">Personel</th>
                        <th class="pb-4">İzin Türü</th>
                        <th class="pb-4">Durum</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($leaves as $leave)
                    <tr>
                        <td class="py-4 text-sm font-bold">{{ $leave->employee->first_name ?? 'Bilinmiyor' }}</td>
                        <td class="py-4 text-sm">{{ $leave->leaveType->name ?? 'Genel' }}</td>
                        <td class="py-4 italic text-sm text-indigo-600">{{ $leave->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>