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
            --sidebar-width: 250px;
        }
        body {
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @auth
        <nav class="sidebar bg-dark text-white p-3">
            <div class="text-center py-3 border-bottom border-secondary mb-3">
                <h4 class="mb-0 fw-bold">DSSM</h4>
                <small class="text-muted">Daily Sales & Stock-In</small>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'bg-primary rounded' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('stock-in.*') ? 'bg-primary rounded' : '' }}" href="{{ route('stock-in.index') }}">
                        <i class="bi bi-box-seam me-2"></i> Stock-In
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('sales.*') ? 'bg-primary rounded' : '' }}" href="{{ route('sales.index') }}">
                        <i class="bi bi-cart me-2"></i> Sales
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('inventory.*') ? 'bg-primary rounded' : '' }}" href="{{ route('inventory.index') }}">
                        <i class="bi bi-clipboard-data me-2"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('reports.*') ? 'bg-primary rounded' : '' }}" href="{{ route('reports.daily-sales') }}">
                        <i class="bi bi-graph-up me-2"></i> Reports
                    </a>
                </li>
            </ul>
            <div class="mt-auto pt-3 border-top border-secondary">
                <div class="d-flex align-items-center text-white mb-3">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <small class="d-block">{{ auth()->user()->name }}</small>
                        <small class="text-muted">{{ auth()->user()->position ?? 'Employee' }}</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    @endauth

    <div class="@auth main-content @endif">
        @auth
            <nav class="navbar navbar-light bg-white shadow-sm border-bottom px-4 d-md-none">
                <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                    <i class="bi bi-list"></i>
                </button>
            </nav>
        @endauth

        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>