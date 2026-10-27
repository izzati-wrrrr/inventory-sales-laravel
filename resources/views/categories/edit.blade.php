<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                   <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                        <a href="{{ route('products.index') }}" style="text-decoration: none; color: #6b7280; font-size: 14px; padding: 8px 16px;">
                            Batal
                        </a>
                        <button type="submit" style="background-color: #2563eb; color: #ffffff; padding: 8px 18px; border-radius: 8px; font-weight: 600; font-size: 14px; border: none; cursor: pointer;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>