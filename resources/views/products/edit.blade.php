<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">SKU / Kode Produk</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                            <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Harga Beli (Rp)</label>
                            <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Harga Jual (Rp)</label>
                            <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Batas Minimum Stok</label>
                            <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                        <a href="{{ route('products.index') }}" style="text-decoration: none; color: #6b7280; font-size: 14px; padding: 8px 16px;">
                            Batal
                        </a>
                        <button type="submit" style="background-color: #2563eb; color: #ffffff; padding: 8px 18px; border-radius: 8px; font-weight: 600; font-size: 14px; border: none; cursor: pointer;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>