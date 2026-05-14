<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Yeni İzin Talebi
            </h2>
            <a href="{{ route('leaves.index') }}" class="text-sm font-semibold text-gray-600 hover:text-primary-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mt-6">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('leaves.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Başlangıç Tarihi</label>
                    <input type="date" name="start_date" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bitiş Tarihi</label>
                    <input type="date" name="end_date" class="input-field" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">İzin Türü</label>
                <select name="type" class="input-field" required>
                    <option value="">Seçiniz...</option>
                    <option value="Yıllık İzin">Yıllık İzin</option>
                    <option value="Mazeret İzni">Mazeret İzni</option>
                    <option value="Hastalık Raporu">Hastalık Raporu</option>
                    <option value="Diğer">Diğer</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama / Mazeret Nedeni</label>
                <textarea name="reason" rows="4" class="input-field" placeholder="Lütfen izne ayrılma nedeninizi kısaca açıklayın..."></textarea>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="btn-primary">
                    Talebi Gönder
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
