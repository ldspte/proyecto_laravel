<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('assignedTasks')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'salary' => 'nullable|numeric|min:0',
            'role_id' => 'required|numeric',
            'hire_date' => 'required|date'
        ]);

        $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'salary' => $validated['salary'],
        'role_id' => $validated['role_id'],
        'hire_date' => $validated['hire_date'],
    ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all(); 
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,'.$user->id,
            'role_id' => 'required|exists:roles,id',
            'salary' => 'nullable|numeric|min:0',
            'password' => 'nullable|confirmed|min:8',
            'hire_date' => 'nullable|date',
        ];
        $validated = $request->validate($rules);
        // Solo actualizar la contraseña si se proporcionó
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return redirect()->route('users.show', $user->id)
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }
}