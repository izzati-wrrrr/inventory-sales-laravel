<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Struk Pembayaran / Detail Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="display: flex; flex-direction: column; align-items: center;">
            
            @if (session('success'))
                <div style="margin-bottom: 16px; padding: 12px; background-color: #dcfce7; color: #166534; border-radius: 6px; font-weight: bold; width: 360px;" class="no-print">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tombol Aksi di Atas -->
            <div style="margin-bottom: 20px; display: flex; gap: 12px;" class="no-print">
                <a href="{{ route('sales.index') }}" style="background: #4b5563; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: bold;">← Kembali</a>
                <button onclick="window.print()" style="background: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer;">🖨️ Cetak / Print Struk</button>
            </div>

            <!-- Kertas Struk Belanja Kasir -->
            <div id="receipt-paper" style="background: white; width: 360px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border-radius: 4px; font-family: 'Courier New', Courier, monospace; color: #000;">
                
                <!-- Header Toko -->
                <div style="text-align: center; margin-bottom: 16px; border-bottom: 1px dashed #000; padding-bottom: 12px;">
                    <h2 style="font-size: 20px; font-weight: bold; margin: 0;">INVENTORY STORE</h2>
                    <p style="font-size: 11px; margin: 4px 0;">Jl. Merdeka No. 123, Kota Lhokseumawe</p>
                    <p style="font-size: 11px; margin: 0;">Telp: (0651) 889922</p>
                </div>

                <!-- Info Transaksi -->
                <div style="font-size: 12px; margin-bottom: 12px; border-bottom: 1px dashed #000; padding-bottom: 8px;">
                    <div>No. Faktur : <strong>{{ $sale->sale_number }}</strong></div>
                    <div>Tanggal    : {{ $sale->sold_at }}</div>
                    <div>Kasir      : {{ $sale->user->name ?? 'Admin System' }}</div>
                </div>

                <!-- Tabel Item Belanja -->
                <table style="width: 100%; font-size: 12px; margin-bottom: 12px; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px dashed #000;">
                            <th style="text-align: left; padding-bottom: 4px;">Item</th>
                            <th style="text-align: center; padding-bottom: 4px;">Qty</th>
                            <th style="text-align: right; padding-bottom: 4px;">Subtotal</th>
                            @if(auth()->user()->role === 'admin')
                                <th class="no-print" style="padding-bottom: 4px;"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->items as $item)
                        <tr>
                            <td style="padding: 4px 0;">
                                {{ $item->product->name ?? 'Produk' }}<br>
                                <small style="color: #555;">@ Rp {{ number_format($item->unit_price ?? $item->price, 0, ',', '.') }}</small>
                            </td>
                            <td style="text-align: center; vertical-align: top; padding-top: 4px;">{{ $item->quantity }}</td>
                            <td style="text-align: right; vertical-align: top; padding-top: 4px;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            
                            <!-- Khusus Admin yang bisa menghapus item dari struk -->
                            @if(auth()->user()->role === 'admin')
                                <td class="no-print" style="text-align: right; vertical-align: top; padding-top: 4px; padding-left: 6px;">
                                    <form action="{{ route('sales.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Batalkan item ini & kembalikan stok?')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #dc2626; font-size: 10px; font-weight: bold; background: none; border: none; cursor: pointer; text-decoration: underline;">[x]</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Total -->
                <div style="border-top: 1px dashed #000; padding-top: 8px; font-size: 13px; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 15px;">
                        <span>TOTAL:</span>
                        <span>Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Footer Struk -->
                <div style="text-align: center; border-top: 1px dashed #000; padding-top: 12px;">
                    <p style="font-size: 12px; margin-bottom: 8px; font-weight: bold;">*** TERIMA KASIH ***</p>
                    <p style="font-size: 10px; color: #555; margin-bottom: 12px;">Barang yang dibeli dapat dibatalkan per item sebelum cetak akhir</p>
                    <div style="background: #000; color: #fff; padding: 4px; font-size: 10px; letter-spacing: 4px; display: inline-block;">||||| | |||| |||| | |||||</div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; }
            #receipt-paper, #receipt-paper * { visibility: visible; }
            #receipt-paper { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; }
            .no-print { display: none !important; }
        }
    </style>
</x-app-layout>