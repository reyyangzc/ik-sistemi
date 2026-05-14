<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
                Duyuru Düzenle
            </h2>
            <a href="{{ route('announcements.index') }}" class="text-sm font-semibold text-gray-600 hover:text-primary-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                İptal Et
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mt-6">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('announcements.update', $announcement) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Duyuru Başlığı</label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}" class="input-field" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Duyuru İçeriği</label>
                <textarea name="content" rows="6" class="input-field" required>{{ old('content', $announcement->content) }}</textarea>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="btn-primary">
                    Değişiklikleri Kaydet
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
