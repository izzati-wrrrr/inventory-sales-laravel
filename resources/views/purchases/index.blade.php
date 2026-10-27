<x-app-layout>
    <!-- Header Halaman -->
    <div style="background: white; padding: 20px 32px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #1f2937; margin: 0;">Barang Masuk (Pembelian)</h2>
            <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">Catatan riwayat transaksi barang masuk dari supplier</p>
        </div>
        <a href="{{ route('purchases.create') }}" style="background-color: #0d7a46; color: white; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-plus"></i> + Tambah Barang Masuk
        </a>
    </div>

    <div style="padding: 28px 32px;">
        <div style="max-width: 1280px; margin: 0 auto;">
            
            @if(session('success'))
                <div style="background-color: #def7ec; color: #03543f; padding: 14px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 20px; border: 1px solid #bcf0da;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="background: white; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background-color: #f8fafc; color: #475569; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 12px; font-weight: 700;">
                            <th style="padding: 14px 20px; width: 60px;">NO</th>
                            <th style="padding: 14px 20px;">NO. TRANSAKSI</th>
                            <th style="padding: 14px 20px;">SUPPLIER</th>
                            <th style="padding: 14px 20px;">TANGGAL MASUK</th>
                            <th style="padding: 14px 20px;">TOTAL PEMBELIAN</th>
                            <th style="padding: 14px 20px;">STATUS</th>
                            <th style="padding: 14px 20px; text-align: center; width: 180px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $index => $purchase)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 14px 20px; color: #64748b;">{{ $purchases->firstItem() + $index }}</td>
                                <td style="padding: 14px 20px; font-weight: 700; font-family: monospace; color: #0f172a;">{{ $purchase->purchase_number }}</td>
                                <td style="padding: 14px 20px; font-weight: 600; color: #334155;">{{ $purchase->supplier->name ?? '-' }}</td>
                                <td style="padding: 14px 20px; color: #475569;">{{ \Carbon\Carbon::parse($purchase->purchased_at)->translatedFormat('d M Y, H:i') }}</td>
                                <td style="padding: 14px 20px; font-weight: 700; color: #0d7a46;">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                                <td style="padding: 14px 20px;">
                                    <span style="background-color: #def7ec; color: #03543f; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                                        {{ $purchase->status }}
                                    </span>
                                </td>
                                <td style="padding: 14px 20px; text-align: center;">
                                    <div style="display: flex; justify-content: center; gap: 8px;">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('purchases.show', $purchase->id) }}" style="background-color: #2563eb; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; text-decoration: none; font-weight: 600;">
                                            Detail
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus riwayat barang masuk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background-color: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer; font-weight: 600;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 24px; text-align: center; color: #94a3b8;">Belum ada data barang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0;">
                    {{ $purchases->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>