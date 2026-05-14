<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>İnsan Kaynakları Yönetim Sistemi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        .department-card {
            min-width: 280px;
            scroll-snap-align: start;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sol Taraf: Giriş Alanı -->
        <div class="w-full md:w-1/3 bg-white flex flex-col justify-center items-center p-8 md:p-12 shadow-2xl z-10">
            <div class="w-full max-w-md">
                <div class="flex justify-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-tr from-blue-600 to-blue-400 rounded-2xl flex items-center justify-center shadow-lg transform rotate-12">
                        <span class="text-white font-extrabold text-2xl -rotate-12">İK</span>
                    </div>
                </div>
                
                <h1 class="text-3xl font-extrabold text-center text-gray-900 mb-2">Sisteme Giriş</h1>
                <p class="text-center text-gray-500 mb-10 text-sm">Lütfen giriş yapmak istediğiniz yetki türünü seçin.</p>

                <div class="space-y-4">
                    <a href="{{ route('login') }}" class="w-full group relative flex justify-center py-4 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 shadow-xl transition-all hover:-translate-y-1">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-500 group-hover:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </span>
                        Admin Girişi
                    </a>

                    <a href="{{ route('login') }}" class="w-full group relative flex justify-center py-4 px-4 border-2 border-blue-600 text-sm font-medium rounded-xl text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition-all hover:-translate-y-1">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        Personel Girişi
                    </a>
                </div>

                <div class="mt-12 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} İnsan Kaynakları Yönetim Sistemi. Tüm hakları saklıdır.
                </div>
            </div>
        </div>

        <!-- Sağ Taraf: Karşılama ve Departmanlar -->
        <div class="w-full md:w-2/3 gradient-bg flex flex-col justify-center p-8 md:p-16 relative overflow-hidden">
            <!-- Arka Plan Dekorasyon -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-blue-400 opacity-20 rounded-full blur-3xl"></div>

            <div class="relative z-10 max-w-3xl">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">Geleceği Birlikte İnşa Ediyoruz</h2>
                <p class="text-blue-100 text-lg md:text-xl mb-12 max-w-2xl">Modern, şeffaf ve kurumsal insan kaynakları platformumuza hoş geldiniz. Departmanlar arası güçlü iletişim ile başarıyı hedefliyoruz.</p>

                <!-- Departman Slider / Kartları -->
                <div class="flex overflow-x-auto space-x-6 pb-8 hide-scrollbar snap-x" style="scroll-snap-type: x mandatory;">
                    
                    <div class="department-card bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-3xl snap-center hover:bg-white/20 transition-all">
                        <div class="w-12 h-12 bg-blue-500/30 rounded-2xl flex items-center justify-center mb-4 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <h3 class="text-white text-xl font-bold mb-2">Yazılım & Ar-Ge</h3>
                        <p class="text-blue-100 text-sm">Geleceğin teknolojilerini üreten, yenilikçi ve dinamik mühendislik kadromuz.</p>
                    </div>

                    <div class="department-card bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-3xl snap-center hover:bg-white/20 transition-all">
                        <div class="w-12 h-12 bg-rose-500/30 rounded-2xl flex items-center justify-center mb-4 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-white text-xl font-bold mb-2">İnsan Kaynakları</h3>
                        <p class="text-blue-100 text-sm">Şirket kültürümüzü yaşatan, mutlu ve verimli çalışma alanları yaratan ekibimiz.</p>
                    </div>

                    <div class="department-card bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-3xl snap-center hover:bg-white/20 transition-all">
                        <div class="w-12 h-12 bg-emerald-500/30 rounded-2xl flex items-center justify-center mb-4 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-white text-xl font-bold mb-2">Finans & Pazarlama</h3>
                        <p class="text-blue-100 text-sm">Ekonomik stratejilerimizi belirleyen ve markamızı global pazara taşıyan uzmanlar.</p>
                    </div>

                </div>
            </div>
        </div>

    </div>

</body>
</html>