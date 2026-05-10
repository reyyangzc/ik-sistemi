<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAK | Strategic Systems</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .rak-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="hidden md:block absolute top-10 right-10">
        <p class="rak-serif text-sm italic text-gray-800 border-t border-gray-800 pt-2 px-4 italic">
            — RAK Vision & Strategy
        </p>
    </div>

    <div class="min-h-screen flex flex-col justify-center items-center p-4">
        <div class="w-full sm:max-w-md bg-white shadow-2xl p-10 border border-gray-200">
            <div class="text-center mb-10">
                <h1 class="rak-serif text-6xl font-bold tracking-tighter text-black uppercase">RAK</h1>
                <p class="text-[10px] tracking-[0.4em] text-gray-400 uppercase mt-2 font-bold">Strategic Systems</p>
            </div>

            <div class="mt-6">
                {{ $slot }}
            </div>

            <div class="mt-12 text-center border-t pt-6">
                <p class="text-[9px] text-gray-400 tracking-widest uppercase italic">© 2026 RAK GLOBAL STRATEGY GROUP</p>
            </div>
        </div>
    </div>
</body>
</html>