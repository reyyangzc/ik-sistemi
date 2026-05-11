<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-gray-800 leading-tight">
            — {{ __('Personel Kadrosu') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Başarı Mesajı --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs uppercase tracking-widest font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-10 flex justify-between items-center">
                <p class="text-xs text-gray-400 uppercase tracking-[0.2em]">Toplam Kayıtlı Personel: <span class="text-black font-black">{{ count($employees) }}</span></p>
                <a href="{{ route('employees.create') }}" class="bg-black hover:bg-gray-800 text-white text-[10px] font-black uppercase tracking-[0.2em] py-3 px-6 shadow-xl transition duration-300">
                    + Yeni Personel Tanımla
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($employees as $employee)
                    <div class="bg-white overflow-hidden shadow-sm border border-gray-100 p-8 flex flex-col justify-between transition-transform hover:scale-[1.02]">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="bg-indigo-600 w-10 h-10 flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                </div>
                                <span class="text-[9px] uppercase tracking-widest bg-gray-100 px-2 py-1 text-gray-500 font-bold">Aktif Kadro</span>
                            </div>

                            <h3 class="text-xl font-serif italic text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                            <p class="text-xs font-mono text-gray-400 mb-6">{{ $employee->email }}</p>
                            
                            <div class="space-y-3 mb-8">
                                <div>
                                    <span class="block text-[9px] uppercase tracking-widest text-gray-300 font-black">Departman</span>
                                    <span class="text-sm text-gray-600 font-medium">{{ $employee->department->name ?? 'Atanmamış' }}</span>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase tracking-widest text-gray-300 font-black">Ünvan Seviyesi</span>
                                    <span class="text-sm text-gray-600 font-medium">{{ $employee->position->title ?? 'Atanmamış' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex gap-4 border-t border-gray-50 pt-6">
                            <a href="{{ route('employees.edit', $employee->id) }}" class="text-[10px] uppercase tracking-widest font-black text-indigo-600 hover:text-indigo-900">
                                Düzenle
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Bu personeli kadrodan silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] uppercase tracking-widest font-black text-red-400 hover:text-red-600">
                                    Kadrodan Çıkar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-20 text-center border border-dashed border-gray-200">
                        <p class="text-gray-400 font-serif italic text-lg">Henüz sisteme kayıtlı bir personel bulunmamaktadır.</p>
                        <a href="{{ route('employees.create') }}" class="text-indigo-600 text-[10px] uppercase tracking-widest font-black mt-4 inline-block hover:underline">
                            İlk personeli şimdi tanımla →
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>