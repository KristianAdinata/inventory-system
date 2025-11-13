<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Sistem Inventori</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    {{-- NAVBAR --}}
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                {{-- Left Section (Logo + Menu) --}}
                <div class="flex items-center space-x-10">
                    {{-- Logo --}}
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-white tracking-wide">INVENTORI</a>

                    {{-- Menu --}}
                    <div class="flex space-x-6 items-center justify-start">
                        <a href="{{ route('products.index') }}" 
                           class="text-gray-200 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium flex items-center transition">
                           <i class="fas fa-box-open mr-2"></i> Produk
                        </a>
                        <a href="{{ route('categories.index') }}" 
                           class="text-gray-200 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium flex items-center transition">
                           <i class="fas fa-tags mr-2"></i> Kategori
                        </a>
                    </div>
                </div>

                {{-- User Section --}}
                <div class="flex items-center space-x-3">
                    @auth
                        <span class="text-gray-200 text-sm">Halo, {{ Auth::user()->name }}</span>
                        <a href="{{ route('profile.edit') }}" 
                           class="text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded-full transition">
                           <i class="fas fa-user-circle fa-lg"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-gray-300">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    {{-- MAIN CONTENT --}}
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
