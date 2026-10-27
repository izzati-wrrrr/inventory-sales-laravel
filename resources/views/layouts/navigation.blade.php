<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-9 h-9 bg-gradient-to-tr from-indigo-600 to-violet-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">NEXUS<span class="text-indigo-600">POS</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-2">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Dashboard
                    </a>

                    {{-- Khusus Admin --}}
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Kategori
                        </a>
                    @endif

                    {{-- Bisa diakses Admin & Staff Kasir (Daftar Produk / Stok) --}}
                    <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Produk
                    </a>

                    <a href="{{ route('sales.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('sales.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Penjualan
                    </a>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-3 px-3 py-1.5 rounded-full border border-slate-200 hover:border-indigo-300 bg-slate-50/50 hover:bg-white transition-all">
                            <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="text-left text-xs">
                                <p class="font-semibold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-slate-500 text-[10px] capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile Akun
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 hover:bg-rose-50">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>