<x-app-layout>
    <!-- Header Topbar -->
    <div style="background: #ffffff; padding: 18px 32px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 20;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">Dashboard Overview</h2>
            <p style="font-size: 13px; color: #64748b; margin: 2px 0 0 0; font-weight: 500;">Hari ini: {{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        
        <!-- Info Profil User Login -->
        <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 6px 14px; border-radius: 30px; border: 1px solid #e2e8f0;">
            <div style="width: 32px; height: 32px; background: #059669; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div style="text-align: left;">
                <div style="font-weight: 700; font-size: 13px; color: #0f172a; line-height: 1.2;">{{ auth()->user()->name }}</div>
                <div style="font-size: 11px; color: #059669; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                    Role: {{ auth()->user()->role ?? 'Staff Kasir' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div style="padding: 28px 32px; background-color: #f8fafc; min-height: calc(100vh - 80px);">
        <div style="max-width: 1280px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Banner Ucapan Selamat Datang Hijau Matching Sidebar -->
            <div style="background: linear-gradient(135deg, #163828 0%, #0d2319 100%); border-radius: 16px; padding: 24px 28px; color: white; box-shadow: 0 10px 25px -5px rgba(22, 56, 40, 0.25); display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden;">
                <!-- Decorative Circle Glow -->
                <div style="position: absolute; width: 250px; height: 250px; background: rgba(52, 211, 153, 0.1); filter: blur(60px); border-radius: 50%; top: -50px; right: -50px; pointer-events: none;"></div>

                <div style="position: relative; z-index: 2;">
                    <span style="background: rgba(52, 211, 153, 0.18); color: #34d399; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid rgba(52, 211, 153, 0.2);">
                        Selamat Datang
                    </span>
                    <h2 style="font-size: 22px; font-weight: 800; margin: 8px 0 4px 0; letter-spacing: -0.3px;">Halo, {{ auth()->user()->name }} 👋</h2>
                    <p style="margin: 0; font-size: 13px; color: #a7f3d0; opacity: 0.9;">Berikut adalah ringkasan performa dan stok operasional toko Anda hari ini.</p>
                </div>

                <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(8px); padding: 8px 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.12);">
                    <span style="width: 8px; height: 8px; background: #34d399; border-radius: 50%; box-shadow: 0 0 8px #34d399;"></span>
                    <span style="font-size: 12px; font-weight: 700; color: #ffffff; text-transform: capitalize;">
                        Sistem Aktif ({{ auth()->user()->role ?? 'Staff' }})
                    </span>
                </div>
            </div>

            <!-- Cards Summary (4 Kartu Statistik) -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
                
                <!-- 1. Total Produk -->
                <a href="{{ route('products.index') }}" style="background: #ffffff; padding: 22px; border-radius: 16px; border: 1px solid #e2e8f0; border-left: 5px solid #2563eb; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.03)';">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL PRODUK</span>
                        <div style="width: 36px; height: 36px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                            📦
                        </div>
                    </div>
                    <div style="font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 10px;">{{ $totalProducts }}</div>
                </a>

                <!-- 2. Penjualan Hari Ini -->
                <a href="{{ auth()->user()->role === 'admin' ? (Route::has('reports.outgoing') ? route('reports.outgoing') : route('sales.index')) : route('sales.index') }}" style="background: #ffffff; padding: 22px; border-radius: 16px; border: 1px solid #e2e8f0; border-left: 5px solid #059669; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.03)';">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">PENJUALAN HARI INI</span>
                        <div style="width: 36px; height: 36px; background: #ecfdf5; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #059669;">
                            💰
                        </div>
                    </div>
                    <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 10px;">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                </a>

                <!-- 3. Total Transaksi -->
                <a href="{{ route('sales.index') }}" style="background: #ffffff; padding: 22px; border-radius: 16px; border: 1px solid #e2e8f0; border-left: 5px solid #9333ea; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.03)';">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL TRANSAKSI</span>
                        <div style="width: 36px; height: 36px; background: #faf5ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #9333ea;">
                            🛒
                        </div>
                    </div>
                    <div style="font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 10px;">{{ $totalTransactions }}</div>
                </a>

                <!-- 4. Stok Minimum / Kritis -->
                <a href="{{ route('products.index') }}" style="background: #ffffff; padding: 22px; border-radius: 16px; border: 1px solid #e2e8f0; border-left: 5px solid #dc2626; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.03)';">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">STOK KRITIS</span>
                        <div style="width: 36px; height: 36px; background: #fef2f2; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #dc2626;">
                            ⚠️
                        </div>
                    </div>
                    <div style="font-size: 30px; font-weight: 800; color: #dc2626; margin-top: 10px;">{{ $lowStockProducts->count() }} <span style="font-size: 16px; font-weight: 600; color: #64748b;">Item</span></div>
                </a>

            </div>

            <!-- Diagram Grafik Penjualan (7 Hari Terakhir) -->
            <div style="background: #ffffff; padding: 28px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                    <div>
                        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">📉 Omset Penjualan (7 Hari Terakhir)</h3>
                        <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Grafik tren statistik pendapatan harian kasir</p>
                    </div>
                </div>
                <div style="height: 320px; position: relative;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Tabel Peringatan Stok Menipis -->
            @if($lowStockProducts->count() > 0)
            <div style="background: #ffffff; padding: 28px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 18px;">
                    <div style="width: 8px; height: 8px; background: #dc2626; border-radius: 50%;"></div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #dc2626; margin: 0;">⚠️ Peringatan Stok Menipis & Kritis</h3>
                </div>
                
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                        <thead>
                            <tr style="background: #fef2f2; color: #991b1b; border-bottom: 1px solid #fee2e2;">
                                <th style="padding: 12px 16px; border-radius: 10px 0 0 10px; font-weight: 700;">SKU</th>
                                <th style="padding: 12px 16px; font-weight: 700;">Nama Produk</th>
                                <th style="padding: 12px 16px; font-weight: 700;">Sisa Stok</th>
                                <th style="padding: 12px 16px; border-radius: 0 10px 10px 0; font-weight: 700;">Stok Min.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $p)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='transparent';">
                                <td style="padding: 14px 16px; font-family: monospace; font-weight: 700; color: #475569;">{{ $p->sku }}</td>
                                <td style="padding: 14px 16px; font-weight: 700; color: #0f172a;">{{ $p->name }}</td>
                                <td style="padding: 14px 16px;">
                                    <span style="background: #fee2e2; color: #dc2626; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 20px;">
                                        {{ $p->stock }} Item
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; color: #64748b; font-weight: 600;">{{ $p->minimum_stock }} Item</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Script Render Chart -->
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Gradasi Hijau Matching Latar Toko
        const greenGradient = ctx.createLinearGradient(0, 0, 0, 320);
        greenGradient.addColorStop(0, 'rgba(5, 150, 105, 0.25)');
        greenGradient.addColorStop(1, 'rgba(5, 150, 105, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesChartLabels) !!},
                datasets: [{
                    label: 'Omset Penjualan (Rp)',
                    data: {!! json_encode($salesChartData) !!},
                    borderColor: '#059669',
                    backgroundColor: greenGradient,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 3,
                    pointBackgroundColor: '#059669',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Figtree', size: 12 },
                            callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }
                        },
                        grid: { color: '#f1f5f9', borderDash: [4, 4] }
                    },
                    x: {
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Figtree', size: 12 }
                        },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</x-app-layout>