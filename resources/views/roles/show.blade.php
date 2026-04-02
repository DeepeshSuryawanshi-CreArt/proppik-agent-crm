<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0 text-capitalize">{{ $role->name }} Role</h2>
            <div class="d-flex gap-2">
                @permission('edit roles')
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                @endpermission
                <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
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
            <!-- Role Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Role Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Role Name:</dt>
                        <dd class="col-sm-8 text-capitalize"><strong>{{ $role->name }}</strong></dd>

                        <dt class="col-sm-4">Total Permissions:</dt>
                        <dd class="col-sm-8">{{ $role->permissions->count() }}</dd>

                        <dt class="col-sm-4">Created At:</dt>
                        <dd class="col-sm-8">{{ $role->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-4">Updated At:</dt>
                        <dd class="col-sm-8">{{ $role->updated_at->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Assigned Permissions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Assigned Permissions</h5>
                </div>
                <div class="card-body">
                    @if($role->permissions->count() > 0)
                        <div class="row">
                            @foreach($role->permissions as $permission)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle text-success"></i>
                                        <code>{{ $permission->name }}</code>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> No permissions assigned to this role
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
