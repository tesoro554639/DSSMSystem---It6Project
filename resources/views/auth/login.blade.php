<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DSSM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .login-gradient {
            background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
        }
    </style>
</head>

<body class="min-vh-100">
    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">
            <div class="col-md-7 login-gradient text-white p-5 d-flex flex-column justify-content-between">
                <div>
                    <h1 class="display-3 fw-bold">DSSM</h1>
                    <p class="lead">Ukay-ukay Daily Sales and Stock-In Management System</p>
                    <p class="text-white-50">Streamline your thrift shop operations with automated tracking.</p>
                </div>
                <div class="mt-5">
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-graph-up-arrow fs-4 me-3 text-info"></i>
                            <div>
                                <h5>Real-time Sales Tracking</h5>
                                <small class="text-white-50">Monitor transactions and inventory instantly</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-box-seam fs-4 me-3 text-info"></i>
                            <div>
                                <h5>Stock-In Management</h5>
                                <small class="text-white-50">Track bundled purchases and inventory updates</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-cash-stack fs-4 me-3 text-info"></i>
                            <div>
                                <h5>Daily Cash Reconciliation</h5>
                                <small class="text-white-50">Compare sales vs actual cash count</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-white-50 small">
                    <hr> By Tesoro, Luis James and Ambos, Joshua.
                </div>
            </div>

            <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                <div class="card shadow" style="width: 380px;">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-1">Welcome back!</h3>
                        <p class="text-center text-muted mb-4">Sign in to your account to continue</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Employee ID</label>
                                <select id="employee_id" name="employee_id"
                                    class="form-select @error('employee_id') is-invalid @enderror" required>
                                    <option value="">Select your employee ID</option>
                                    @foreach(\App\Models\User::where('is_active', true)->get() as $user)
                                        <option value="{{ $user->employee_id }}" {{ old('employee_id') == $user->employee_id ? 'selected' : '' }}>
                                            {{ $user->employee_id }} - {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                        </form>

                        <div class="alert alert-info mt-4 mb-0">
                            <small>
                                <i class="bi bi-info-circle me-1"></i>
                                Select any employee from the dropdown<br>
                                Password: password123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>