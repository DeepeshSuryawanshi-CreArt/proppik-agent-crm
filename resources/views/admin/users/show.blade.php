@extends('admin.layouts.vertical', ['title' => 'User Details', 'subTitle' => 'System'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                <div>
                    <nav aria-label="breadcrumb" class="mb-0">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user->fullname }}</li>
                        </ol>
                    </nav>
                    <h3 class="mb-0">{{ $user->fullname }}</h3>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <x-admin.back-button :fallback="route('admin.users.index')" :classes="['btn', 'btn-soft-secondary']" :merge="false" icon="ri-arrow-go-back-line" />
                    @can('edit users')
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary"><i class="ri-edit-line me-1"></i> Edit</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card panel-card border-primary border-top" data-panel-card>
                <div class="card-header d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <h4 class="card-title mb-1">User Information</h4>
                    <p class="text-muted mb-0">Profile and contact details</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>First Name:</strong> {{ $user->firstname }}</div>
                        <div class="col-md-6"><strong>Last Name:</strong> {{ $user->lastname }}</div>
                        <div class="col-md-6"><strong>Email:</strong> {{ $user->email }}</div>
                        <div class="col-md-6"><strong>Mobile:</strong> {{ $user->mobile }}</div>
                        <div class="col-md-6"><strong>Country:</strong> {{ optional($user->country)->name ?? '-' }}</div>
                        <div class="col-md-6"><strong>Active:</strong> {{ $user->is_active ? 'Yes' : 'No' }}</div>
                        <div class="col-md-12"><strong>Address:</strong> {{ $user->address ?? '-' }}</div>
                        <div class="col-md-12"><strong>Roles:</strong> 
                            @forelse($user->roles as $role)
                                <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                            @empty
                                <span>-</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card panel-card border-info border-top" data-panel-card>
                <div class="card-header">
                    <h4 class="card-title mb-1">Meta</h4>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Registered At:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</p>
                    <p class="mb-1"><strong>Last Updated:</strong> {{ $user->updated_at->format('Y-m-d H:i') }}</p>
                    <p class="mb-1"><strong>Email Verified:</strong> {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d') : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
