<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Permissions Management</h2>
            @permission('create permissions')
                <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> New Permission
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
            <h5 class="mb-0 fw-bold">All Permissions</h5>
        </div>
        <div class="card-body p-0">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Permission Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>
                                        <code>{{ $permission->name }}</code>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $permission->description ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $permission->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        @permission('delete permissions')
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this permission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endpermission
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-light">
                    {{ $permissions->links() }}
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                    <p class="mt-2">No permissions found</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
