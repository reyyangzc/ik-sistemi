<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-gray-800">— İzin Yönetimi</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="max-w-full">
                @if (session('success'))
                    <div class="mb-4 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 text-[11px] font-black uppercase tracking-widest">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-100 text-red-600 px-4 py-3 text-[11px] font-black uppercase tracking-widest">
                        Hata oluştu:
                        <ul class="mt-2 font-mono text-[10px] normal-case tracking-normal">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @if(auth()->user()->role_id == 1)
                <div class="bg-white p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.3em] mb-6 border-b pb-4">Bekleyen & Onaylanan Talepler</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-100">
                                    <th class="pb-3 font-bold">Personel</th>
                                    <th class="pb-3 font-bold">Tür</th>
                                    <th class="pb-3 font-bold">Tarih Aralığı</th>
                                    <th class="pb-3 font-bold">Durum</th>
                                    <th class="pb-3 font-bold text-right">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests ?? [] as $req)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 font-serif italic text-gray-900 text-lg">
                                            {{ $req->employee?->first_name ?? 'Bilinmeyen' }} {{ $req->employee?->last_name ?? 'Personel' }}
                                        </td>
                                        <td class="py-4 text-xs font-bold text-gray-600">{{ $req->type }}</td>
                                        <td class="py-4 text-xs font-mono text-gray-500">
                                            {{ \Carbon\Carbon::parse($req->start_date)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($req->end_date)->format('d.m.Y') }}
                                        </td>
                                        <td class="py-4">
                                            @if($req->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest">Bekliyor</span>
                                            @elseif($req->status == 'approved')
                                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest">Onaylandı</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest">Reddedildi</span>
                                            @endif
                                        </td>
                                        <td class="py-4 flex justify-end space-x-2">
                                            @if($req->status == 'pending')
                                                <form action="{{ route('leaves.status', $req) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="text-[10px] bg-black text-white px-3 py-1.5 font-bold uppercase hover:bg-emerald-600 transition-colors">Onayla</button>
                                                </form>
                                                <form action="{{ route('leaves.status', $req) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="text-[10px] border border-gray-200 text-gray-600 px-3 py-1.5 font-bold uppercase hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors">Reddet</button>
                                                </form>
                                            @else
                                                <form action="{{ route('leaves.destroy', $req) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-[10px] text-gray-400 hover:text-red-600 font-bold uppercase underline transition-colors">Kaldır</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-xs font-mono text-gray-400 uppercase tracking-widest">Sistemde izin talebi bulunmuyor.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                <div class="bg-white p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.3em] mb-6">Yeni İzin Talebi</h3>
                    <form action="{{ route('leaves.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @csrf
                        
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-400">Talep Eden</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="w-full border-gray-100 bg-gray-50 text-gray-400 text-sm cursor-not-allowed" disabled>
                            
                            @php
                                $empId = \App\Models\Employee::where('user_id', auth()->id())->first()?->id;
                            @endphp
                            
                            <input type="hidden" name="employee_id" value="{{ $empId }}">
                            
                            @if(!$empId)
                                <p class="text-[9px] text-red-500 mt-1 font-bold italic">UYARI: Personel kaydınız bulunamadı!</p>
                            @endif
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-400">Başlangıç</label>
                            <input type="date" name="start_date" class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-400">Bitiş</label>
                            <input type="date" name="end_date" class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm" required>
                        </div>
                       <div class="md:col-span-2">
    <label class="text-[10px] font-bold uppercase text-gray-400">İzin Türü</label>
    <select name="type" class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm">
        <option value="Yıllık İzin">Yıllık İzin</option>
        <option value="Hastalık">Hastalık</option>
        <option value="Mazeret">Mazeret İzni</option>
    </select>
</div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-black text-white py-3 text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all">
                                TALEBİ GÖNDER
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>