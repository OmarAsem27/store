<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::paginate();
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admins.create', [
            'roles' => Role::all(),
            'admin' => new Admin()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array'
        ]);
        $admin = Admin::create($request->all());
        $admin->roles()->attach($request->roles);

        return redirect()->route('dashboard.admins.index')->with('success', 'Admin Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        $admin_roles = $admin->roles()->pluck('id')->toArray();
        return view('dashboard.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array'
        ]);
        $admin->update($request->all());
        $admin->roles()->sync($request->roles);
        return redirect()->route('dashboard.admins.index')->with('success', 'Admin Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('dashboard.admins.index')->with('success', 'Admin Deleted Successfully!');
    }
}
