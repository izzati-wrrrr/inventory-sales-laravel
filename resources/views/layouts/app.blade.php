<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TOKO SEMBAKO') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Alpine.js & FontAwesome Icons -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 240px;
            background-color: #0d7a46;
            min-height: 100vh;
            color: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }
        .sidebar-brand i {
            font-size: 26px;
        }
        .sidebar-brand-text {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }
        .sidebar-menu {
            padding: 15px 0;
            flex: 1;
        }
        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            color: #e2e8f0;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
        }
        .menu-item:hover, .menu-item.active {
            background-color: #095832;
            color: #ffffff;
        }
        .menu-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .submenu {
            background-color: #084c2b;
            padding: 4px 0;
        }
        .submenu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px 10px 48px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .submenu-item:hover, .submenu-item.active {
            color: #ffffff;
            font-weight: 700;
        }
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div style="display: flex;">
        
        <!-- SIDEBAR HIJAU TOKO SEMBAKO -->
        <aside class="sidebar">
            <div>
                <div class="sidebar-brand">
                    <i class="fa-solid fa-store"></i>
                    <div class="sidebar-brand-text">
                        TOKO<br>SEMBAKO
                    </div>
                </div>

                <div class="sidebar-menu" x-data="{ 
                    openData: {{ request()->routeIs('products.*', 'categories.*', 'suppliers.*') ? 'true' : 'false' }}, 
                    openTransaksi: {{ request()->routeIs('sales.create', 'purchases.*') ? 'true' : 'false' }}, 
                    openLaporan: {{ request()->routeIs('reports.*') ? 'true' : 'true' }} 
                }">

                    <!-- Dashboard (Akses Semua Role) -->
                    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <div class="menu-item-left">
                            <i class="fa-solid fa-house" style="width: 20px;"></i>
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <!-- Dropdown Data (KHUSUS ADMIN) -->
                    @if(auth()->user()->role === 'admin')
                    <div>
                        <div @click="openData = !openData" class="menu-item">
                            <div class="menu-item-left">
                                <i class="fa-solid fa-box" style="width: 20px;"></i>
                                <span>Data</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs" :style="openData ? 'transform: rotate(90deg)' : ''" style="transition: transform 0.2s;"></i>
                        </div>
                        <div x-show="openData" class="submenu" x-cloak>
                            <a href="{{ route('products.index') }}" class="submenu-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-box-archive" style="font-size: 11px;"></i>
                                <span>Data Barang</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="submenu-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-layer-group" style="font-size: 11px;"></i>
                                <span>Data Kategori</span>
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="submenu-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-truck" style="font-size: 11px;"></i>
                                <span>Data Supplier</span>
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Dropdown Transaksi -->
                    <div>
                        <div @click="openTransaksi = !openTransaksi" class="menu-item">
                            <div class="menu-item-left">
                                <i class="fa-solid fa-cart-shopping" style="width: 20px;"></i>
                                <span>Transaksi</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs" :style="openTransaksi ? 'transform: rotate(90deg)' : ''" style="transition: transform 0.2s;"></i>
                        </div>
                        <div x-show="openTransaksi" class="submenu" x-cloak>
                            <!-- Barang Masuk (KHUSUS ADMIN) -->
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('purchases.index') }}" class="submenu-item {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-cart-arrow-down" style="font-size: 11px;"></i>
                                <span>Barang Masuk</span>
                            </a>
                            @endif

                            <!-- Kasir (AKSES ADMIN & STAFF) -->
                            <a href="{{ route('sales.create') }}" class="submenu-item {{ request()->routeIs('sales.create') ? 'active' : '' }}">
                                <i class="fa-solid fa-cash-register" style="font-size: 11px;"></i>
                                <span>Kasir</span>
                            </a>
                        </div>
                    </div>

                    <!-- Dropdown Laporan (KHUSUS ADMIN) -->
                    @if(auth()->user()->role === 'admin')
                    <div>
                        <div @click="openLaporan = !openLaporan" class="menu-item">
                            <div class="menu-item-left">
                                <i class="fa-solid fa-file-lines" style="width: 20px;"></i>
                                <span>Laporan</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs" :style="openLaporan ? 'transform: rotate(90deg)' : ''" style="transition: transform 0.2s;"></i>
                        </div>
                        <div x-show="openLaporan" class="submenu" x-cloak>
                            <a href="{{ route('reports.stock') }}" class="submenu-item {{ request()->routeIs('reports.stock') ? 'active' : '' }}">
                                <i class="fa-solid fa-boxes-stacked" style="font-size: 11px;"></i>
                                <span>Laporan Stok</span>
                            </a>
                            <a href="{{ route('reports.incoming') }}" class="submenu-item {{ request()->routeIs('reports.incoming') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-import" style="font-size: 11px;"></i>
                                <span>Barang Masuk</span>
                            </a>
                            <a href="{{ route('reports.outgoing') }}" class="submenu-item {{ request()->routeIs('reports.outgoing') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-export" style="font-size: 11px;"></i>
                                <span>Barang Keluar</span>
                            </a>
                            <a href="{{ route('reports.finance') }}" class="submenu-item {{ request()->routeIs('reports.finance') ? 'active' : '' }}">
                                <i class="fa-solid fa-coins" style="font-size: 11px;"></i>
                                <span>Laporan Keuangan</span>
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Tombol Logout -->
            <div style="padding: 15px 0; border-top: 1px solid rgba(255, 255, 255, 0.15);">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="menu-item" style="width: 100%; border: none; background: none; text-align: left;">
                        <div class="menu-item-left">
                            <i class="fa-solid fa-right-from-bracket" style="width: 20px;"></i>
                            <span>Logout</span>
                        </div>
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA HALAMAN -->
        <main class="main-content" style="flex: 1;">
            {{ $slot }}
        </main>
    </div>
</body>
</html>