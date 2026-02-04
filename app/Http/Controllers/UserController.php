<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }





    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $role = Role::findOrFail($request->role);
        $user->assignRole($role);

        return redirect()->route('users.index')->with('success', 'User created with role.');
    }




    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'nullable|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('roles.index')->with('success', 'User updated successfully');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function search(Request $request)
    {
        $query = $request->search;
        $users = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->get();

        $html = '';
        foreach ($users as $user) {
            $html .= '<tr>
                <td></td>
                <td>'.$user->name.'</td>
                <td>'.$user->email.'</td>
                <td>'.($user->role ?? 'User').'</td>
                <td>'.$user->created_at->format('d/m/Y').'</td>
                <td class="text-center">
                    <div class="d-inline-flex gap-1">
                        <a href="'.route('users.show', $user->id).'" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <a href="'.route('users.edit', $user->id).'" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i></a>
                        <form action="'.route('users.destroy', $user->id).'" method="POST" class="d-inline">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure?\');"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>';
        }

        return $html;
    }

    public function editPermissions(User $user)
    {
        $permissions = \Spatie\Permission\Models\Permission::all();


        $permissionsGrouped = $permissions->groupBy(function ($perm) {
            return explode('_', $perm->name)[0];
        });

        return view('users.edit-permissions', compact('user', 'permissionsGrouped'));
    }

    /**
     * Met à jour les permissions de l'utilisateur
     */
    public function updatePermissions(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'sometimes|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);


        $permissions = $request->input('permissions', []);


        $user->syncPermissions($permissions);

        return redirect()->route('roles.index')
        ->with('success', 'Permissions updated successfully.');
    }


}
