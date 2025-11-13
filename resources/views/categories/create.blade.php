@extends('layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-xl">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">🏷️ Tambah Kategori Baru</h2>

    {{-- Form mengarah ke route store --}}
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                   value="{{ old('name') }}" required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition duration-150">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition duration-150">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection