<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-gray-800 leading-tight">— Duyuru Yönetimi</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white p-8 border border-gray-100 shadow-sm">
                <h3 class="text-[11px] font-black uppercase tracking-[0.3em] mb-6 border-b pb-4">Yeni Duyuru Yayınla</h3>
                <form action="{{ route('announcements.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Başlık</label>
                        <input type="text" name="title" class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">İçerik</label>
                        <textarea name="content" rows="4" class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm" required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-black text-white px-8 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                            YAYINLA
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-8 border border-gray-100 shadow-sm">
                <h3 class="text-[11px] font-black uppercase tracking-[0.3em] mb-6 border-b pb-4">Yayınlanmış Duyurular</h3>
                <div class="space-y-4">
                    @forelse($announcements as $announcement)
                        <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                            <div>
                                <h4 class="font-serif italic text-lg">{{ $announcement->title }}</h4>
                                <p class="text-xs text-gray-500">{{ Str::limit($announcement->content, 100) }}</p>
                            </div>
                            <form action="{{ route('announcements.destroy', $announcement) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[10px] text-red-400 font-bold uppercase hover:text-red-600 transition">SİL</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs italic text-gray-400">Henüz duyuru eklenmemiş.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>