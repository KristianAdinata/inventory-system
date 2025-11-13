@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Tambah Produk</h2>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
        <label>Nama Produk</label>
        <input type="text" name="name" class="border rounded w-full px-3 py-2" value="{{ old('name') }}" required>
        @error('name') <div class="text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>Kategori</label>
        <select name="category_id" class="border rounded w-full px-3 py-2">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Stok</label>
        <input type="number" name="stock" class="border rounded w-full px-3 py-2" value="{{ old('stock', 0) }}">
    </div>

    <div>
        <label>Harga</label>
        <input type="number" name="price" class="border rounded w-full px-3 py-2" value="{{ old('price', 0) }}">
    </div>

    <div>
        <label>Upload Gambar Produk</label>
        <input type="file" name="image" class="border rounded w-full px-3 py-2">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    <a href="{{ route('products.index') }}" class="underline ml-2">Batal</a>
</form>
@endsection
