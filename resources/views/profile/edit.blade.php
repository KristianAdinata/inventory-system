@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">
    
    {{-- CTA DAN JUDUL --}}
    <div class="flex items-center justify-between border-b pb-4 mb-6">
        <h2 class="text-3xl font-bold text-gray-800">🛠️ Pengaturan Akun</h2>
        
        {{-- TOMBOL CTA KEMBALI --}}
        <a href="{{ route('products.index') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Produk
        </a>
    </div>

    {{-- KOTAK UPDATE PROFIL INFORMASI & FOTO --}}
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <header>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Informasi Profil</h3>
            <p class="mt-1 text-sm text-gray-600">
                Perbarui nama, email, dan gambar profil Anda.
            </p>
        </header>

        {{-- FORM UPDATE PROFIL --}}
        <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- AREA FOTO PROFIL (FIX Tampilan Gambar dan Input Name) --}}
            <div class="flex items-center space-x-4">
                {{-- Menampilkan Gambar Profil --}}
                <div class="flex-shrink-0">
                    @php
                        // Memastikan nama kolom yang digunakan: profile_photo_path
                        $imagePath = Auth::user()->profile_photo_path 
                                    ? asset('storage/' . Auth::user()->profile_photo_path) 
                                    : 'https://placehold.co/100x100/4F46E5/FFFFFF?text=PP';
                    @endphp
                    <img 
                        class="h-20 w-20 rounded-full object-cover border-4 border-gray-200" 
                        src="{{ $imagePath }}" 
                        alt="Foto Profil"
                    >
                </div>
                
                {{-- Input File --}}
                <div>
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700">Ganti Foto</label>
                    <input 
                        id="profile_photo" 
                        name="profile_photo" {{-- Input name ini SAMA dengan yang di Controller --}}
                        type="file" 
                        class="mt-1 block w-full text-sm text-gray-500
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0
                               file:text-sm file:font-semibold
                               file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100"
                    >
                    @error('profile_photo')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input id="name" name="name" type="text" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-150 ease-in-out">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
    
    {{-- KOTAK UPDATE PASSWORD --}}
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <header>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Ubah Kata Sandi</h3>
            <p class="mt-1 text-sm text-gray-600">
                Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
            </p>
        </header>
        
        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
                <input id="current_password" name="current_password" type="password" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       required autocomplete="current-password">
                @error('current_password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                <input id="password" name="password" type="password" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       required autocomplete="new-password">
                @error('password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                       required autocomplete="new-password">
                @error('password_confirmation')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-150 ease-in-out">
                    Simpan Kata Sandi Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection