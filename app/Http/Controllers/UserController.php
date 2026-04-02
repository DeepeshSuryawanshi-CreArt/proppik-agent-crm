<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function index()
    {
        $users = User::with('country')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $countries = Country::all();
        return view('users.create', compact('countries'));
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
            'mobile' => 'required|string|unique:users,mobile',
            'password' => 'required|string|min:8|confirmed',
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

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        // Assign default role
        $user->assignRole('viewer');

        return redirect()->route('users.show', $user)->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $countries = Country::all();
        return view('users.edit', compact('user', 'countries'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function ownEdit(User $user)
    {
        $countries = Country::all();
        return view('users.edit', compact('user', 'countries'));
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

        return redirect()->route('users.show', $user)->with('success', 'User updated successfully!');
    }

    /**
     * Delete the specified user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
