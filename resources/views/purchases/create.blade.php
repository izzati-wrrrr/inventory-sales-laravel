<x-app-layout>
    <div style="background: white; padding: 20px 32px; border-bottom: 1px solid #e5e7eb;">
        <h2 style="font-size: 24px; font-weight: 800; color: #1f2937; margin: 0;">Tambah Transaksi Barang Masuk</h2>
        <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">Pilih supplier dan input rincian barang yang masuk</p>
    </div>

    <div style="padding: 28px 32px;">
        <form action="{{ route('purchases.store') }}" method="POST" style="max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <!-- Informast Transaksi -->
            <div style="background: white; padding: 24px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">No. Transaksi *</label>
                    <input type="text" name="purchase_number" value="{{ old('purchase_number', $autoNumber) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-family: monospace; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">Supplier / Pemasok *</label>
                    <select name="supplier_id" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">Tanggal Masuk *</label>
                    <input type="datetime-local" name="purchased_at" value="{{ old('purchased_at', now()->format('Y-m-d\TH:i')) }}" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                </div>
            </div>

            <!-- Tabel Dinamis Rincian Item Barang -->
            <div style="background: white; padding: 24px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);" x-data="{ items: [{ product_id: '', quantity: 1, unit_cost: 0 }] }">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin: 0;">📦 Rincian Barang Masuk</h3>
                    <button type="button" @click="items.push({ product_id: '', quantity: 1, unit_cost: 0 })" style="background-color: #2563eb; color: white; padding: 8px 14px; border-radius: 6px; border: none; font-size: 12px; font-weight: 700; cursor: pointer;">
                        + Tambah Baris Produk
                    </button>
                </div>

                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; font-size: 12px; color: #475569; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 10px;">PILIH PRODUK</th>
                            <th style="padding: 10px; width: 130px;">JUMLAH (QTY)</th>
                            <th style="padding: 10px; width: 190px;">HARGA BELI SATUAN (RP)</th>
                            <th style="padding: 10px; width: 60px; text-align: center;">HAPUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="index">
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px;">
                                    <select :name="'products['+index+'][product_id]'" x-model="item.product_id" required style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} (Stok saat ini: {{ $product->stock }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="padding: 10px;">
                                    <input type="number" :name="'products['+index+'][quantity]'" x-model="item.quantity" min="1" required style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
                                </td>
                                <td style="padding: 10px;">
                                    <input type="number" :name="'products['+index+'][unit_cost]'" x-model="item.unit_cost" min="0" required style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;">
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" style="background: #ef4444; color: white; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer; font-weight: bold;">✕</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                    <a href="{{ route('purchases.index') }}" style="text-decoration: none; color: #6b7280; padding: 10px 18px; font-weight: 600; font-size: 14px;">Batal</a>
                    <button type="submit" style="background-color: #0d7a46; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 700; font-size: 14px; border: none; cursor: pointer;">
                        Simpan Barang Masuk
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>