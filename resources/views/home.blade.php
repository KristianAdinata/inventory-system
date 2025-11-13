@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="py-16 sm:py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        {{-- JUDUL UTAMA --}}
        <h1 class="text-6xl font-extrabold text-gray-900 tracking-tight mb-4">
            <span class="block text-indigo-600">Sistem Manajemen Stok</span>
            <span class="block">Otomatiskan Inventori Anda</span>
        </h1>
        
        {{-- DESKRIPSI (Sesuai Ketentuan Tugas) --}}
        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
            Kelola data barang, stok, dan transaksi inventori secara terstruktur dan real-time. Siap digunakan dengan otentikasi Admin dan User.
        </p>
        
        {{-- AREA CTA --}}
        <div class="mt-10 flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
            @auth
                {{-- Jika Sudah Login: Tampilkan Akses Dashboard --}}
                <a href="{{ url('/dashboard') }}" 
                   class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-lg text-white bg-green-600 hover:bg-green-700 transition duration-150 ease-in-out">
                    <i class="fas fa-chart-line mr-2"></i> Akses Dashboard
                </a>
                
            @else
                {{-- Jika Belum Login: Tampilkan Login dan Register --}}
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login ke Sistem
                </a>
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center justify-center px-8 py-3 border border-indigo-600 text-base font-medium rounded-md shadow-lg text-indigo-600 bg-white hover:bg-indigo-50 transition duration-150 ease-in-out">
                    Daftar Akun Baru
                </a>
            @endauth
        </div>

    </div>
</div>
@endsection