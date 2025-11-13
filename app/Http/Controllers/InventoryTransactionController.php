<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryTransactionController extends Controller
{
    public function index()
    {
        $transactions = InventoryTransaction::with(['product','user'])
            ->latest()
            ->paginate(15);

        $products = Product::all();
        return view('transactions.index', compact('transactions','products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);
            if ($data['type'] === 'out' && $product->stock < $data['quantity']) {
                abort(400, 'Stok tidak cukup untuk transaksi keluar');
            }

            // update stok
            $data['type'] === 'in'
                ? $product->increment('stock', $data['quantity'])
                : $product->decrement('stock', $data['quantity']);

            // simpan transaksi
            InventoryTransaction::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'note' => $data['note'] ?? null,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
    }
}
