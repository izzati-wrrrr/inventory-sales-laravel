<x-app-layout>
    <style>
        @media print {
            .sidebar, .no-print { display: none !important; }
            .main-content { margin-left: 0 !important; width: 100% !important; }
            body { background: white !important; }
        }
    </style>

    <div style="padding: 32px; max-width: 1000px; margin: 0 auto;">
        <h2 style="font-size: 24px; font-weight: 800; color: #1f2937; margin: 0 0 16px 0;">Laporan Barang Keluar (Penjualan)</h2>

        <div class="no-print" style="margin-bottom: 20px;">
            <button onclick="window.print()" style="background-color: #2563eb; color: white; padding: 8px 18px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; font-size: 13px;">
                Cetak
            </button>
        </div>

        <div style="background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background-color: #d1e7dd; color: #0f5132; font-weight: 700; border-bottom: 1px solid #bcd0c7;">
                        <th style="padding: 12px 16px; width: 50px;">No</th>
                        <th style="padding: 12px 16px;">No. Faktur</th>
                        <th style="padding: 12px 16px;">Tanggal Keluar</th>
                        <th style="padding: 12px 16px;">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $index => $sale)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 16px;">{{ $index + 1 }}</td>
                            <td style="padding: 10px 16px; font-family: monospace;">{{ $sale->sale_number }}</td>
                            <td style="padding: 10px 16px;">{{ \Carbon\Carbon::parse($sale->sold_at)->translatedFormat('d M Y H:i') }}</td>
                            <td style="padding: 10px 16px; font-weight: 700;">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>