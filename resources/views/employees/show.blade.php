<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-xl text-gray-800 leading-tight">
            — Personel Dosyası: {{ $employee->first_name }} {{ $employee->last_name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-8 border border-gray-200 shadow-sm grid grid-cols-3 gap-8">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Departman</p>
                    <p class="text-lg font-serif mt-1">{{ $employee->department->name ?? 'Belirtilmemiş' }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Pozisyon</p>
                    <p class="text-lg font-serif mt-1">{{ $employee->position->name ?? 'Belirtilmemiş' }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">E-Posta</p>
                    <p class="text-lg font-serif mt-1 text-indigo-600">{{ $employee->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 border border-gray-200 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest border-b pb-4 mb-4">Eğitim Geçmişi</h3>
                    @foreach($employee->education as $edu)
                        <div class="mb-3 pb-3 border-b border-gray-50 last:border-0">
                            <p class="font-bold text-sm">{{ $edu->school_name }}</p>
                            <p class="text-xs text-gray-500">{{ $edu->degree }} — Mezuniyet: {{ $edu->graduation_date }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white p-6 border border-gray-200 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest border-b pb-4 mb-4">Son Ödemeler</h3>
                    @foreach($employee->salaries->take(5) as $salary)
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm">{{ $salary->payment_date }}</p>
                            <p class="font-mono font-bold">{{ number_format($salary->amount, 2) }} TL</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>