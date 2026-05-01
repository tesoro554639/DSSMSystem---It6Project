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

        .sidebar .nav-link:hover:not(.bg-primary) {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
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

<body class="bg-light">
    @auth
        <nav class="sidebar bg-dark text-white p-3 d-flex flex-column shadow-lg">
            <div class="text-center py-3 border-bottom border-secondary mb-3">
                <h4 class="mb-0 fw-bold">DSSM</h4>
                <small class="text-white-50">Daily Sales & Stock-In</small>
            </div>

            <ul class="nav flex-column gap-1">
                <!-- Main -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'bg-primary rounded' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <!-- Inventory Group -->
                <li class="nav-item mt-3 mb-1 px-3">
                    <span class="text-uppercase text-white-50 small fw-bold tracking-wide"
                        style="font-size: 0.75rem;">Inventory</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('suppliers.*') ? 'bg-primary rounded' : '' }}"
                        href="{{ route('suppliers.index') }}">
                        <i class="bi bi-truck me-2"></i> Suppliers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('stock-in.*') ? 'bg-primary rounded' : '' }}"
                        href="{{ route('stock-in.index') }}">
                        <i class="bi bi-box-seam me-2"></i> Bales and Items
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('inventory.*') ? 'bg-primary rounded' : '' }}"
                        href="{{ route('inventory.index') }}">
                        <i class="bi bi-clipboard-data me-2"></i> Inventory Tracking
                    </a>
                </li>


                <!-- Sales Group -->
                <li class="nav-item mt-3 mb-1 px-3">
                    <span class="text-uppercase text-white-50 small fw-bold tracking-wide" style="font-size: 0.75rem;">Sales
                        & Checkout</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('sales.*') ? 'bg-primary rounded' : '' }}"
                        href="{{ route('sales.index') }}">
                        <i class="bi bi-cart me-2"></i> Transactions
                    </a>
                </li>
                <!-- NEW PAYMENT METHODS TAB -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('payment_methods.*') ? 'bg-primary rounded' : '' }}"
                        href="{{ route('payment_methods.index') }}">
                        <i class="bi bi-wallet2 me-2"></i> Payment Methods
                    </a>
                </li>

                <!-- Analytics Group -->
                <li class="nav-item mt-3 mb-1 px-3">
                    <span class="text-uppercase text-white-50 small fw-bold tracking-wide"
                        style="font-size: 0.75rem;">Analytics</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('reports.*') ? 'bg-primary rounded' : '' }}"
                        href="{{ route('reports.daily-sales') }}">
                        <i class="bi bi-graph-up me-2"></i> Sales Reports
                    </a>
                </li>
            </ul>

            <div class="mt-auto pt-3 border-top border-secondary">
                <div class="d-flex align-items-center text-white mb-3 p-2 rounded bg-dark border border-secondary"
                    style="background-color: rgba(255,255,255,0.05) !important;">
                    <div class="flex-shrink-0">
                        <i class="bi bi-person-circle fs-3 me-2 text-primary"></i>
                    </div>

                    <div class="lh-sm">
                        <span class="d-block fw-bold" style="font-size: 0.9rem;">
                            {{ auth()->user()->name }}
                        </span>
                        <small class="text-white-50">
                            {{ auth()->user()->employee->position ?? 'Staff' }}
                        </small>
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

    <div class="@auth main-content @endif">
        @auth
            <nav class="navbar navbar-light bg-white shadow-sm border-bottom px-4 d-md-none mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light me-3 border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#sidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <h5 class="mb-0 fw-bold">DSSM</h5>
                </div>
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