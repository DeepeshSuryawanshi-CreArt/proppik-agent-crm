<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Report Details</h2>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <!-- Report Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Report Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Report ID:</dt>
                        <dd class="col-sm-8">#{{ $report->id }}</dd>

                        <dt class="col-sm-4">Person Name:</dt>
                        <dd class="col-sm-8"><strong>{{ $report->person_name ?? 'N/A' }}</strong></dd>

                        <dt class="col-sm-4">Associated User:</dt>
                        <dd class="col-sm-8">
                            <a href="{{ route('users.show', $report->user) }}">
                                {{ $report->user->firstname }} {{ $report->user->lastname }}
                            </a>
                            <small class="d-block text-muted">{{ $report->user->email }}</small>
                        </dd>

                        <dt class="col-sm-4">Company:</dt>
                        <dd class="col-sm-8">{{ $report->user->company_name ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Bill Number:</dt>
                        <dd class="col-sm-8"><code>{{ $report->bill ?? 'N/A' }}</code></dd>
                    </dl>
                </div>
            </div>

            <!-- Financial Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Financial Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Amount:</dt>
                        <dd class="col-sm-8">
                            <strong class="text-success h5">₹{{ number_format($report->amount, 2) }}</strong>
                        </dd>

                        <dt class="col-sm-4">Package:</dt>
                        <dd class="col-sm-8">{{ $report->package ?? '-' }}</dd>

                        <dt class="col-sm-4">Payment Type:</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-info">
                                {{ ucfirst(str_replace('_', ' ', $report->payment_type)) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">GST Number:</dt>
                        <dd class="col-sm-8">{{ $report->gst_no ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Address -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Address Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        {{ $report->address ?? 'No address provided' }}
                    </p>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Timeline & Audit</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Created At:</dt>
                        <dd class="col-sm-8">{{ $report->created_at->format('M d, Y H:i:s') }}</dd>

                        <dt class="col-sm-4">Created By:</dt>
                        <dd class="col-sm-8">
                            @if($report->creator)
                                <a href="{{ route('users.show', $report->creator) }}">
                                    {{ $report->creator->firstname }} {{ $report->creator->lastname }}
                                </a>
                                <small class="d-block text-muted">{{ $report->creator->email }}</small>
                            @else
                                <span class="text-muted">System</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Updated At:</dt>
                        <dd class="col-sm-8">{{ $report->updated_at->format('M d, Y H:i:s') }}</dd>

                        @if($report->deleted_at)
                            <dt class="col-sm-4">Deleted At:</dt>
                            <dd class="col-sm-8" style="color: #cc0000;">{{ $report->deleted_at->format('M d, Y H:i:s') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            @permission('delete reports')
                <div class="card border-danger mt-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0 fw-bold">Danger Zone</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Once you delete this report, there is no going back.</p>
                        <form action="{{ route('reports.destroy', $report) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure? This report will be permanently deleted.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete Report
                            </button>
                        </form>
                    </div>
                </div>
            @endpermission
        </div>
    </div>
</x-app-layout>
