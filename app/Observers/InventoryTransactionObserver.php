<?php
namespace App\Observers;

use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;

class InventoryTransactionObserver
{
    // saat dibuat, ubah stok
    public function created(InventoryTransaction $transaction)
    {
        $this->applyQuantity($transaction, +1);
    }

    // saat dihapus, revert efek transaksi (misal hapus record)
    public function deleted(InventoryTransaction $transaction)
    {
        $this->applyQuantity($transaction, -1);
    }

    // saat diperbarui, kita revert lama lalu apply baru
    public function updating(InventoryTransaction $transaction)
    {
        // get original model before update
        $original = $transaction->getOriginal();

        DB::transaction(function () use ($transaction, $original) {
            // revert original effect
            $this->applyQuantityRaw($original['product_id'], $original['type'], (int)$original['quantity'], -1);

            // apply new effect (note: new values are in $transaction attributes)
            $this->applyQuantity($transaction, +1);
        });

        // prevent default double-apply (we already handled)
        // but note: in 'updating' we should not call save() here; the model will proceed
    }

    // helper: appliedir = +1 apply, -1 revert
    protected function applyQuantity(InventoryTransaction $t, int $appliedir)
    {
        $this->applyQuantityRaw($t->product_id, $t->type, $t->quantity, $appliedir);
    }

    protected function applyQuantityRaw($productId, $type, int $quantity, int $appliedir)
    {
        $delta = ($type === 'in') ? $quantity : -$quantity;
        $delta = $delta * $appliedir;

        // gunakan query langsung agar terhindar race condition (atomic)
        // misal: update products set stock = stock + delta where id = ?
        \DB::table('products')->where('id', $productId)->increment('stock', $delta);
        
        // safety: pastikan stock tidak negative
        // jika berisiko negative, tambahkan check dan rollback
    }
}