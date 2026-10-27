<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('user', 'items.product');

        if ($request->search) {
            $query->where('sale_number', 'like', '%' . $request->search . '%');
        }

        $sales = $query->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $qty = (int) $item['quantity'];

                if ($product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok untuk produk {$product->name} tidak mencukupi! Stok tersisa: {$product->stock}.",
                    ]);
                }
            }

            $saleNumber = 'INV-' . date('YmdHis') . '-' . rand(100, 999);
            $total = 0;

            $sale = Sale::create([
                'sale_number' => $saleNumber,
                'user_id' => auth()->id(),
                'total' => 0,
                'sold_at' => now(),
            ]);

            foreach ($request->items as $item) {
                $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();
                $qty = (int) $item['quantity'];
                $subtotal = $product->selling_price * $qty;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->selling_price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $qty);
                $total += $subtotal;
            }

            $sale->update(['total' => $total]);
            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Transaksi berhasil disimpan & stok dipotong!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memproses transaksi: ' . $e->getMessage()]);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load('user', 'items.product');
        return view('sales.show', compact('sale'));
    }

    // Pembatalan Seluruh Transaksi
    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            foreach ($sale->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            $sale->delete();
            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Transaksi berhasil dibatalkan dan seluruh stok telah dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal membatalkan transaksi: ' . $e->getMessage()]);
        }
    }

    // Pembatalan SATUAN Item Produk
    public function destroyItem(SaleItem $item)
    {
        DB::beginTransaction();
        try {
            $sale = $item->sale;

            // Restore stok produk
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }

            // Kurangi total transaksi
            $newTotal = $sale->total - $item->subtotal;
            $item->delete();

            // Jika item di transaksi habis, hapus transaksi utama
            if ($sale->items()->count() === 0) {
                $sale->delete();
                DB::commit();
                return redirect()->route('sales.index')->with('success', 'Seluruh item dihapus, transaksi otomatis dibatalkan!');
            }

            $sale->update(['total' => $newTotal]);
            DB::commit();

            return redirect()->route('sales.show', $sale->id)->with('success', 'Item berhasil dibatalkan & stok dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus item: ' . $e->getMessage()]);
        }
    }
}