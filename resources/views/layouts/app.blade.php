<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DSSM')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #212529;
        }

        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar Base Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1050;
            background-color: var(--sidebar-bg);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Desktop Behavior (Large Screens) */
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0); /* Always show */
            }
            .main-content {
                margin-left: var(--sidebar-width);
            }
            .sidebar-toggle-btn {
                display: none; /* Hide toggle on desktop */
            }
        }

        /* Mobile Behavior (Small/Medium Screens) */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%); /* Hide by default */
            }
            .sidebar.show {
                transform: translateX(0); /* Slide in */
            }
            .main-content {
                margin-left: 0;
            }
            
            /* The darkened background when sidebar is open */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }

        /* Sidebar UI Tweaks */
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover:not(.bg-primary) {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 0.375rem;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
            border-radius: 0.375rem;
        }
    </style>
    @stack('styles')
</head>

<body>

    @auth
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <nav class="sidebar shadow-lg p-3" id="sidebar">
            <div class="d-flex justify-content-between align-items-center py-3 border-bottom border-secondary mb-3">
                <div class="text-center w-100">
                    <h4 class="mb-0 fw-bold text-white">DSSM</h4>
                    <small class="text-white-50">Daily Sales & Stock-In</small>
                </div>
                <button type="button" class="btn-close btn-close-white d-lg-none" id="sidebarClose"></button>
            </div>

            <ul class="nav flex-column gap-1 custom-scrollbar" style="overflow-y: auto; flex: 1;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mt-3 mb-1 px-3">
                    <span class="text-uppercase text-white-50 small fw-bold" style="font-size: 0.7rem;">Inventory</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                        <i class="bi bi-truck me-2"></i> Suppliers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('stock-in.*') ? 'active' : '' }}" href="{{ route('stock-in.index') }}">
                        <i class="bi bi-box-seam me-2"></i> Bales and Items
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                        <i class="bi bi-clipboard-data me-2"></i> Inventory Tracking
                    </a>
                </li>

                <li class="nav-item mt-3 mb-1 px-3">
                    <span class="text-uppercase text-white-50 small fw-bold" style="font-size: 0.7rem;">Sales</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                        <i class="bi bi-cart me-2"></i> Transactions
                    </a>
                </li>

                <li class="nav-item mt-3 mb-1 px-3">
                    <span class="text-uppercase text-white-50 small fw-bold" style="font-size: 0.7rem;">Operations</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-tags me-2"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('payment_methods.*') ? 'active' : '' }}" href="{{ route('payment_methods.index') }}">
                        <i class="bi bi-wallet2 me-2"></i> Payment Methods
                    </a>
                </li>
            </ul>

            <div class="mt-auto pt-3 border-top border-secondary">
                <div class="d-flex align-items-center text-white mb-3 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                    <i class="bi bi-person-circle fs-3 me-2 text-primary"></i>
                    <div class="lh-sm">
                        <span class="d-block fw-bold" style="font-size: 0.85rem;">{{ auth()->user()->name }}</span>
                        <small class="text-white-50" style="font-size: 0.75rem;">{{ auth()->user()->employee->position ?? 'Staff' }}</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    @endauth

    <div class="@auth main-content @endauth">
        @auth
            <nav class="navbar navbar-light bg-white shadow-sm border-bottom px-4 d-lg-none">
                <div class="container-fluid px-0">
                    <button class="btn btn-light border" type="button" id="sidebarToggle">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <span class="navbar-brand mb-0 h1 fw-bold ms-3">DSSM</span>
                    <div class="ms-auto"></div>
                </div>
            </nav>
        @endauth

        <main class="p-3 p-md-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');
            const closeBtn = document.getElementById('sidebarClose');

            function handleSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', handleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', handleSidebar);
            if (overlay) overlay.addEventListener('click', handleSidebar);
        });
    </script>
    
    @stack('scripts')
</body>

</html>