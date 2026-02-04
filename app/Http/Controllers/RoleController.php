<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index()
    {
        $users = User::all();

        $roles = Role::all();

        return view('roles.index', compact('users', 'roles'));
    }

    public function create()
    {

        $permissionsGrouped = Permission::all()->groupBy(function($perm) {
            return explode('_', $perm->name)[0];
        });

        return view('roles.create', compact('permissionsGrouped'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($request->permissions) {

            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }



    public function edit($id)
    {
        $role = Role::findById($id);

        // Toutes les permissions, groupées par type (Create, View, Edit, etc.)
        $permissionsGrouped = Permission::all()->groupBy(function($perm) {
            $parts = explode('_', $perm->name);
            return ucfirst($parts[0] ?? 'Other'); // ex: create_employee -> Create
        });

        return view('roles.edit', compact('role', 'permissionsGrouped'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findById($id);

        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);


        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }
    public function destroy(Role $role)
    {

    }
}
