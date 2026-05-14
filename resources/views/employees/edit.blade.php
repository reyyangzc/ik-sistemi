<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personel Düzenle: ') . $employee->first_name . ' ' . $employee->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf 
                    @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Ad</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Soyad</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">E-posta Adresi</label>
                            <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Telefon</label>
                            <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">İşe Giriş Tarihi</label>
                            <input type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Maaş (TL)</label>
                            <input type="number" step="0.01" name="base_salary" value="{{ old('base_salary', $employee->base_salary) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Doğum Tarihi</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Medeni Durum</label>
                            <select name="marital_status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="single" {{ old('marital_status', $employee->marital_status) == 'single' ? 'selected' : '' }}>Bekar</option>
                                <option value="married" {{ old('marital_status', $employee->marital_status) == 'married' ? 'selected' : '' }}>Evli</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Çocuk Sayısı</label>
                            <input type="number" name="children_count" value="{{ old('children_count', $employee->children_count) }}" min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Yıllık İzin Hakkı (Gün)</label>
                            <input type="number" name="leave_balance" value="{{ old('leave_balance', $employee->leave_balance) }}" min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Departman</label>
                            <select name="department_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Seçiniz...</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Ünvan</label>
                            <select name="position_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Seçiniz...</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                                        {{ $position->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex items-center justify-end mt-6 border-t pt-4">
                        <a href="{{ route('employees.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">İptal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-black font-bold py-2 px-4 rounded shadow-md transition duration-150">
    Değişiklikleri Kaydet
</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>