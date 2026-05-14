<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 tracking-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Welcome Card -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-primary-600 to-indigo-600 rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-10 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
            
            <div class="relative z-10">
                <h3 class="text-3xl font-extrabold mb-2">Hoş Geldiniz, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-primary-100 text-lg">
                    İnsan Kaynakları Yönetim Sistemine başarıyla giriş yaptınız.
                </p>
            </div>
        </div>
    </div>

    @if(auth()->user()->role_id == 1)
        <!-- Admin Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Toplam Personel</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['employee_count'] ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Aylık Toplam Maaş</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_salary'] ?? 0, 2) }} ₺</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Bekleyen İzinler</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_leaves'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Departman Bazlı Maliyet Dağılımı
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($stats['department_costs'] ?? [] as $dept)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex justify-between items-center">
                        <span class="font-medium text-gray-700">{{ $dept['name'] }}</span>
                        <span class="font-bold text-gray-900">{{ number_format($dept['total'], 2) }} ₺</span>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Personel Dashboard (Employee) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Maaş Geçmişi -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Maaş Geçmişim
                </h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Dönem</th>
                                <th class="px-4 py-3">Tutar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($employeeData['salaries'] ?? [] as $salary)
                            <tr>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($salary->payment_date)->format('M Y') }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-800">{{ number_format($salary->amount, 2) }} ₺</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-center text-gray-500">Kayıtlı maaş geçmişi bulunmuyor.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- İzin Geçmişi -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Son İzin Taleplerim
                </h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Tarih</th>
                                <th class="px-4 py-3">Durum</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($employeeData['leaves'] ?? [] as $leave)
                            <tr>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($leave->start_date)->format('d.m.Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($leave->status == 'approved')
                                        <span class="text-green-600 font-semibold">Onaylandı</span>
                                    @elseif($leave->status == 'rejected')
                                        <span class="text-red-600 font-semibold">Reddedildi</span>
                                    @elseif($leave->status == 'suspended')
                                        <span class="text-gray-600 font-semibold">Askıya Alındı</span>
                                    @else
                                        <span class="text-amber-600 font-semibold">Beklemede</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-center text-gray-500">İzin talebiniz bulunmuyor.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Şikayet ve İstek Kutusu -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                Şikayet ve İstek Kutusu
            </h4>
            
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('complaints.store') }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konu</label>
                    <input type="text" name="subject" class="input-field" required placeholder="Neyle ilgili?">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mesajınız</label>
                    <textarea name="message" rows="3" class="input-field" required placeholder="Lütfen detayları belirtin..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full md:w-auto">Gönder</button>
            </form>

            <h5 class="font-semibold text-gray-700 mb-3">Önceki Talepleriniz</h5>
            <div class="space-y-3">
                @forelse($employeeData['complaints'] ?? [] as $complaint)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-bold text-gray-800">{{ $complaint->subject }}</span>
                            @if($complaint->status == 'unread')
                                <span class="px-2 py-1 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full">Okunmadı</span>
                            @elseif($complaint->status == 'read')
                                <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">Okundu</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Çözüldü</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">{{ $complaint->message }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Henüz bir talebiniz bulunmuyor.</p>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Duyurular (Hem Admin Hem Personel) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                Son Duyurular
            </h3>
            @if(auth()->user()->role_id == 1)
                <a href="{{ route('announcements.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold">Tümünü Yönet &rarr;</a>
            @endif
        </div>

        <div class="space-y-4">
            @forelse($announcements as $announcement)
                <div class="p-5 rounded-xl border border-gray-100 hover:border-primary-100 hover:shadow-md transition-all bg-gray-50 hover:bg-white group">
                    <h4 class="font-bold text-lg text-gray-900 group-hover:text-primary-600 transition-colors">{{ $announcement->title }}</h4>
                    <p class="text-gray-600 mt-2">{{ $announcement->content }}</p>
                    <div class="mt-4 flex items-center text-xs text-gray-400 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $announcement->created_at->diffForHumans() }}
                        <span class="mx-2">&bull;</span>
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Yönetim
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    Henüz yayınlanmış bir duyuru bulunmuyor.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>