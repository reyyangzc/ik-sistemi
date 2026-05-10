<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-xl text-gray-800 leading-tight">— Departman Yönetimi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-8 border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($departments as $department)
                <div class="p-6 border border-gray-100 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-widest">{{ $department->name }}</h3>
<p class="text-[10px] text-gray-400 mt-1">
    {{ $department->employees_count }} Personel Kayıtlı
</p>                    </div>
                    <span class="text-xs font-mono text-gray-300">#{{ $department->id }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>