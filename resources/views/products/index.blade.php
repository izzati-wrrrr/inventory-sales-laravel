<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Produk / Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tombol Tambah (Khusus Admin) & Form Cari -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('products.create') }}" style="background-color: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                                + Tambah Produk
                            </a>
                        @else
                            <span style="font-size: 13px; color: #6b7280; font-weight: 600; background: #f3f4f6; padding: 8px 12px; border-radius: 6px; border: 1px solid #e5e7eb;">
                                🔒 Mode Lihat Data (Staff)
                            </span>
                        @endif
                    </div>
                    
                    <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 8px; margin: 0;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/SKU..." style="border: 1px solid #d1d5db; padding: 8px 12px; border-radius: 6px; outline: none;">
                        <button type="submit" style="background-color: #1f2937; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600;">Cari</button>
                    </form>
                </div>

                <table class="w-full text-left border-collapse" style="width: 100%;">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th style="padding: 12px;">SKU</th>
                            <th style="padding: 12px;">Nama Produk</th>
                            <th style="padding: 12px;">Kategori</th>
                            <th style="padding: 12px;">Harga Beli</th>
                            <th style="padding: 12px;">Harga Jual</th>
                            <th style="padding: 12px;">Stok</th>
                            <th style="padding: 12px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-b hover:bg-gray-50">
                                <td style="padding: 12px; font-family: monospace;">{{ $product->sku }}</td>
                                <td style="padding: 12px; font-weight: 600;">{{ $product->name }}</td>
                                <td style="padding: 12px;">{{ $product->category->name ?? '-' }}</td>
                                <td style="padding: 12px;">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                <td style="padding: 12px;">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td style="padding: 12px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; background-color: {{ $product->stock <= $product->minimum_stock ? '#fee2e2' : '#dcfce7' }}; color: {{ $product->stock <= $product->minimum_stock ? '#991b1b' : '#166534' }};">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td style="padding: 12px;">
                                    @if(auth()->user()->role === 'admin')
                                        <div style="display: flex; gap: 12px; align-items: center;">
                                            <a href="{{ route('products.edit', $product->id) }}" style="color: #4f46e5; font-weight: 600; text-decoration: none;">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #dc2626; font-weight: 600; background: none; border: none; cursor: pointer; padding: 0;">Hapus</button>
                                            </form>
                                        </div>
                                    @else
                                        <span style="color: #9ca3af; font-size: 13px; font-style: italic;">Hanya Lihat</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 12px; text-align: center; color: #6b7280;">Belum ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="margin-top: 16px;">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>