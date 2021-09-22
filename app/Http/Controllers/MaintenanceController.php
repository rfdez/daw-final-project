<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MaintenanceController extends Controller
{
    public function show(Group $group)
    {
        return view('maintenance.show', [
            'group' => $group
        ]);
    }

    public function create(Group $group)
    {
        return view('maintenance.create', [
            'group' => $group
        ]);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $group = Group::find($request->group);
        $user = User::where('email', $request->email)->first();

        if (!$group) {
            return back()->withErrors(['not found' => 'Grupo no encontrado']);
        }

        if (!$user) {
            return back()->withErrors(['not found' => 'Usuario no encontrado']);
        }

        if (!$user->hasRole('maintenance')) {
            return back()->withErrors(['not found' => 'El usuario especificado no es usuario de mantenimiento.']);
        }

        if ($group->users->contains($user)) {
            return back()->withErrors(['Error' => 'El usuario de mantenimiento ya esta en este grupo.']);
        }

        $user->groups()->attach($group->id, ['owner' => false]);

        return redirect()->route('my.groups', ['user' => auth()->user()->id])->with('status', 'Usuario de mantenimiento añadido correctamente.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $group = Group::find($request->group);

        if (!$group) {
            return back()->withErrors(['not found' => 'Grupo no encontrado']);
        }

        $maintenance = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => 'avatars/placeholder.jpg',
            'password' => Hash::make($request->password),
        ]);

        $maintenance->assignRole('maintenance');

        $maintenance->groups()->attach($group->id, ['owner' => false]);

        return redirect()->route('my.groups', ['user' => auth()->user()->id])->with('status', 'Usuario de mantenimiento creado y añadido correctamente.');
    }

    public function delete(Group $group, User $user)
    {
        if (!$group->users->contains($user)) {
            return back()->withErrors(['Error' => 'El usuario no pertenece a este grupo.']);
        }

        $group->users()->detach($user->id);

        return back()->with('status', 'Usuario de mantenimiento eliminado del grupo.');
    }
}
