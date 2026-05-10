<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Personel Ekle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                
                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Ad</label>
                            <input type="text" name="first_name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Soyad</label>
                            <input type="text" name="last_name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">E-posta Adresi</label>
                            <input type="email" name="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Telefon</label>
                            <input type="text" name="phone" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">İşe Giriş Tarihi</label>
                            <input type="date" name="hire_date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Maaş (TL)</label>
                            <input type="number" step="0.01" name="base_salary" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Departman</label>
                            <select name="department_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Seçiniz...</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Ünvan</label>
                            <select name="position_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Seçiniz...</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex items-center justify-end mt-6 border-t pt-4">
                        <a href="{{ route('employees.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">İptal</a>
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Personeli Kaydet
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>