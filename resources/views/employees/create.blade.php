<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('employees.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                Yeni Personel Kaydı
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            
            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-red-800 font-bold text-sm mb-2">Lütfen aşağıdaki hataları düzeltin:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-8 p-4 bg-blue-50/50 border border-blue-100 rounded-xl flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Bilgi</p>
                    <p>Sistem, personel için otomatik olarak bir kullanıcı hesabı oluşturacaktır. Geçici şifre <strong>RAK12345</strong> olarak belirlenir.</p>
                </div>
            </div>

            <form action="{{ route('employees.store') }}" method="POST" class="space-y-8">
                @csrf 
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Ad</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="input-field" placeholder="Ahmet" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Soyad</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="input-field" placeholder="Yılmaz" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kurumsal E-posta</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="ahmet@sirket.com" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Maaş (TL)</label>
                        <input type="number" step="0.01" name="base_salary" value="{{ old('base_salary') }}" class="input-field" placeholder="0.00" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">İşe Giriş Tarihi</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="input-field" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Doğum Tarihi</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="input-field">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Medeni Durum</label>
                        <select name="marital_status" class="input-field" required>
                            <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Bekar</option>
                            <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Evli</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Çocuk Sayısı</label>
                        <input type="number" name="children_count" value="{{ old('children_count', 0) }}" min="0" class="input-field" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Yıllık İzin Hakkı (Gün)</label>
                        <input type="number" name="leave_balance" value="{{ old('leave_balance', 14) }}" min="0" class="input-field" required>
                    </div>

                <div x-data="{
                    department_id: '{{ old('department_id', '') }}',
                    allPositions: {{ $positions->toJson() }},
                    get filteredPositions() {
                        if (!this.department_id) return [];
                        return this.allPositions.filter(p => p.department_id == this.department_id);
                    }
                }" class="grid grid-cols-1 md:grid-cols-2 gap-6 col-span-1 md:col-span-2">
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Departman</label>
                        <select name="department_id" x-model="department_id" class="input-field" required>
                            <option value="" disabled>Departman Seçin</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Ünvan / Pozisyon</label>
                        <select name="position_id" class="input-field" required :disabled="filteredPositions.length === 0">
                            <option value="" disabled selected>Pozisyon Seçin</option>
                            <template x-for="position in filteredPositions" :key="position.id">
                                <option :value="position.id" x-text="position.name" :selected="position.id == '{{ old('position_id') }}'"></option>
                            </template>
                        </select>
                        <p x-show="department_id && filteredPositions.length === 0" class="text-xs text-red-500 mt-1">Bu departmana ait ünvan bulunamadı.</p>
                    </div>

                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end space-x-3">
                    <a href="{{ route('employees.index') }}" class="btn-secondary">İptal</a>
                    <button type="submit" class="btn-primary">
                        Personeli Kaydet
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>