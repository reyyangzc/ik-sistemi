<x-guest-layout>
    <style>
        body { background-color: #f4f1ea !important; font-family: 'Inter', sans-serif; }
        .login-card { background: white; border: 1px solid #d1cfc7; border-radius: 0; box-shadow: 15px 15px 0px rgba(93, 64, 55, 0.03); }
        .btn-elite { background: #1a1a1a; color: white; border-radius: 0; font-weight: 700; letter-spacing: 2px; transition: 0.3s; border: none; }
        .btn-elite:hover { background: #8b0000; color: white; transform: translateY(-2px); }
        
        /* Vizyon Butonu Yeni Konum */
        .vision-wrapper {
            position: fixed;
            top: 50px; /* Üstten daha aşağıda */
            right: 80px; /* Sağdan iyice içeride */
            z-index: 50;
        }
        
        .vision-link { 
            font-family: 'Playfair Display', serif; 
            font-style: italic; 
            color: #5d4037; 
            text-decoration: none; 
            border-bottom: 1px solid #5d4037;
            cursor: pointer; 
            transition: 0.3s; 
            font-size: 1.1rem;
            letter-spacing: 1px;
        }
        .vision-link:hover { color: #8b0000; border-color: #8b0000; }
        
        .brand-logo { font-family: 'Playfair Display', serif; font-size: 5.5rem; font-weight: 900; line-height: 0.8; letter-spacing: -5px; color: #1a1a1a; margin-bottom: 15px; }
    </style>

    <div class="vision-wrapper">
        <span onclick="document.getElementById('visionModal').style.display='flex'" class="vision-link">
            — RAK Vision & Strategy
        </span>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-10 py-12 login-card">
            <div class="text-center mb-10">
                <h1 class="brand-logo">RAK</h1>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-bold" style="letter-spacing: 6px;">STRATEGIC SYSTEMS</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <x-text-input id="email" class="block w-full border-gray-300 rounded-none focus:border-black focus:ring-0 py-3" type="email" name="email" :value="old('email')" required autofocus placeholder="CORPORATE E-MAIL" />
                </div>

                <div class="mb-6">
                    <x-text-input id="password" class="block w-full border-gray-300 rounded-none focus:border-black focus:ring-0 py-3" type="password" name="password" required placeholder="PASSWORD" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded-none border-gray-300 text-black shadow-sm focus:ring-0">
                        <span class="ms-2 text-xs text-gray-400 uppercase tracking-widest" style="font-size: 0.65rem;">Remember Me</span>
                    </label>
                    <button class="btn-elite px-10 py-3 text-xs">LOG IN</button>
                </div>
            </form>
        </div>
        <p class="mt-8 text-xs text-gray-400 tracking-widest uppercase" style="font-size: 0.6rem;">© 2026 RAK GLOBAL STRATEGY GROUP</p>
    </div>

    <div id="visionModal" style="display:none; position:fixed; inset:0; background:rgba(10,10,11,0.96); z-index:100; align-items:center; justify-content:center; padding:20px; backdrop-filter: blur(8px);">
        <div style="background:#f9f7f2; max-width:850px; width:100%; padding:60px; position:relative; border-left: 20px solid #1a1a1a;">
            <button onclick="document.getElementById('visionModal').style.display='none'" style="position:absolute; top:20px; right:30px; border:none; background:none; font-size:2.5rem; cursor:pointer; color:#1a1a1a;">&times;</button>
            
            <div class="text-center">
                <h1 style="font-family: 'Playfair Display', serif; font-size: 4.5rem; font-weight:900; margin-bottom:5px; letter-spacing:-3px;">RAK VİZYON</h1>
                <p style="font-family: 'Inter', sans-serif; letter-spacing:5px; font-size:0.75rem; color:#8b0000; font-weight:700; text-transform:uppercase; margin-bottom:50px;">Global Strateji ve İnsan Kaynakları</p>
                
                <div style="border-top: 1px solid #d1cfc7; border-bottom: 1px solid #d1cfc7; padding:45px 0; margin-bottom:45px;">
                    <p style="font-family: 'Libre Baskerville', serif; font-size:1.4rem; line-height:2.1; color:#1a1a1a; font-style: italic; max-width:750px; margin: 0 auto;">
                        "RAK, Şerife Çakmak ve İbrahim Uğur Yılmaz'ın vizyoner liderliğiyle, insan sermayesini dijital bir güç odağına dönüştürmek için tasarlanmıştır."
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-8 text-left" style="font-family: 'Inter', sans-serif; font-size:0.85rem; font-weight:400; line-height:1.7;">
                    <div>
                        <p class="font-bold uppercase tracking-widest mb-2" style="color:#5d4037;">MİSYON</p>
                        <p>Yüksek disiplinli veri yönetimi ile kurumsal hiyerarşiyi modern estetikle harmanlamak.</p>
                    </div>
                    <div>
                        <p class="font-bold uppercase tracking-widest mb-2" style="color:#5d4037;">DEĞERLER</p>
                        <p>Şeffaf yönetim, analitik doğruluk ve stratejik mükemmellik odaklı personel ekosistemi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>