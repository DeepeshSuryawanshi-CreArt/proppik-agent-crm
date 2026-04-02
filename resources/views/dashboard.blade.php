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

    <!-- Reports Section -->
    @permission('view reports')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Recent Reports</h5>
                        @permission('generate reports')
                            <a href="#" class="btn btn-sm btn-primary">+ New Report</a>
                        @endpermission
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->reports()->exists())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Bill No.</th>
                                            <th>Package</th>
                                            <th>Amount</th>
                                            <th>Payment Type</th>
                                            <th>GST No.</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->reports()->latest()->take(5)->get() as $report)
                                            <tr>
                                                <td><strong>{{ $report->bill }}</strong></td>
                                                <td>{{ $report->package }}</td>
                                                <td>₹ {{ number_format($report->amount, 2) }}</td>
                                                <td>{{ $report->payment_type }}</td>
                                                <td><small>{{ $report->gst_no }}</small></td>
                                                <td>{{ $report->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">No reports yet.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endpermission
</x-app-layout>
