<x-app-layout>
    <div style="background: white; padding: 20px 32px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #1f2937; margin: 0;">Detail Barang Masuk</h2>
            <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">No. Transaksi: <strong style="font-family: monospace; color: #111827;">{{ $purchase->purchase_number }}</strong></p>
        </div>
        <a href="{{ route('purchases.index') }}" style="background-color: #6b7280; color: white; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 13px; text-decoration: none;">
            ← Kembali
        </a>
    </div>

    <div style="padding: 28px 32px;">
        <div style="max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Ringkasan Informasi -->
            <div style="background: white; padding: 24px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase;">Supplier / Pemasok</div>
                    <div style="font-size: 16px; font-weight: 700; color: #1f2937; margin-top: 4px;">{{ $purchase->supplier->name ?? '-' }}</div>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase;">Tanggal Masuk</div>
                    <div style="font-size: 15px; font-weight: 600; color: #374151; margin-top: 4px;">{{ \Carbon\Carbon::parse($purchase->purchased_at)->translatedFormat('d F Y, H:i') }}</div>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase;">Total Pembelian</div>
                    <div style="font-size: 18px; font-weight: 800; color: #0d7a46; margin-top: 4px;">Rp {{ number_format($purchase->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Tabel Detail Item Barang -->
            <div style="background: white; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e5e7eb; font-weight: 700; color: #1f2937;">
                    📦 Rincian Barang yang Diterima
                </div>
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background-color: #f8fafc; color: #475569; border-bottom: 1px solid #e2e8f0; font-size: 12px; font-weight: 700;">
                            <th style="padding: 12px 20px;">SKU</th>
                            <th style="padding: 12px 20px;">Nama Produk</th>
                            <th style="padding: 12px 20px; text-align: center;">Jumlah (Qty)</th>
                            <th style="padding: 12px 20px; text-align: right;">Harga Beli (Satuan)</th>
                            <th style="padding: 12px 20px; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchase->purchaseItems as $item)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 20px; font-family: monospace; color: #64748b;">{{ $item->product->sku ?? '-' }}</td>
                                <td style="padding: 12px 20px; font-weight: 600; color: #0f172a;">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                <td style="padding: 12px 20px; text-align: center; font-weight: 700; color: #2563eb;">{{ $item->quantity }}</td>
                                <td style="padding: 12px 20px; text-align: right;">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                                <td style="padding: 12px 20px; text-align: right; font-weight: 700; color: #0f172a;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 20px; text-align: center; color: #94a3b8;">Tidak ada rincian item barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>