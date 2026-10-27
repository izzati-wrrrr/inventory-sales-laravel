<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke User (Kasir/Admin yang mencatat transaksi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item Penjualan
    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    // Relasi alternatif alias (jika digunakan di tempat lain)
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }
}