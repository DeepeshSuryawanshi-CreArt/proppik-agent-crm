<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_users')->only(['index', 'show']);
        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:edit_users')->only(['edit', 'update']);
        $this->middleware('permission:edit_own_users')->only(['ownEdit', 'update']);
        $this->middleware('permission:delete_users')->only(['destroy']);
    }
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('country', 'roles')->select('users.*');

            return DataTables::of($users)
                ->addColumn('name', function ($user) {
                    return $user->firstname . ' ' . $user->lastname;
                })
                ->addColumn('country', function ($user) {
                    return $user->country ? $user->country->name : '';
                })
                ->addColumn('roles_badges', function ($user) {
                    return $user->roles->map(function ($role) {
                        return '<span class="badge bg-primary">' . $role->name . '</span>';
                    })->implode(' ');
                })
                ->addColumn('actions', function ($user) {
                    return view('admin.users.partials.actions', compact('user'))->render();
                })
                ->rawColumns(['roles_badges', 'actions'])
                ->make(true);
        }

        $canEdit = auth()->user()->can('edit_users');
        $canDelete = auth()->user()->can('delete_users');

        return view('admin.users.index', compact('canEdit', 'canDelete'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $countries = Country::all();
        $roles = Role::all();
        $defaultCountryId = $countries->firstWhere('code', 'IN')->id ?? null;
        return view('admin.users.create', compact('countries','defaultCountryId','roles'));
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'base_mobile' => 'required|string|min:6|max:15|unique:users,base_mobile',
            'password' => 'required|string|min:8|confirmed',
            'country_id' => 'required|exists:countries,id',
            'is_active' => 'nullable|boolean',
        ]);

        // Get country details
        $country = Country::find($validated['country_id']);
        $validated['country_code'] = $country->code;
        $validated['dial_code'] = $country->dial_code;
        $validated['mobile'] = $country->dial_code . $validated['base_mobile'];

        // Ensure mobile is unique
        $request->validate([
            'mobile' => 'unique:users,mobile',
        ], [], ['mobile' => 'Mobile']);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        // Assign roles if provided
        if ($request->has('roles') && is_array($request->roles)) {
            $user->syncRoles($request->roles);
        } else {
            // Assign default role
            $user->assignRole('viewer');
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $countries = Country::all();
        return view('admin.users.edit', compact('user', 'countries'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function ownEdit(User $user)
    {
        $countries = Country::all();
        return view('admin.users.edit', compact('user', 'countries'));
    }

    /**
     * Update the specified user in database.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|string|unique:users,mobile,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'country_id' => 'nullable|exists:countries,id',
            'country_code' => 'nullable|string|max:2',
            'dial_code' => 'nullable|string|max:10',
            'company_name' => 'nullable|string|max:255',
            'package' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'payment_type' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validated['password'] ?? null) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Delete the specified user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
