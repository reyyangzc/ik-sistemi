<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Pozisyon ve Ünvan Yönetimi
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 mt-6 overflow-hidden">
        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">ID</th>
                        <th class="px-6 py-4 font-semibold">Ünvan Adı</th>
                        <th class="px-6 py-4 font-semibold">Bağlı Olduğu Departman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($positions as $position)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 font-medium">#{{ $position->id }}</td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $position->name }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $position->department->name ?? 'Belirtilmemiş' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">Kayıtlı pozisyon bulunmuyor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
