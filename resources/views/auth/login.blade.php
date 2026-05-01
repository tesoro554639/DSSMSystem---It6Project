<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DSSM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        .login-sidebar {
            background: linear-gradient(135deg, #343a40 0%, #212529 100%);
        }

        .icon-box {
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="bg-light min-vh-100">
    <div class="container-fluid p-0 min-vh-100">
        <div class="row g-0 min-vh-100">

            <!-- Left Branding Column (Hidden on mobile) -->
            <div
                class="col-lg-5 col-md-6 login-sidebar text-white p-5 d-none d-md-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box me-3 border border-secondary shadow-sm">
                            <i class="bi bi-box-seam fs-3 text-primary"></i>
                        </div>
                        <h1 class="display-5 fw-bold mb-0">DSSM</h1>
                    </div>
                    <h3 class="fw-semibold mb-3">Daily Sales and Stock-In Management</h3>
                    <p class="text-white-50" style="font-size: 1.1rem;">Streamline your ukay-ukay operations with
                        automated tracking, seamless checkout, and real-time inventory management.</p>
                </div>

                <div class="text-white-50 small border-top border-secondary pt-3 mt-4">
                    Built by <strong>Ambos, Joshua</strong>.
                </div>
            </div>

            <!-- Right Login Column -->
            <div class="col-lg-7 col-md-6 d-flex align-items-center justify-content-center p-4 p-sm-5">
                <div class="card border-0 shadow-sm rounded-4 w-100" style="max-width: 420px;">
                    <div class="card-body p-4 p-md-5">

                        <!-- Mobile-only logo -->
                        <div class="text-center d-md-none mb-4">
                            <i class="bi bi-box-seam fs-1 text-primary"></i>
                            <h2 class="fw-bold mt-2 text-dark">DSSM</h2>
                        </div>

                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-dark mb-1">Welcome back</h3>
                            <p class="text-muted">Sign in to your account to continue</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="employee_id"
                                    class="form-label fw-semibold text-secondary small text-uppercase">Employee
                                    Account</label>
                                <select id="employee_id" name="employee_id"
                                    class="form-select form-select-lg shadow-sm border-0 bg-light rounded-3 @error('employee_id') is-invalid @enderror"
                                    required>
                                    <option value="">Select your ID...</option>
                                    @foreach(\App\Models\User::where('is_active', true)->get() as $user)
                                        <option value="{{ $user->employee_id }}" {{ old('employee_id') == $user->employee_id ? 'selected' : '' }}>
                                            {{ $user->employee_id }} — {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password"
                                    class="form-label fw-semibold text-secondary small text-uppercase">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg shadow-sm border-0 bg-light rounded-3 @error('password') is-invalid @enderror"
                                    placeholder="Enter your password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm rounded-3 fw-bold mb-4">
                                Sign In <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>

                        <div
                            class="alert alert-primary bg-primary bg-opacity-10 border-start border-primary border-4 text-primary rounded-3 mb-0 d-flex align-items-start shadow-sm">
                            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                            <small>
                                Select any employee from the dropdown.<br>
                                Default password is <code>password123</code>
                            </small>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>