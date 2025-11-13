<?php
// Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    // uncomment jika mau soft deletes
    // use SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'stock',
        'price',
        'description',
        'image_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope untuk melakukan pencarian pada kolom 'name', 'description', dan 'sku'.
     * Ini menggabungkan kedua scope search sebelumnya menjadi satu.
     */
    public function scopeSearch($query, $searchTerm)
    {
        if (!$searchTerm) return $query;
        $searchTerm = '%' . $searchTerm . '%';
        
        return $query->where('name', 'like', $searchTerm)
                     ->orWhere('description', 'like', $searchTerm)
                     ->orWhere('sku', 'like', $searchTerm); // Tambahkan pencarian berdasarkan SKU
    }

    /**
     * Scope untuk melakukan filter berdasarkan category_id.
     */
    public function scopeFilterCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }


    // relasi ke transaksi
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    // accessor untuk URL gambar (jika simpan di storage/app/public)
    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    // helper untuk menambah / mengurangi stok dengan validasi
    public function adjustStock(int $delta): void
    {
        // gunakan DB transaction di luar jika dipanggil bersamaan
        $new = $this->stock + $delta;
        if ($new < 0) {
            throw new \RuntimeException("Stock tidak boleh negatif");
        }
        $this->stock = $new;
        $this->save();
    }
}