<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Dashboard</h2>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary">Welcome, {{ Auth::user()->firstname }}!</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Your Role</small>
                            <h5 class="fw-bold mb-0 text-capitalize">{{ Auth::user()->roles->first()?->name ?? 'user' }}</h5>
                        </div>
                        <i class="bi bi-shield-check text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Email</small>
                            <h6 class="fw-bold mb-0">{{ Auth::user()->email }}</h6>
                        </div>
                        <i class="bi bi-envelope text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Mobile</small>
                            <h6 class="fw-bold mb-0">{{ Auth::user()->mobile }}</h6>
                        </div>
                        <i class="bi bi-telephone text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Account Status</small>
                            <h6 class="fw-bold mb-0">
                                @if(Auth::user()->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </h6>
                        </div>
                        <i class="bi bi-check-circle text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Details & Business Info -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Personal Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Full Name:</dt>
                        <dd class="col-sm-8">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</dd>

                        <dt class="col-sm-4">Country:</dt>
                        <dd class="col-sm-8">
                            @if(Auth::user()->country)
                                {{ Auth::user()->country->name }}
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Dial Code:</dt>
                        <dd class="col-sm-8">{{ Auth::user()->dial_code ?? '-' }}</dd>

                        <dt class="col-sm-4">Email Verified:</dt>
                        <dd class="col-sm-8">
                            @if(Auth::user()->email_verified_at)
                                <span class="badge bg-success">{{ Auth::user()->email_verified_at->format('M d, Y') }}</span>
                            @else
                                <span class="badge bg-warning">Not verified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Mobile Verified:</dt>
                        <dd class="col-sm-8">
                            @if(Auth::user()->mobile_verify_at)
                                <span class="badge bg-success">{{ Auth::user()->mobile_verify_at->format('M d, Y') }}</span>
                            @else
                                <span class="badge bg-warning">Not verified</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Business Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Company:</dt>
                        <dd class="col-sm-8">{{ Auth::user()->company_name ?? '-' }}</dd>

                        <dt class="col-sm-4">Package:</dt>
                        <dd class="col-sm-8">
                            @if(Auth::user()->package)
                                <span class="badge bg-info">{{ Auth::user()->package }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Amount:</dt>
                        <dd class="col-sm-8">{{ Auth::user()->amount ? '₹ ' . number_format(Auth::user()->amount, 2) : '-' }}</dd>

                        <dt class="col-sm-4">Payment Type:</dt>
                        <dd class="col-sm-8">{{ Auth::user()->payment_type ?? '-' }}</dd>

                        <dt class="col-sm-4">Address:</dt>
                        <dd class="col-sm-8">{{ Str::limit(Auth::user()->address, 50) ?? '-' }}</dd>

                        <dt class="col-sm-4">Active Since:</dt>
                        <dd class="col-sm-8">{{ Auth::user()->created_at->format('M d, Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning"></i> Quick Links & Features</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Profile Management -->
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light hover-shadow transition" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="bi bi-person-circle text-primary" style="font-size: 2rem;"></i>
                                        <h6 class="card-title mt-3 mb-2 text-dark fw-bold">My Profile</h6>
                                        <p class="card-text text-muted small">Edit your profile information and settings</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Users Management -->
                        @canany(['view users', 'create users'])
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('users.index') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light hover-shadow transition" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="bi bi-people-fill text-success" style="font-size: 2rem;"></i>
                                        <h6 class="card-title mt-3 mb-2 text-dark fw-bold">Users</h6>
                                        <p class="card-text text-muted small">Manage all users and their permissions</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endcanany

                        <!-- Roles Management -->
                        @canany(['view roles', 'create roles'])
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('roles.index') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light hover-shadow transition" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="bi bi-shield-lock text-warning" style="font-size: 2rem;"></i>
                                        <h6 class="card-title mt-3 mb-2 text-dark fw-bold">Roles</h6>
                                        <p class="card-text text-muted small">Configure user roles and access control</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endcanany

                        <!-- Permissions Management -->
                        @permission('view permissions')
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('permissions.index') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light hover-shadow transition" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="bi bi-key-fill text-info" style="font-size: 2rem;"></i>
                                        <h6 class="card-title mt-3 mb-2 text-dark fw-bold">Permissions</h6>
                                        <p class="card-text text-muted small">Manage system permissions and access rights</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endpermission

                        <!-- Bills Management -->
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('bills.otp-form') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 bg-light hover-shadow transition" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <i class="bi bi-receipt text-secondary" style="font-size: 2rem;"></i>
                                        <h6 class="card-title mt-3 mb-2 text-dark fw-bold">Generate Bills</h6>
                                        <p class="card-text text-muted small">Create and manage bills with OTP verification</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Section -->
    </div>
</x-app-layout>
