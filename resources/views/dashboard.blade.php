<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-900 tracking-tight flex items-center">
            @if(auth()->user()->role_id == 1)
                <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-lg text-sm mr-3 font-bold uppercase tracking-widest">Admin</span>
            @else
                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-lg text-sm mr-3 font-bold uppercase tracking-widest">Personel</span>
            @endif
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Welcome Card -->
    <div class="mb-8">
        <div class="bg-gradient-to-br from-indigo-900 via-primary-800 to-primary-900 rounded-[2rem] p-8 sm:p-10 text-white shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="absolute bottom-0 left-10 w-32 h-32 bg-primary-400 opacity-20 rounded-full blur-2xl group-hover:translate-x-10 transition-transform duration-1000"></div>
            
            <div class="relative z-10">
                <h3 class="text-4xl font-black mb-3 tracking-tight">Hoş Geldiniz, <span class="text-primary-300">{{ auth()->user()->name }}</span> 👋</h3>
                <p class="text-primary-100/80 text-lg font-medium max-w-2xl">
                    İnsan Kaynakları Yönetim Sistemine başarıyla giriş yaptınız. Tüm operasyonları ve özlük işlemlerinizi buradan yönetebilirsiniz.
                </p>
            </div>
        </div>
    </div>

    @if(auth()->user()->role_id == 1)
        <!-- ADMIN DASHBOARD -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Toplam Personel -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white flex items-center space-x-5 hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Toplam Personel</p>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['employee_count'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Bekleyen Onaylar -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white flex items-center space-x-5 hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Bekleyen Onaylar</p>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['total_pending'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Bugün İzinli -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white flex items-center space-x-5 hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-teal-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Bugün İzinli</p>
                    <p class="text-3xl font-black text-gray-900">{{ isset($stats['on_leave_today']) ? count($stats['on_leave_today']) : 0 }}</p>
                </div>
            </div>

            <!-- Yaklaşan Doğum Günleri -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white flex items-center space-x-5 hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-rose-400 to-pink-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Yaklaşan D.Günleri</p>
                    <p class="text-3xl font-black text-gray-900">{{ isset($stats['upcoming_birthdays']) ? count($stats['upcoming_birthdays']) : 0 }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Turnover & Verimlilik (Placeholder) -->
            <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-100 opacity-50 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                <h4 class="text-xl font-black text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Stratejik Raporlama
                </h4>
                
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-gray-600 uppercase tracking-wider">Turnover Oranı (Yıllık)</span>
                            <span class="text-xl font-black text-rose-500">4.2%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-gradient-to-r from-rose-400 to-rose-500 h-3 rounded-full" style="width: 15%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2 font-medium">Sektör ortalamasının (%8) altında, sağlıklı bir seviyede.</p>
                    </div>

                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-gray-600 uppercase tracking-wider">Genel Verimlilik Skoru</span>
                            <span class="text-xl font-black text-emerald-500">88/100</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 h-3 rounded-full" style="width: 88%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2 font-medium">Geçen çeyreğe göre %5 artış gösterdi.</p>
                    </div>
                </div>
            </div>

            <!-- Departman Bazlı Maliyet Dağılımı -->
            <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-100 opacity-50 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                <h4 class="text-xl font-black text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Departman Bütçe Dağılımı
                </h4>
                <div class="space-y-4 max-h-[200px] overflow-y-auto pr-2 scrollbar-hide">
                    @foreach($stats['department_costs'] ?? [] as $dept)
                        <div class="p-4 bg-gray-50/50 hover:bg-indigo-50/50 rounded-2xl border border-gray-100 transition-colors flex justify-between items-center group/item">
                            <span class="font-bold text-gray-700 group-hover/item:text-indigo-700 transition-colors">{{ $dept['name'] }}</span>
                            <span class="font-black text-gray-900">{{ number_format($dept['total'], 0, ',', '.') }} ₺</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <!-- PERSONEL DASHBOARD (Self Service) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Maaş Geçmişi -->
            <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white p-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-100 opacity-50 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                <h4 class="text-xl font-black text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Maaş Geçmişim
                </h4>
                <div class="space-y-3">
                    @forelse($employeeData['salaries'] ?? [] as $salary)
                    <div class="flex justify-between items-center p-4 bg-gray-50/50 hover:bg-emerald-50/50 rounded-2xl border border-gray-100 transition-colors">
                        <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($salary->payment_date)->translatedFormat('F Y') }}</span>
                        <span class="font-black text-gray-900">{{ number_format($salary->amount, 2, ',', '.') }} ₺</span>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500 font-medium bg-gray-50 rounded-2xl">
                        Kayıtlı maaş geçmişi bulunmuyor.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- İzin Geçmişi -->
            <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white p-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-100 opacity-50 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                <h4 class="text-xl font-black text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    Son İzin Taleplerim
                </h4>
                <div class="space-y-3">
                    @forelse($employeeData['leaves'] ?? [] as $leave)
                    <div class="flex justify-between items-center p-4 bg-gray-50/50 hover:bg-primary-50/50 rounded-2xl border border-gray-100 transition-colors">
                        <div>
                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($leave->start_date)->format('d.m.Y') }}</p>
                            <p class="text-xs text-gray-500 font-medium">{{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }} Gün</p>
                        </div>
                        <div>
                            @if($leave->status == 'approved')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-full shadow-sm">Onaylandı</span>
                            @elseif($leave->status == 'rejected')
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold uppercase tracking-wider rounded-full shadow-sm">Reddedildi</span>
                            @elseif($leave->status == 'suspended')
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-full shadow-sm">İptal</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full shadow-sm">Beklemede</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500 font-medium bg-gray-50 rounded-2xl">
                        İzin talebiniz bulunmuyor.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Şikayet ve İstek Kutusu -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white p-8 mb-8 relative overflow-hidden">
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-indigo-100 opacity-50 rounded-full blur-3xl -z-10"></div>
            <h4 class="text-xl font-black text-gray-900 mb-6 flex items-center">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mr-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                Şikayet ve İstek Kutusu
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-2xl font-medium border border-emerald-100">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-rose-50 text-rose-700 rounded-2xl font-medium border border-rose-100">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('complaints.store') }}" method="POST" class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Konu</label>
                            <input type="text" name="subject" class="w-full bg-white border-0 ring-1 ring-gray-200 focus:ring-2 focus:ring-primary-500 rounded-xl px-4 py-3 text-sm font-medium transition-shadow" required placeholder="Neyle ilgili?">
                        </div>
                        <div class="mb-6">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Mesajınız</label>
                            <textarea name="message" rows="3" class="w-full bg-white border-0 ring-1 ring-gray-200 focus:ring-2 focus:ring-primary-500 rounded-xl px-4 py-3 text-sm font-medium transition-shadow resize-none" required placeholder="Lütfen detayları belirtin..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gray-900 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-xl transition-colors duration-300 shadow-lg shadow-gray-900/20">Gönder</button>
                    </form>
                </div>

                <div>
                    <h5 class="font-black text-gray-700 mb-4 uppercase tracking-widest text-sm">Önceki Talepleriniz</h5>
                    <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 scrollbar-hide">
                        @forelse($employeeData['complaints'] ?? [] as $complaint)
                            <div class="p-5 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="font-black text-gray-900">{{ $complaint->subject }}</span>
                                    @if($complaint->status == 'unread')
                                        <span class="px-2 py-1 text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-700 rounded-lg">Okunmadı</span>
                                    @elseif($complaint->status == 'read')
                                        <span class="px-2 py-1 text-[10px] font-black uppercase tracking-wider bg-blue-100 text-blue-700 rounded-lg">Okundu</span>
                                    @else
                                        <span class="px-2 py-1 text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 rounded-lg">Çözüldü</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 font-medium leading-relaxed">{{ $complaint->message }}</p>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500 font-medium bg-gray-50 rounded-2xl border border-gray-100/50 border-dashed">
                                Henüz bir talebiniz bulunmuyor.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Duyurular (Ortak) -->
    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white p-8 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-48 h-48 bg-rose-50 opacity-50 rounded-bl-[100px] -z-10 group-hover:scale-110 transition-transform duration-700"></div>
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-black text-gray-900 flex items-center tracking-tight">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-400 to-red-500 text-white flex items-center justify-center mr-4 shadow-lg shadow-rose-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
                Kurumsal Duyurular
            </h3>
            @if(auth()->user()->role_id == 1)
                <a href="{{ route('announcements.index') }}" class="text-sm text-primary-600 hover:text-primary-800 font-black uppercase tracking-widest bg-primary-50 px-4 py-2 rounded-xl transition-colors">Tümünü Yönet &rarr;</a>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($announcements as $announcement)
                <div class="p-6 rounded-3xl border border-gray-100 hover:border-primary-200 hover:shadow-xl hover:shadow-primary-500/10 transition-all duration-300 bg-white group/card relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-primary-400 to-indigo-500 opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                    <h4 class="font-black text-xl text-gray-900 group-hover/card:text-primary-600 transition-colors mb-3">{{ $announcement->title }}</h4>
                    <p class="text-gray-600 font-medium leading-relaxed text-sm">{{ Str::limit($announcement->content, 120) }}</p>
                    <div class="mt-6 flex items-center text-xs text-gray-400 font-bold uppercase tracking-wider">
                        <svg class="w-4 h-4 mr-1.5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $announcement->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="col-span-full p-10 text-center text-gray-500 font-medium bg-gray-50 rounded-3xl border border-gray-100/50 border-dashed">
                    Henüz yayınlanmış bir duyuru bulunmuyor.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>