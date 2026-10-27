<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuangan & Laba Rugi') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #f8fafc; min-height: 100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter Tanggal -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6 border border-gray-100 no-print">
                <form method="GET" action="{{ route('reports.finance') }}" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px;">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px;">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
                    </div>
                    <button type="submit" style="background: #059669; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                        🔍 Filter Laporan
                    </button>
                    <button type="button" onclick="window.print()" style="background: #2563eb; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; margin-left: auto;">
                        🖨️ Cetak Laporan
                    </button>
                </form>
            </div>

            <!-- Kartu Ringkasan Keuangan -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
                
                <!-- Pemasukan -->
                <div style="background: #ffffff; padding: 24px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    <div style="font-size: 13px; font-weight: 700; color: #059669; text-transform: uppercase; letter-spacing: 0.5px;">Total Pemasukan (Penjualan)</div>
                    <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 8px;">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Pendapatan kotor dari kasir</div>
                </div>

                <!-- Pengeluaran -->
                <div style="background: #ffffff; padding: 24px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    <div style="font-size: 13px; font-weight: 700; color: #dc2626; text-transform: uppercase; letter-spacing: 0.5px;">Total Pengeluaran (Barang Masuk)</div>
                    <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 8px;">
                        Rp {{ number_format($totalPurchases, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Pembelian stok ke supplier</div>
                </div>

                <!-- Estimasi Laba / Rugi -->
                <div style="background: {{ $estimatedProfit >= 0 ? '#ecfdf5' : '#fef2f2' }}; padding: 24px; border-radius: 16px; border: 1px solid {{ $estimatedProfit >= 0 ? '#a7f3d0' : '#fecaca' }};">
                    <div style="font-size: 13px; font-weight: 700; color: {{ $estimatedProfit >= 0 ? '#047857' : '#b91c1c' }}; text-transform: uppercase; letter-spacing: 0.5px;">
                        Estimasi Laba / Rugi Bersih
                    </div>
                    <div style="font-size: 28px; font-weight: 800; color: {{ $estimatedProfit >= 0 ? '#065f46' : '#991b1b' }}; margin-top: 8px;">
                        Rp {{ number_format($estimatedProfit, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 12px; color: {{ $estimatedProfit >= 0 ? '#047857' : '#b91c1c' }}; margin-top: 4px;">
                        {{ $estimatedProfit >= 0 ? 'Surplus / Profit' : 'Defisit / Defisit modal' }}
                    </div>
                </div>

            </div>

            <!-- Rincian Buku Kas Ringkas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Ringkasan Arus Kas Toko</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="background-color: #f1f5f9; text-align: left; color: #475569;">
                            <th style="padding: 12px; border-radius: 8px 0 0 8px;">Jenis Transaksi</th>
                            <th style="padding: 12px;">Keterangan</th>
                            <th style="padding: 12px; text-align: right; border-radius: 0 8px 8px 0;">Jumlah Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px; font-weight: 700; color: #059669;">[+] Pemasukan</td>
                            <td style="padding: 12px; color: #64748b;">Penjualan Sembako (Kasir)</td>
                            <td style="padding: 12px; text-align: right; font-weight: 700; color: #059669;">+ Rp {{ number_format($totalSales, 0, ',', '.') }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px; font-weight: 700; color: #dc2626;">[-] Pengeluaran</td>
                            <td style="padding: 12px; color: #64748b;">Pembelian Stok (Barang Masuk)</td>
                            <td style="padding: 12px; text-align: right; font-weight: 700; color: #dc2626;">- Rp {{ number_format($totalPurchases, 0, ',', '.') }}</td>
                        </tr>
                        <tr style="background-color: #f8fafc; font-weight: 800;">
                            <td colspan="2" style="padding: 14px; color: #0f172a;">TOTAL ESTIMASI LABA / RUGI BERSIH</td>
                            <td style="padding: 14px; text-align: right; color: {{ $estimatedProfit >= 0 ? '#059669' : '#dc2626' }}; font-size: 16px;">
                                Rp {{ number_format($estimatedProfit, 0, ',', '.') }}
                            </td>
                        </tr>
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