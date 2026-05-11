<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-gray-800 leading-tight">
            — {{ __('Yeni Personel Tanımlama') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 p-10">
                
                {{-- HATA MESAJLARI BÖLÜMÜ (Ekranın neden yenilendiğini burada göreceğiz) --}}
                @if ($errors->any())
                    <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500">
                        <p class="text-red-700 font-bold text-xs uppercase tracking-widest mb-2">Tanımlama Hatası:</p>
                        <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-10 pb-6 border-b border-gray-50">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-indigo-600 font-bold mb-2">Güvenlik Protokolü</p>
                    <p class="text-xs text-gray-400 italic">
                        Burada tanımlanan personel için sistem otomatik olarak bir kullanıcı hesabı oluşturacaktır. 
                        Geçici şifre varsayılan olarak <span class="font-mono font-bold text-gray-600">RAK12345</span> atanacaktır.
                    </p>
                </div>

                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                        
                        {{-- Ad --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">Ad</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 transition-colors" placeholder="Örn: Ahmet" required>
                        </div>

                        {{-- Soyad --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">Soyad</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 transition-colors" placeholder="Örn: Yılmaz" required>
                        </div>

                        {{-- Kurumsal E-posta --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">Kurumsal E-posta</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 transition-colors font-mono" placeholder="ahmet.yilmaz@rak.com" required>
                        </div>

                        {{-- Telefon --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">Telefon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 transition-colors" placeholder="+90 5xx ...">
                        </div>

                        {{-- İşe Giriş Tarihi --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">İşe Giriş Tarihi</label>
                            <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 text-gray-500" required>
                        </div>

                        {{-- Başlangıç Maaşı --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">Başlangıç Maaşı (TL)</label>
                            <input type="number" step="0.01" name="base_salary" value="{{ old('base_salary') }}" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 font-mono" placeholder="00.000" required>
                        </div>

                        {{-- Departman Ataması --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">Departman Ataması</label>
                            <select name="department_id" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 appearance-none cursor-pointer" required>
                                <option value="" disabled selected>Seçiniz...</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Ünvan Seviyesi (title sütunu kullanıldı) --}}
                        <div class="space-y-1">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-black">Ünvan Seviyesi</label>
                            <select name="position_id" class="w-full border-0 border-b border-gray-200 focus:border-black focus:ring-0 text-sm py-2 px-0 appearance-none cursor-pointer" required>
                                <option value="" disabled selected>Seçiniz...</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                        {{ $position->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex items-center justify-between mt-16 pt-8 border-t border-gray-50">
                        <a href="{{ route('employees.index') }}" class="text-[10px] uppercase tracking-[0.2em] text-gray-400 hover:text-black transition-colors font-bold">
                            ← İşlemi İptal Et
                        </a>
                        <button type="submit" class="bg-black text-white px-12 py-4 text-[10px] font-black uppercase tracking-[0.3em] hover:bg-gray-800 transition duration-300 shadow-xl">
                            Personeli Kadroya Tanımla
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>