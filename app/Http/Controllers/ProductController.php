<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// Pastikan package sudah terinstall dan import Facade Excel
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\ProductsExport; // Import class Export yang sudah dibuat

// app/Http/Controllers/ProductController.php

// ... (Imports tetap sama)

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk dengan fitur pencarian, filter, & pagination.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // 1. Logika Pencarian (menggunakan scopeSearch yang sudah diperbaiki)
        // Memanggil scopeSearch dari Model Product, menggunakan nilai request('q')
        $query->search($request->q); 
        
        // 2. Logika Filter (Berdasarkan category_id)
        if ($request->has('category_id') && $request->category_id != '') {
            $query->filterCategory($request->category_id);
        }

        // Ambil data dengan pagination dan pertahankan query string (pencarian/filter)
        $products = $query->latest()->paginate(10)->withQueryString();
        
        // Ambil semua kategori untuk digunakan di dropdown filter pada view
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    // ... (method create, store, update, destroy, dan exportExcel lainnya tetap sama)


    /**
     * Form untuk membuat produk baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'nullable|string|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Simpan file ke storage/app/public/products
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail produk.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'nullable|string|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Upload gambar baru
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
    
    /**
     * Export data Produk ke file Excel (Fitur Tambahan Step 14).
     */
    public function exportExcel()
    {
        $filename = 'data_produk_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new ProductsExport, $filename);
    }
}