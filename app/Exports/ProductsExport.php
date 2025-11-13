<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Opsional: Agar kolom otomatis menyesuaikan lebar

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil data dan tampilkan hanya kolom yang dibutuhkan
        return Product::select('id', 'name', 'price', 'stock', 'category_id', 'created_at')
                      ->with('category') // Load relasi kategori
                      ->get()
                      ->map(function ($product) {
                            return [
                                'ID' => $product->id,
                                'NAMA PRODUK' => $product->name,
                                'HARGA' => $product->price,
                                'STOK' => $product->stock,
                                'KATEGORI' => $product->category->name ?? 'N/A', // Tampilkan nama kategori
                                'TANGGAL DIBUAT' => $product->created_at->format('d/m/Y'),
                            ];
                      });
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'NAMA PRODUK',
            'HARGA',
            'STOK',
            'KATEGORI',
            'TANGGAL DIBUAT',
        ];
    }
}