@extends('admin.layouts.vertical', ['title' => 'Role Details', 'subTitle' => 'System'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                <div>
                    <nav aria-label="breadcrumb" class="mb-0">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
                        </ol>
                    </nav>
                    <h3 class="mb-0">{{ $role->name }}</h3>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <x-admin.back-button :fallback="route('admin.roles.index')" :classes="['btn', 'btn-soft-secondary']" :merge="false" icon="ri-arrow-go-back-line" />
                    @can('edit roles')
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary"><i class="ri-edit-line me-1"></i> Edit</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card panel-card border-primary border-top" data-panel-card>
                <div class="card-header d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <h4 class="card-title mb-1">Role Information</h4>
                    <p class="text-muted mb-0">Basic role details and metadata</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>Role Name:</strong> {{ $role->name }}</div>
                        <div class="col-md-6"><strong>Guard:</strong> {{ $role->guard_name }}</div>
                        <div class="col-md-12"><strong>Total Users:</strong> <span class="badge bg-secondary">{{ $role->users()->count() }}</span></div>
                        <div class="col-md-12"><strong>Total Permissions:</strong> <span class="badge bg-info">{{ $role->permissions->count() }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Permissions Card -->
            <div class="card panel-card border-info border-top" data-panel-card>
                <div class="card-header">
                    <h4 class="card-title mb-1">Assigned Permissions</h4>
                </div>
                <div class="card-body">
                    @if($role->permissions->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($role->permissions as $permission)
                                <span class="badge bg-light text-dark">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No permissions assigned to this role.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card panel-card border-warning border-top" data-panel-card>
                <div class="card-header">
                    <h4 class="card-title mb-1">Meta</h4>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Created At:</strong> {{ $role->created_at->format('Y-m-d H:i') }}</p>
                    <p class="mb-1"><strong>Updated At:</strong> {{ $role->updated_at->format('Y-m-d H:i') }}</p>
                    <p class="mb-0"><strong>ID:</strong> {{ $role->id }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
