<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAK | Strategic Systems</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="text-2xl font-bold tracking-tighter text-black">RAK <span class="text-sm font-light text-gray-500 tracking-widest uppercase ml-2">Strategic Systems</span></div>
        <div class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-indigo-600">Panel</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-indigo-600">Giriş Yap</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-black text-white px-5 py-2 rounded-sm text-sm font-medium hover:bg-gray-800 transition">Kayıt Ol</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <header class="py-20 px-6 text-center">
        <h1 class="text-6xl font-extrabold tracking-tight mb-4">İnsan Kaynaklarında <br><span class="text-indigo-600">Stratejik Dönüşüm.</span></h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-10">Personel yönetimini dijitalleştirin, verimliliği RAK Strategic Systems ile en üst seviyeye taşıyın.</p>
        <div class="flex justify-center gap-4">
            <a href="#vision" class="border border-gray-300 px-8 py-3 rounded-sm font-medium hover:bg-gray-100 transition">Vizyonumuz</a>
            <a href="#mission" class="border border-gray-300 px-8 py-3 rounded-sm font-medium hover:bg-gray-100 transition">Misyonumuz</a>
        </div>
    </header>

    <section class="py-20 bg-white border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16">
            <div id="vision">
                <span class="text-indigo-600 font-bold uppercase tracking-widest text-sm">— Vizyonumuz</span>
                <h2 class="text-3xl font-bold mt-4 mb-6">Geleceğin İş Gücü Dinamiklerini Yönetmek</h2>
                <p class="text-gray-600 leading-relaxed text-lg">Şeffaf, veri odaklı ve insan merkezli bir liderlik anlayışıyla, global iş akışlarını dijital bir ekosistemde birleştirerek insan kaynakları yönetiminin geleceğine yön vermeyi hedefliyoruz.</p>
            </div>
            <div id="mission">
                <span class="text-indigo-600 font-bold uppercase tracking-widest text-sm">— Misyonumuz</span>
                <h2 class="text-3xl font-bold mt-4 mb-6">İnsanı Güçlendirmek, Stratejiyi Yönlendirmek</h2>
                <p class="text-gray-600 leading-relaxed text-lg">Organizasyonların her seviyesinde, yenilikçi araçlarımızla pozitif bir çalışan deneyimi oluşturmak ve stratejik hedeflere ulaşmak için insan potansiyelini en verimli şekilde kullanmayı amaçlıyoruz.</p>
            </div>
        </div>
    </section>

    <footer class="py-10 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} RAK GLOBAL STRATEGY GROUP. Tüm Hakları Saklıdır.
    </footer>
</body>
</html>