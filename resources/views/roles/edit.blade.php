<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0 text-capitalize">Edit {{ $role->name }} Role</h2>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">Update Role Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="2">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">Permissions</h6>

                        <div class="row">
                            @foreach($permissions->chunk(3) as $permissionChunk)
                                @foreach($permissionChunk as $permission)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                                   id="permission_{{ $permission->id }}" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->id }}"
                                                   @checked(in_array($permission->id, old('permissions', $rolePermissions)))>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                        @error('permissions')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Role
                            </button>
                            <a href="{{ route('roles.show', $role) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @permission('delete roles')
                @if(!in_array($role->name, ['admin', 'super-admin', 'user']))
                    <div class="card border-danger mt-4">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0 fw-bold">Danger Zone</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Once you delete this role, there is no going back. Please be certain.</p>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure? This role will be permanently deleted.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Delete Role
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endpermission
        </div>
    </div>
</x-app-layout>
