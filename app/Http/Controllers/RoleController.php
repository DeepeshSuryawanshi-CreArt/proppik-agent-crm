<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
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
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
            'description' => $validated['description'] ?? null,
        ]);

        if (!empty($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.show', $role)->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
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
            'permissions.*' => 'exists:permissions,id',
            'is_blocked' => 'nullable|boolean',
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Update permissions
        if (isset($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.show', $role)->with('success', 'Role updated successfully!');
    }

    /**
     * Toggle role blocked status.
     */
    public function toggleBlock(Role $role)
    {
        // Check if role is system role
        if (in_array($role->name, ['admin', 'super-admin'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot block system roles!');
        }

        // For now, we'll use a meta field approach
        $isBlocked = $role->is_blocked ?? false;
        $role->update(['is_blocked' => !$isBlocked]);

        return redirect()->route('roles.index')->with('success', 'Role status updated!');
    }

    /**
     * Delete the specified role.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of system roles
        if (in_array($role->name, ['admin', 'super-admin', 'user'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete system roles!');
        }

        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role. It may be in use by users.');
        }
    }
}
