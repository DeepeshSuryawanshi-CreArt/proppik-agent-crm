<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index()
    {
        $permissions = Permission::paginate(20);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('permissions.create');
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

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully!');
    }

    /**
     * Delete the specified permission.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')->with('error', 'Cannot delete permission. It may be in use.');
        }
    }
}
