<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:view_permissions')->only(['index']);
        $this->middleware('permission:create_permissions')->only(['create', 'store']);
        $this->middleware('permission:edit_permissions')->only(['edit', 'update']);
        $this->middleware('permission:delete_permissions')->only(['destroy']);
    }

    /**
     * Display a listing of permissions.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::with('roles')->select('permissions.*');

            return DataTables::of($permissions)
                ->addColumn('roles_count_badge', function ($permission) {
                    $count = $permission->roles->count();
                    $badgeClass = $count > 0 ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge ' . $badgeClass . '">' . $count . '</span>';
                })
                ->addColumn('actions', function ($permission) {
                    return view('admin.permissions.partials.actions', compact('permission'))->render();
                })
                ->rawColumns(['roles_count_badge', 'actions'])
                ->make(true);
        }

        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created permission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:255',
        ]);

        Permission::create($validated);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully!');
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:255',
        ]);

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully!');
    }

    /**
     * Delete the specified permission.
     */
    public function destroy(Request $request, Permission $permission)
    {
        $force = $request->input('force', false);

        if (!$force && $permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')->with('permission_delete_warning', [
                'permission_name' => $permission->name,
                'role_count' => $permission->roles()->count(),
                'permission_id' => $permission->id,
            ]);
        }

        try {
            $permission->delete();
            return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.permissions.index')->with('error', 'Cannot delete permission. It may be in use.');
        }
    }
}
