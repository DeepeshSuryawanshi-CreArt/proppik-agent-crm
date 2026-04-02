<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                    <p class="lead text-muted mb-4">
                        A modern Laravel application with Bootstrap CSS framework, role-based access control, and comprehensive user management.
                    </p>
                    <div class="d-flex gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Create Account</a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Features</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <strong>Role-Based Access Control</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <strong>User Management System</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <strong>Report Generation</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <strong>Mobile Verification</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <strong>Bootstrap 5 UI</strong>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <strong>Responsive Design</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Credentials -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <h5 class="alert-heading fw-bold">Demo Credentials</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <strong>Admin Account:</strong><br>
                                Email: admin@example.com<br>
                                Password: admin@2026
                            </div>
                            <div class="col-md-4 mb-3">
                                <strong>Dev Account:</strong><br>
                                Email: dev@example.com<br>
                                Password: password
                            </div>
                            <div class="col-md-4">
                                <strong>Viewer Account:</strong><br>
                                Email: viewer@example.com<br>
                                Password: password
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <small>Powered by Laravel & Bootstrap</small>
                </div>
            </div>
        </div>
    </footer>
</body>