<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Rsix Cell</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Light grey background */
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        .sidebar-brand .icon-box {
            background-color: #1a5ca6;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sidebar-brand h5 {
            margin: 0;
            font-weight: 700;
            color: #111827;
            font-size: 18px;
        }
        
        .sidebar-brand p {
            margin: 0;
            font-size: 11px;
            color: #6b7280;
        }

        .nav-menu {
            flex: 1;
            padding: 20px 15px;
            overflow-y: auto;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #4b5563;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-link i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .nav-link:hover {
            background-color: #f3f4f6;
            color: #1a5ca6;
        }

        .nav-link.active {
            background-color: #1a5ca6;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(26, 92, 166, 0.2);
        }

        .nav-link.active i {
            color: white;
        }

        .sidebar-footer {
            padding: 20px 15px;
            border-top: 1px solid #e5e7eb;
        }

        .sidebar-footer .nav-link {
            color: #4b5563;
        }

        .sidebar-footer .nav-link.text-danger {
            color: #dc2626 !important;
        }
        
        .sidebar-footer .nav-link.text-danger:hover {
            background-color: #fee2e2;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .topbar {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .breadcrumb {
            margin: 0;
            font-size: 14px;
            font-weight: 500;
        }

        .breadcrumb a {
            color: #6b7280;
            text-decoration: none;
        }

        .breadcrumb span {
            color: #111827;
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .search-box input {
            padding-left: 35px;
            border-radius: 20px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            font-size: 13px;
            width: 250px;
            transition: all 0.2s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #1a5ca6;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(26,92,166,0.1);
        }

        .notification-btn {
            background: none;
            border: none;
            color: #4b5563;
            font-size: 18px;
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: 0;
            right: -2px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #e5e7eb;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
            flex: 1;
        }
        
        /* Premium Card Style */
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #f3f4f6;
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
            color: #111827;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="icon-box">
                <i class="fa-solid fa-tower-cell"></i>
            </div>
            <div>
                <h5>Rsix Cell</h5>
                <p>Super Admin</p>
            </div>
        </div>

        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-border-all"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}">
                    <i class="fa-solid fa-shapes"></i> Kategori
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ url('/produk') }}" class="nav-link {{ request()->is('produk*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open"></i> Produk
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('cabang.index') }}" class="nav-link {{ request()->is('cabang*') ? 'active' : '' }}">
                    <i class="fa-solid fa-store"></i> Cabang
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-users"></i> Pengguna
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-layer-group"></i> Stok Semua Cabang
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-regular fa-clock"></i> Shift Kerja
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-receipt"></i> Transaksi
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-chart-column"></i> Laporan
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <a href="#" class="nav-link">
                <i class="fa-regular fa-user-circle"></i> Profil
            </a>
            <!-- Form Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="nav-link text-danger mt-2" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="topbar">
            <div class="breadcrumb">
                <a href="#">Main</a> <i class="fa-solid fa-chevron-right mx-2" style="font-size: 10px; color:#9ca3af;"></i> <span>@yield('title', 'Dashboard')</span>
            </div>

            <div class="topbar-right">
                <button class="notification-btn">
                    <i class="fa-regular fa-bell"></i>
                    <span class="notification-badge"></span>
                </button>

                <div class="user-profile">
                    <!-- Placeholder avatar -->
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=1a5ca6&color=fff" alt="Profile">
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @yield('scripts')
</body>
</html>
