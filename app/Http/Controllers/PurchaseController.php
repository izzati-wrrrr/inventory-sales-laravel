<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'purchaseItems.product'])
            ->latest()
            ->paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $autoNumber = 'PO-' . date('Ymd') . '-' . sprintf('%03d', Purchase::count() + 1);
        
        return view('purchases.create', compact('suppliers', 'products', 'autoNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_number' => 'required|string|unique:purchases,purchase_number',
            'purchased_at' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;

            // 1. Simpan Transaksi Utama
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id() ?? 1,
                'purchase_number' => $request->purchase_number,
                'total' => 0,
                'status' => 'completed',
                'purchased_at' => $request->purchased_at,
            ]);

            // 2. Simpan Item Detail & Update Stok Produk
            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $totalAmount += $subtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);

                // Tambah stok produk secara otomatis
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                }
            }

            // Update Total Pembelian
            $purchase->update(['total' => $totalAmount]);
        });

        return redirect()->route('purchases.index')->with('success', 'Transaksi barang masuk beserta detail item berhasil dicatat!');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'purchaseItems.product']);
        return view('purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            // Kelola pengembalian stok jika riwayat dihapus (opsional)
            foreach ($purchase->purchaseItems as $item) {
                $product = Product::find($item->product_id);
                if ($product && $product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                }
            }
            $purchase->purchaseItems()->delete();
            $purchase->delete();
        });

        return redirect()->route('purchases.index')->with('success', 'Data barang masuk berhasil dihapus!');
    }
}