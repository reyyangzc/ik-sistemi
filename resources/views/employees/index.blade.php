<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Personel Yönetimi
            </h2>
            <a href="{{ route('employees.create') }}" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Yeni Personel</span>
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
                        <th class="px-6 py-4 font-semibold">Personel Bilgisi</th>
                        <th class="px-6 py-4 font-semibold">Departman & Ünvan</th>
                        <th class="px-6 py-4 font-semibold">İşe Giriş</th>
                        <th class="px-6 py-4 font-semibold text-right">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($employees as $employee)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-100 to-indigo-100 flex items-center justify-center text-primary-700 font-bold border border-primary-200">
                                    {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $employee->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-700">{{ $employee->department->name ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $employee->position->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-700">{{ \Carbon\Carbon::parse($employee->hire_date)->format('d.m.Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($employee->hire_date)->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('employees.show', $employee) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Görüntüle">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('employees.edit', $employee) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Düzenle">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline-block" onsubmit="return confirm('Bu personeli silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Sil">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p>Sistemde henüz kayıtlı personel bulunmuyor.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>