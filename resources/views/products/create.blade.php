<x-app-layout>
    <div style="padding: 28px 32px; max-width: 900px; margin: 0 auto;">
        <div style="background: white; border-radius: 10px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
            <h2 style="font-size: 20px; font-weight: 800; color: #1f2937; margin: 0 0 20px 0; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                Tambah Produk Baru
            </h2>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <!-- SKU Otomatis -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">SKU / Kode Produk (Otomatis) *</label>
                        <input type="text" name="sku" value="{{ $autoSku }}" readonly style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 14px; background-color: #f3f4f6; color: #374151; font-weight: 700; cursor: not-allowed;">
                        @error('sku') <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nama Produk -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 14px;">
                        @error('name') <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Kategori *</label>
                        <select name="category_id" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 14px;">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Harga Beli -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Harga Beli (Rp) *</label>
                        <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 14px;">
                        @error('purchase_price') <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Harga Jual -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Harga Jual (Rp) *</label>
                        <input type="number" name="selling_price" value="{{ old('selling_price') }}" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 14px;">
                        @error('selling_price') <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Stok Awal -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Stok Awal *</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 14px;">
                        @error('stock') <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Batas Minimum Stok -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Batas Minimum Stok (Alert) *</label>
                        <input type="number" name="minimum_stock" value="{{ old('minimum_stock', 5) }}" required style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 14px;">
                        @error('minimum_stock') <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Tombol Aksi Sejajar -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('products.index') }}" style="background: #9ca3af; color: white; padding: 9px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600;">
                        Batal
                    </a>
                    <button type="submit" style="background: #0d7a46; color: white; border: none; padding: 9px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer;">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>