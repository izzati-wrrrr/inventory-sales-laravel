<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Barang Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: #111827; margin: 0;">Rincian Barang Masuk / Pembelian</h3>
                    <button onclick="window.print()" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer;" class="no-print">
                        🖨️ Cetak Laporan
                    </button>
                </div>

                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background-color: #dcfce7; color: #166534; border-bottom: 2px solid #bbf7d0;">
                            <th style="padding: 12px;">No</th>
                            <th style="padding: 12px;">No. Transaksi</th>
                            <th style="padding: 12px;">Supplier</th>
                            <th style="padding: 12px;">Tanggal Masuk</th>
                            <th style="padding: 12px;">Rincian Barang & Qty</th>
                            <th style="padding: 12px; text-align: right;">Total Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchases as $index => $purchase)
                            <tr style="border-bottom: 1px solid #e5e7eb; vertical-align: top;">
                                <td style="padding: 12px;">{{ $index + 1 }}</td>
                                <td style="padding: 12px; font-family: monospace; font-weight: bold; color: #166534;">{{ $purchase->purchase_number }}</td>
                                <td style="padding: 12px; font-weight: 600;">{{ $purchase->supplier->name ?? '-' }}</td>
                                <td style="padding: 12px; color: #4b5563;">{{ \Carbon\Carbon::parse($purchase->purchased_at)->translatedFormat('d M Y') }}</td>
                                
                                <td style="padding: 12px;">
                                    @if($purchase->purchaseItems && $purchase->purchaseItems->count() > 0)
                                        <ul style="margin: 0; padding-left: 16px; list-style-type: disc;">
                                            @foreach($purchase->purchaseItems as $item)
                                                <li style="margin-bottom: 4px;">
                                                    <strong>{{ $item->product->name ?? 'Produk' }}</strong> 
                                                    <span style="color: #059669; font-weight: bold;">({{ $item->quantity }} pcs)</span>
                                                    <small style="color: #6b7280;">@ Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span style="color: #9ca3af; font-style: italic;">Tidak ada rincian item</span>
                                    @endif
                                </td>

                                <td style="padding: 12px; text-align: right; font-weight: bold; color: #111827;">
                                    Rp {{ number_format($purchase->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 16px; text-align: center; color: #6b7280;">Belum ada data barang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print, nav, sidebar, aside { display: none !important; }
            main { margin-left: 0 !important; }
            body { background: white !important; }
        }
    </style>
</x-app-layout>