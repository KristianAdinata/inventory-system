@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<h2 class="text-2xl font-semibold mb-4">Kategori</h2>
<a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded mb-3 inline-block">+ Tambah Kategori</a>

<table class="w-full bg-white shadow rounded">
<thead>
    <tr class="bg-gray-200 text-left">
        <th class="p-2">#</th>
        <th class="p-2">Nama</th>
        <th class="p-2">Aksi</th>
    </tr>
</thead>
<tbody>
@foreach ($categories as $category)
<tr class="border-t">
    <td class="p-2">{{ $loop->iteration }}</td>
    <td class="p-2">{{ $category->name }}</td>
    <td class="p-2">
        <a href="{{ route('categories.edit', $category) }}" class="text-blue-600">Edit</a>
        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-600 ml-2">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
@endsection
