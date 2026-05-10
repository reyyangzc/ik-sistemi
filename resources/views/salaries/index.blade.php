<x-app-layout>
    <x-slot name="header"><h2 class="font-serif italic text-xl">Maaş Yönetimi</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-8 border border-gray-200">
            <h3 class="text-xs font-black uppercase tracking-widest mb-6">Son Ödemeler</h3>
            @foreach($salaries as $salary)
                <div class="flex justify-between border-b py-4">
                    <span class="text-sm">{{ $salary->employee->first_name ?? 'Personel' }} - {{ $salary->payment_date }}</span>
                    <span class="font-mono font-bold">{{ number_format($salary->amount, 2) }} TL</span>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>