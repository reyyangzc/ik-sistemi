<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personel Listesi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-end">
                <a href="{{ route('employees.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    + Yeni Personel Ekle
                </a>
            </div>

            <div class="flex flex-wrap gap-4">
                @forelse ($employees as $employee)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1 min-w-[300px] max-w-[400px] p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                        <p class="text-gray-600 mt-1">{{ $employee->email }}</p>
                        
                        <div class="mt-4 flex gap-3 border-t pt-4">
                           <a href="{{ route('employees.edit', $employee->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
    Düzenle
</a>
                           <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Bu personeli silmek istediğinize emin misiniz?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-900">Sil</button>
</form>
                        </div>
                    </div>
                @empty
                    <div class="w-full bg-white p-6 shadow-sm sm:rounded-lg text-gray-500 text-center border border-dashed border-gray-300">
                        Henüz sisteme kayıtlı bir personel bulunmamaktadır.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>