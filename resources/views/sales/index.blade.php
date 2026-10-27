<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                
                @if (session('success'))
                    <div style="margin-bottom: 20px; padding: 12px 16px; background-color: #dcfce7; color: #15803d; border-radius: 8px; font-weight: 500; border-left: 4px solid #16a34a;">
                        {{ session('success') }}
                    </div>
                @endif

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Daftar Transaksi</h3>
                    <a href="{{ route('sales.create') }}" style="background-color: #16a34a; color: #ffffff; font-weight: 600; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        + Transaksi Kasir Baru
                    </a>
                </div>

                <div style="overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: #f3f4f6; border-bottom: 1px solid #e5e7eb; color: #374151; font-size: 14px;">
                                <th style="padding: 14px 16px; font-weight: 600;">No. Faktur</th>
                                <th style="padding: 14px 16px; font-weight: 600;">Kasir / User</th>
                                <th style="padding: 14px 16px; font-weight: 600;">Total Belanja</th>
                                <th style="padding: 14px 16px; font-weight: 600; text-align: center;">Tanggal</th>
                                <th style="padding: 14px 16px; font-weight: 600; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 14px; color: #4b5563;">
                            @forelse ($sales as $sale)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 14px 16px; font-family: monospace; font-weight: 700; color: #4f46e5;">
                                        {{ $sale->sale_number }}
                                    </td>
                                    <td style="padding: 14px 16px; color: #1f2937;">
                                        {{ $sale->user->name ?? 'Kasir' }}
                                    </td>
                                    <td style="padding: 14px 16px; font-weight: 700; color: #111827;">
                                        Rp {{ number_format($sale->total, 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 14px 16px; text-align: center; color: #6b7280; white-space: nowrap;">
                                        {{ \Carbon\Carbon::parse($sale->sold_at)->translatedFormat('d F Y, H:i') }}
                                    </td>
                                    <td style="padding: 14px 16px; text-align: center;">
                                        <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                                            <a href="{{ route('sales.show', $sale->id) }}" style="padding: 6px 12px; background-color: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none;">
                                                Lihat Struk
                                            </a>
                                            
                                            @if(auth()->user()->role === 'admin')
                                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Batal transaksi ini & kembalikan seluruh stok?')" style="margin: 0; display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="padding: 6px 12px; background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                        Batalkan All
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 32px; text-align: center; color: #9ca3af; font-weight: 500;">
                                        Belum ada transaksi penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 24px;">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>