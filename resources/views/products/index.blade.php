@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')

{{-- JUDUL DAN TOMBOL TERPUSAT --}}
<div class="text-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">📦 Daftar Produk</h2>
    
    <div class="flex space-x-3 justify-center items-center">
    {{-- Tombol Tambah Produk --}}
    <a href="{{ route('products.create') }}" 
       class="inline-flex items-center bg-blue-700 hover:bg-blue-800 text-white font-medium px-5 py-2 rounded-md shadow-md hover:shadow-lg transition duration-150">
        <i class="fas fa-plus mr-1"></i> Tambah Produk
    </a>

    {{-- Tombol Export Excel --}}
    <a href="{{ route('products.export.excel') }}" 
       class="inline-flex items-center bg-yellow-600 hover:bg-yellow-700 text-white font-medium px-5 py-2 rounded-md shadow-md hover:shadow-lg transition duration-150">
        <i class="fas fa-file-excel mr-1"></i> Export Excel
    </a>
    </div>
</div>

{{-- FORM PENCARIAN & FILTER --}}
<form method="GET" action="{{ route('products.index') }}" class="mb-5 grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
    
    <div class="md:col-span-6">
        <label for="search_q" class="text-sm font-medium text-gray-700 mb-1 block">Pencarian Nama / SKU</label>
        <div class="flex">
            <input 
                type="text" 
                name="q" 
                id="search_q"
                value="{{ request('q') }}" 
                placeholder="Cari nama atau SKU produk..." 
                class="border border-gray-300 px-3 py-2 rounded-l-lg w-full focus:ring focus:ring-indigo-300 focus:outline-none"
            >
            <button 
                type="submit" 
                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-r-lg transition duration-150 ease-in-out"
            >
                Cari
            </button>
        </div>
    </div>
    
    <div class="md:col-span-4">
        <label for="category_filter" class="text-sm font-medium text-gray-700 mb-1 block">Filter Kategori</label>
        <select 
            name="category_id" 
            id="category_filter" 
            class="border border-gray-300 px-3 py-2 rounded-lg w-full focus:ring focus:ring-indigo-300 focus:outline-none"
        >
            <option value="">-- Semua Kategori --</option>
            @if(isset($categories))
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    @if (request('q') || request('category_id'))
        <div class="md:col-span-2">
            <a href="{{ route('products.index') }}" class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                Reset
            </a>
        </div>
    @endif
</form>

<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="w-full text-sm text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 border-b text-gray-700 uppercase text-xs">
                <th class="p-3">#</th>
                <th class="p-3">Gambar</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Kategori</th>
                <th class="p-3 text-center">Stok</th>
                <th class="p-3 text-right">Harga</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                    <td class="p-3">
                        @if ($product->image_path)
                            <img 
                                src="{{ asset('storage/' . $product->image_path) }}" 
                                alt="Gambar {{ $product->name }}" 
                                class="w-16 h-16 object-cover rounded"
                            >
                        @else
                            <span class="text-gray-400 text-xs">Tidak ada</span>
                        @endif
                    </td>
                    <td class="p-3 font-medium text-gray-900">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->category?->name ?? '-' }}</td>
                    <td class="p-3 text-center">{{ $product->stock }}</td>
                    <td class="p-3 text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        <a 
                            href="{{ route('products.edit', $product) }}" 
                            class="text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out"
                        >
                            Edit
                        </a>
                        <form 
                            action="{{ route('products.destroy', $product) }}" 
                            method="POST" 
                            class="inline"
                            onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="text-red-600 hover:text-red-800 ml-2 transition duration-150 ease-in-out"
                            >
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">
                        Produk tidak ditemukan, coba ubah kata kunci pencarian atau filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection