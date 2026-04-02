<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Reports</h2>
            <div class="d-flex gap-2">
                @permission('export reports')
                    <form action="{{ route('reports.export') }}" method="GET" class="d-inline">
                        @foreach(request()->query() as $key => $value)
                            @if($key !== '_token' && !is_array($value))
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                        </button>
                    </form>
                @endpermission
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    @permission('view reports')
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-left-primary shadow-sm">
                    <div class="card-body">
                        <div class="text-primary fw-bold text-uppercase mb-2">Total Reports</div>
                        <div class="h3 mb-0">{{ $statistics['totalReports'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-left-success shadow-sm">
                    <div class="card-body">
                        <div class="text-success fw-bold text-uppercase mb-2">Total Amount</div>
                        <div class="h3 mb-0">₹{{ number_format($statistics['totalAmount'] ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-left-warning shadow-sm">
                    <div class="card-body">
                        <div class="text-warning fw-bold text-uppercase mb-2">This Month</div>
                        <div class="h3 mb-0">{{ $statistics['thisMonthReports'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-left-info shadow-sm">
                    <div class="card-body">
                        <div class="text-info fw-bold text-uppercase mb-2">Net Banking</div>
                        <div class="h3 mb-0">{{ $statistics['pendingPayments'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endpermission

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-funnel"></i> Filters & Search
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search person name or company..." value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="user_filter" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(request('user_filter') == $user->id)>
                                {{ $user->company_name ?? $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="payment_type" class="form-select">
                        <option value="">All Payment Types</option>
                        <option value="cash" @selected(request('payment_type') == 'cash')>Cash</option>
                        <option value="upi" @selected(request('payment_type') == 'upi')>UPI</option>
                        <option value="net_banking" @selected(request('payment_type') == 'net_banking')>Net Banking</option>
                        <option value="card" @selected(request('payment_type') == 'card')>Card</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="date" name="from_date" class="form-control" placeholder="From Date" value="{{ request('from_date') }}">
                </div>

                <div class="col-md-3">
                    <input type="date" name="to_date" class="form-control" placeholder="To Date" value="{{ request('to_date') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-bold">All Reports</h5>
        </div>
        <div class="card-body p-0">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Person Name</th>
                                <th>User/Company</th>
                                <th>Amount</th>
                                <th>Payment Type</th>
                                <th>Bill #</th>
                                <th>GST No</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td class="fw-bold">{{ $report->person_name ?? 'N/A' }}</td>
                                    <td>
                                        <small>
                                            {{ $report->user->company_name ?? $report->user->email }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong class="text-success">₹{{ number_format($report->amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $report->payment_type)) }}</span>
                                    </td>
                                    <td>
                                        <code>{{ $report->bill ?? 'N/A' }}</code>
                                    </td>
                                    <td>
                                        <small>{{ $report->gst_no ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $report->created_at->format('M d, Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('reports.show', $report) }}" class="btn btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @permission('delete reports')
                                                <form action="{{ route('reports.destroy', $report) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this report?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-light">
                    {{ $reports->links() }}
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                    <p class="mt-2">No reports found</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
