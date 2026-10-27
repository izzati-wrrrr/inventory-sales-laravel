<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Demo Admin & Staff
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff Kasir',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // 2. Buat Kategori Dummy
        $cat1 = Category::create(['name' => 'Elektronik']);
        $cat2 = Category::create(['name' => 'Pakaian']);

        // 3. Buat Supplier Dummy
        Supplier::create([
            'name' => 'PT Distributor Jaya',
            'phone' => '081234567890',
            'email' => 'supplier@jaya.com',
        ]);

        // 4. Buat Produk Dummy
        Product::create([
            'category_id' => $cat1->id,
            'sku' => 'PRD-001',
            'name' => 'Mouse Wireless',
            'purchase_price' => 50000,
            'selling_price' => 75000,
            'stock' => 20,
            'minimum_stock' => 5,
        ]);

        Product::create([
            'category_id' => $cat2->id,
            'sku' => 'PRD-002',
            'name' => 'Kaos Polos Cotton',
            'purchase_price' => 30000,
            'selling_price' => 50000,
            'stock' => 3,
            'minimum_stock' => 5,
        ]);
    }
}