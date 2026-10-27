<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ROUTE DASHBOARD (Bisa diakses Admin & Staff)
Route::get('/dashboard', function () {
    $totalProducts = Product::count();
    $totalSales = Sale::whereDate('sold_at', today())->sum('total');
    $totalTransactions = Sale::count();
    $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')->get();

    $salesChartLabels = [];
    $salesChartData = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = today()->subDays($i);
        $salesChartLabels[] = $date->translatedFormat('l');
        $salesChartData[] = Sale::whereDate('sold_at', $date)->sum('total');
    }

    return view('dashboard', compact(
        'totalProducts', 
        'totalSales', 
        'totalTransactions', 
        'lowStockProducts',
        'salesChartLabels',
        'salesChartData'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // ROUTE PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROUTE OPERASIONAL (Dapat diakses Admin & Staff)
    // 1. Kasir & Transaksi Penjualan
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');

    // 2. Daftar Produk (Staff hanya bisa lihat/Read-Only)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    
    // 3. Barang Masuk / Pembelian 
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');

    // ROUTE KHUSUS ADMIN (Dilindungi Middleware Backend)
    Route::middleware('role:admin')->group(function () {
        // Kelola Produk (Tambah, Edit, Hapus)
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Pembatalan Transaksi Penjualan
        Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
        Route::delete('/sales/items/{item}', [SaleController::class, 'destroyItem'])->name('sales.items.destroy');

        // Laporan
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
        Route::get('/reports/incoming', [ReportController::class, 'incoming'])->name('reports.incoming');
        Route::get('/reports/outgoing', [ReportController::class, 'outgoing'])->name('reports.outgoing');
        Route::get('/reports/finance', [ReportController::class, 'finance'])->name('reports.finance');

        // Master Data lainnya
        Route::resource('purchases', PurchaseController::class)->except(['create', 'store']);
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
    });
});

require __DIR__.'/auth.php';