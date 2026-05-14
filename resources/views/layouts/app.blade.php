<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'İnsan Kaynakları') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-primary-50 min-h-screen text-gray-800">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <!-- Header -->
            @include('layouts.header')

            <main class="p-6 sm:p-10 space-y-6">
                <!-- Page Heading -->
                @isset($header)
                    <header class="mb-6">
                        {{ $header }}
                    </header>
                @endisset

                <!-- Content Slot -->
                <div class="glass-panel p-6 sm:p-8 relative z-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Modals -->
    @stack('modals')
</body>
</html>
