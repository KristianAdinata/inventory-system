@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Produk</h2>

<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf @method('PUT')

    <div>
        <label>Nama Produk</label>
        <input type="text" name="name" class="border rounded w-full px-3 py-2" value="{{ old('name', $product->name) }}">
    </div>

    <div>
        <label>Kategori</label>
        <select name="category_id" class="border rounded w-full px-3 py-2">
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected($product->category_id == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Stok</label>
        <input type="number" name="stock" class="border rounded w-full px-3 py-2" value="{{ old('stock', $product->stock) }}">
    </div>

    <div>
        <label>Harga</label>
        <input type="number" name="price" class="border rounded w-full px-3 py-2" value="{{ old('price', $product->price) }}">
    </div>

    <div>
        <label>Gambar Produk</label><br>
        @if($product->image_path)
            <img src="{{ asset('storage/'.$product->image_path) }}" alt="image" class="h-20 mb-2">
        @endif
        <input type="file" name="image" class="border rounded w-full px-3 py-2">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    <a href="{{ route('products.index') }}" class="underline ml-2">Kembali</a>
</form>
@endsection
