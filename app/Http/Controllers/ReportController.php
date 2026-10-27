<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Laporan Stok Barang
    public function stock()
    {
        $products = Product::with('category')->get();
        return view('reports.stock', compact('products'));
    }

    // Laporan Barang Masuk (Pembelian)
    public function incoming()
    {
        $purchases = Purchase::with(['supplier', 'purchaseItems.product'])->latest('purchased_at')->get();
        return view('reports.incoming', compact('purchases'));
    }

    // Laporan Barang Keluar (Penjualan)
    public function outgoing()
    {
        $sales = Sale::with('saleItems.product')->latest('sold_at')->get();
        return view('reports.outgoing', compact('sales'));
    }

    // Laporan Keuangan Ringkas (Laba / Rugi)
    public function finance(Request $request)
    {
        // Default tanggal dari SQL kamu (Bulan Oktober 2026)
        $startDate = $request->input('start_date', '2026-10-01');
        $endDate = $request->input('end_date', '2026-10-31');

        // 1. Total Pemasukan Penjualan (Berdasarkan kolom 'sold_at')
        $totalSales = Sale::whereBetween('sold_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total');

        // 2. Total Pengeluaran Pembelian (Berdasarkan kolom 'purchased_at')
        $totalPurchases = Purchase::whereBetween('purchased_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total');

        // 3. Estimasi Laba / Rugi
        $estimatedProfit = $totalSales - $totalPurchases;

        return view('reports.finance', compact('totalSales', 'totalPurchases', 'estimatedProfit', 'startDate', 'endDate'));
    }
}