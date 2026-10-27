<x-app-layout>
    <div style="background: white; padding: 20px 32px; border-bottom: 1px solid #e5e7eb;">
        <h2 style="font-size: 24px; font-weight: 800; color: #1f2937; margin: 0;">Edit Supplier</h2>
    </div>

    <div style="padding: 28px 32px;">
        <div style="max-width: 600px; margin: 0 auto; background: white; padding: 28px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 18px;">
                @csrf
                @method('PUT')

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">Nama Supplier / Distributor *</label>
                    <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">No. Telepon / HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $supplier->email) }}" style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">Alamat Kantor / Gudang</label>
                    <textarea name="address" rows="3" style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;">{{ old('address', $supplier->address) }}</textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
                    <a href="{{ route('suppliers.index') }}" style="text-decoration: none; color: #6b7280; font-size: 14px; padding: 10px 18px; font-weight: 600;">
                        Batal
                    </a>
                    <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 14px; border: none; cursor: pointer;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>