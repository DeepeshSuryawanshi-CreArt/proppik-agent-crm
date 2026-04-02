<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Roles Management</h2>
            @permission('create roles')
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> New Role
                </a>
            @endpermission
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

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-bold">All Roles</h5>
        </div>
        <div class="card-body p-0">
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Users</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <strong class="text-capitalize">{{ $role->name }}</strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $role->permissions->count() }} permission{{ $role->permissions->count() != 1 ? 's' : '' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            @php
                                                $userCount = \DB::table('model_has_roles')
                                                    ->where('role_id', $role->id)
                                                    ->count();
                                            @endphp
                                            {{ $userCount }} user{{ $userCount != 1 ? 's' : '' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ $role->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('roles.show', $role) }}" class="btn btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @permission('edit roles')
                                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endpermission
                                            @permission('delete roles')
                                                @if(!in_array($role->name, ['admin', 'super-admin', 'user']))
                                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this role?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
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
                    {{ $roles->links() }}
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                    <p class="mt-2">No roles found</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
