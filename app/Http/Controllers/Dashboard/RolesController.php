<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
// use Illuminate\Routing\Controller;
use App\Models\Role;
use App\Models\RoleAbility;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    // use AuthorizesRequests;

    // public function __construct()
    // {
    //     Gate::authorizeResource(Role::class, 'role');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Role::class); // takes the function name of the policy
        $roles = Role::paginate();
        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Role::class); // takes the function name of the policy
        return view('dashboard.roles.create', ['role' => new Role()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Role::class); // takes the function name of the policy
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);
        $role = Role::createWithAbilities($request);

        return redirect()->route('dashboard.roles.index')->with('success', 'Role Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        Gate::authorize('view', $role); // takes the function name of the policy
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('update', $role); // takes the function name of the policy
        $role_abilities = $role->abilities()->pluck('type', 'ability')->toArray();
        return view('dashboard.roles.edit', compact('role', 'role_abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        Gate::authorize('update', $role); // takes the function name of the policy
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);
        $role->updateWithAbilities($request);

        return redirect()->route('dashboard.roles.index')->with('success', 'Role Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        Gate::authorize('update', $role); // takes the function name of the policy
        $role->delete();
        return redirect()->route('dashboard.roles.index')->with('success', 'Role Deleted Successfully!');
    }
}
