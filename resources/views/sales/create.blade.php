<x-app-layout>
    <!-- jQuery & Select2 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Kustomisasi tampilan Select2 agar sejajar dengan input form */
        .select2-container--default .select2-selection--single {
            height: 40px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 6px !important;
            padding: 5px 8px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px !important;
            color: #1f2937 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kasir Penjualan / Multi-Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div style="margin-bottom: 16px; padding: 12px; background-color: #fee2e2; color: #b91c1c; border-radius: 6px; font-weight: bold;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form id="checkoutForm" action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <h3 style="font-weight: bold; font-size: 18px; color: #1f2937;">🛒 Keranjang Belanja</h3>
                            <button type="button" id="add-row-btn" style="background-color: #2563eb; color: white; padding: 8px 14px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer;">
                                + Tambah Produk
                            </button>
                        </div>
                        
                        <!-- List Item Keranjang -->
                        <div id="product-list" style="display: flex; flex-direction: column; gap: 12px;">
                            <!-- Baris Default Pertama -->
                            <div class="item-row" style="display: grid; grid-template-columns: 3fr 1fr 1fr 40px; gap: 12px; align-items: end; background: #f9fafb; padding: 12px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                <div>
                                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 4px;">Pilih Produk</label>
                                    <select name="items[0][product_id]" class="product-select" style="width: 100%;" required>
                                        <option value="" data-price="0">-- Pilih / Ketik Produk --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock }}">
                                                {{ $product->name }} (Stok: {{ $product->stock }}) - Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 4px;">Jumlah (Qty)</label>
                                    <input type="number" name="items[0][quantity]" class="qty-input" min="1" value="1" oninput="calculateTotal()" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px;" required>
                                </div>
                                <div>
                                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 4px;">Subtotal</label>
                                    <div class="subtotal-display" style="padding: 8px; font-weight: bold; color: #16a34a;">Rp 0</div>
                                </div>
                                <div>
                                    <button type="button" class="remove-row-btn" onclick="removeRow(this)" style="background-color: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: bold; display: none;">✕</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Belanja Ringkasan Ala Shopee -->
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 16px; font-weight: bold; color: #166534;">Total Biaya Belanja:</span>
                        <span id="grand-total" style="font-size: 24px; font-weight: 900; color: #15803d;">Rp 0</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 16px;">
                        <button type="button" onclick="showModal()" style="background-color: #16a34a; color: white; padding: 12px 24px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer; font-size: 16px;">
                            Checkout Belanja
                        </button>
                        <a href="{{ route('sales.index') }}" style="color: #4b5563; text-decoration: underline;">Batal</a>
                    </div>

                    <!-- Pop-Up Modal Validasi/Konfirmasi Checkout -->
                    <div id="confirmModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 50;">
                        <div style="background: white; padding: 24px; border-radius: 12px; max-width: 450px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                            <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 12px; color: #1f2937;">🔍 Konfirmasi Pesanan</h3>
                            <p style="color: #4b5563; font-size: 14px; margin-bottom: 16px;">Apakah seluruh barang belanjaan dan jumlahnya sudah sesuai?</p>
                            
                            <div style="background: #f9fafb; padding: 12px; border-radius: 6px; font-size: 14px; margin-bottom: 20px;">
                                Total Yang Harus Dibayar: <strong id="modalTotal" style="color: #16a34a; font-size: 16px;">Rp 0</strong>
                            </div>

                            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                <button type="button" onclick="closeModal()" style="background: #e5e7eb; color: #374151; padding: 8px 16px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer;">Cek Lagi</button>
                                <button type="submit" style="background: #16a34a; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer;">Ya, Proses & Cetak Struk</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 1;

        // Inisialisasi Select2 pada elemen tertentu
        function initSelect2(element) {
            $(element).select2({
                placeholder: "-- Pilih / Ketik Produk --",
                allowClear: true
            }).on('change', function () {
                calculateTotal();
            });
        }

        $(document).ready(function() {
            // Aktifkan Select2 di baris pertama saat halaman selesai dimuat
            initSelect2('.product-select');
        });

        function calculateTotal() {
            let grandTotal = 0;
            const rows = document.querySelectorAll('.item-row');
            
            rows.forEach(row => {
                const select = row.querySelector('.product-select');
                const qtyInput = row.querySelector('.qty-input');
                const subtotalDisplay = row.querySelector('.subtotal-display');
                
                const selectedOption = select.options[select.selectedIndex];
                const price = parseFloat(selectedOption ? selectedOption.getAttribute('data-price') : 0) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                
                const subtotal = price * qty;
                subtotalDisplay.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
                grandTotal += subtotal;
            });

            document.getElementById('grand-total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            document.getElementById('modalTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        document.getElementById('add-row-btn').addEventListener('click', function() {
            const container = document.getElementById('product-list');
            const firstRow = container.querySelector('.item-row');
            
            // Hancurkan sementara instance Select2 agar proses clone tidak berantakan
            $(firstRow).find('.product-select').select2('destroy');

            const newRow = firstRow.cloneNode(true);
            
            // Re-inisialisasi Select2 pada baris pertama
            initSelect2($(firstRow).find('.product-select'));

            // Hapus elemen sisa kontainer Select2 pada baris kloningan
            $(newRow).find('.select2-container').remove();

            const selectEl = newRow.querySelector('.product-select');
            selectEl.name = 'items[' + itemIndex + '][product_id]';
            selectEl.value = '';
            
            const inputEl = newRow.querySelector('.qty-input');
            inputEl.name = 'items[' + itemIndex + '][quantity]';
            inputEl.value = 1;

            newRow.querySelector('.subtotal-display').innerText = 'Rp 0';

            container.appendChild(newRow);
            
            // Inisialisasi Select2 pada baris baru
            initSelect2($(newRow).find('.product-select'));

            itemIndex++;
            updateRemoveButtons();
            calculateTotal();
        });

        function removeRow(button) {
            const row = button.closest('.item-row');
            $(row).find('.product-select').select2('destroy');
            row.remove();
            updateRemoveButtons();
            calculateTotal();
        }

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.item-row');
            rows.forEach(row => {
                const btn = row.querySelector('.remove-row-btn');
                btn.style.display = rows.length > 1 ? 'block' : 'none';
            });
        }

        function showModal() {
            let valid = true;
            document.querySelectorAll('.product-select').forEach(sel => {
                if(!sel.value) valid = false;
            });

            if(!valid) {
                alert('Silakan pilih produk terlebih dahulu!');
                return;
            }

            document.getElementById('confirmModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }
    </script>
</x-app-layout>