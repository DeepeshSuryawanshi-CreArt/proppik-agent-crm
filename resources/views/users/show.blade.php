<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">{{ $user->firstname }} {{ $user->lastname }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Personal Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Full Name:</dt>
                        <dd class="col-sm-8">{{ $user->firstname }} {{ $user->lastname }}</dd>

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <span class="badge bg-success ms-2">Verified</span>
                            @else
                                <span class="badge bg-warning ms-2">Not Verified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Mobile:</dt>
                        <dd class="col-sm-8">
                            {{ $user->mobile }}
                            @if($user->mobile_verify_at)
                                <span class="badge bg-success ms-2">Verified</span>
                            @else
                                <span class="badge bg-warning ms-2">Not Verified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Country:</dt>
                        <dd class="col-sm-8">
                            @if($user->country)
                                {{ $user->country->name }} ({{ $user->country->dial_code }})
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Status:</dt>
                        <dd class="col-sm-8">
                            @if($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Business Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Business Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Company:</dt>
                        <dd class="col-sm-8">{{ $user->company_name ?? '-' }}</dd>

                        <dt class="col-sm-4">Package:</dt>
                        <dd class="col-sm-8">
                            @if($user->package)
                                <span class="badge bg-info">{{ $user->package }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Amount:</dt>
                        <dd class="col-sm-8">{{ $user->amount ? '₹ ' . number_format($user->amount, 2) : '-' }}</dd>

                        <dt class="col-sm-4">Payment Type:</dt>
                        <dd class="col-sm-8">{{ $user->payment_type ?? '-' }}</dd>

                        <dt class="col-sm-4">Address:</dt>
                        <dd class="col-sm-8">{{ $user->address ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Roles & Permissions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Roles</h5>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary text-capitalize">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <span class="text-muted">No roles assigned</span>
                    @endif
                </div>
            </div>

            <!-- Account Details -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Account Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Created At:</dt>
                        <dd class="col-sm-8">{{ $user->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-4">Updated At:</dt>
                        <dd class="col-sm-8">{{ $user->updated_at->format('M d, Y H:i') }}</dd>

                        @if($user->deleted_at)
                            <dt class="col-sm-4">Deleted At:</dt>
                            <dd class="col-sm-8">{{ $user->deleted_at->format('M d, Y H:i') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Delete Button -->
            <div class="mt-4">
                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
