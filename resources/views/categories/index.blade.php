<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tombol Tambah Kategori -->
                <div style="margin-bottom: 20px;">
                    <a href="{{ route('categories.create') }}" style="background-color: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                        + Tambah Kategori
                    </a>
                </div>

                <table class="w-full text-left border-collapse" style="width: 100%;">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3" style="padding: 12px;">No</th>
                            <th class="p-3" style="padding: 12px;">Nama Kategori</th>
                            <th class="p-3" style="padding: 12px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $category)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3" style="padding: 12px;">{{ $categories->firstItem() + $index }}</td>
                                <td class="p-3 font-semibold" style="padding: 12px;">{{ $category->name }}</td>
                                <td class="p-3" style="padding: 12px;">
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <a href="{{ route('categories.edit', $category->id) }}" style="color: #4f46e5; font-weight: 600; text-decoration: none;">Edit</a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; font-weight: 600; background: none; border: none; cursor: pointer; padding: 0;">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-gray-500" style="padding: 12px; text-align: center;">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4" style="margin-top: 16px;">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>