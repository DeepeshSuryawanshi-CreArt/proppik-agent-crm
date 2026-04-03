<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_roles')->only(['index', 'show']);
        $this->middleware('permission:create_roles')->only(['create', 'store']);
        $this->middleware('permission:edit_roles')->only(['edit', 'update', 'toggleBlock']);
        $this->middleware('permission:delete_roles')->only(['destroy']);
    }
    /**
     * Display a listing of roles.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with('permissions', 'users')->select('roles.*');

            return DataTables::of($roles)
                ->addColumn('permissions_count', function ($role) {
                    $count = $role->permissions->count();
                    return '<span class="badge bg-info">' . $count . '</span>';
                })
                ->addColumn('users_count', function ($role) {
                    $count = $role->users()->count();
                    return '<span class="badge bg-secondary">' . $count . '</span>';
                })
                ->addColumn('actions', function ($role) {
                    $canEdit = auth()->user()->can('edit roles');
                    $canDelete = auth()->user()->can('delete roles');
                    return view('admin.roles.partials.actions', compact('role'))->render();
                })
                ->rawColumns(['permissions_count', 'users_count', 'actions'])
                ->make(true);
        }
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        
        // Group permissions by their prefix (e.g., "view users", "create users" → "Users")
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            // Extract the module name from permission (e.g., "users" from "view users")
            $parts = explode('_', $permission->name);
            if (count($parts) >= 2) {
                $moduleName = implode(' ', array_slice($parts, 1));
                return ucfirst($moduleName);
            }
            return 'Other';
        })->sortKeys();

        return view('admin.roles.create', compact('permissions', 'groupedPermissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
            'description' => $validated['description'] ?? null,
        ]);

        if (!empty($validated['permissions'])) {
            $permissions = Permission::whereIn('name', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        
        // Group permissions by their prefix (e.g., "view users", "create users" → "Users")
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            // Extract the module name from permission (e.g., "users" from "view users")
            $parts = explode('_', $permission->name);
            if (count($parts) >= 2) {
                $moduleName = implode(' ', array_slice($parts, 1));
                return ucfirst($moduleName);
            }
            return 'Other';
        })->sortKeys();

        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'groupedPermissions', 'rolePermissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
            'is_blocked' => 'nullable|boolean',
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Update permissions
        if (isset($validated['permissions'])) {
            $permissions = Permission::whereIn('name', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Toggle role blocked status.
     */
    public function toggleBlock(Role $role)
    {
        // Check if role is system role
        if (in_array($role->name, ['admin', 'super-admin'])) {
            return redirect()->route('admin.roles.index')->with('error', 'Cannot block system roles!');
        }

        // For now, we'll use a meta field approach
        $isBlocked = $role->is_blocked ?? false;
        $role->update(['is_blocked' => !$isBlocked]);

        return redirect()->route('admin.roles.index')->with('success', 'Role status updated!');
    }

    /**
     * Delete the specified role.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of system roles
        if (in_array($role->name, ['admin', 'super-admin', 'user'])) {
            return redirect()->route('admin.roles.index')->with('error', 'Cannot delete system roles!');
        }

        try {
            $role->delete();
            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->with('error', 'Cannot delete role. It may be in use by users.');
        }
    }
}
