<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Debugbar;

class GroupController extends Controller
{
    public function index(User $user)
    {
        $groups = $user->groups->reject(function ($group, $key) {
            return $group->name === 'Todos los Sensores';
        });

        return view('users.groups', [
            'groups' => $groups,
        ]);
    }

    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'description' => 'required|string',
        ]);

        $validator->after(function ($validator) {
            if (request()->name === 'Todos los Sensores') {
                $validator->errors()->add('name', 'Este nombre esta reservado para el grupo por defecto.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator->fails());
        }

        $defaultGroup = $user->groups()->where('name', 'Todos los Sensores')->first();

        if (!$defaultGroup) {
            $defaultGroup = Group::create([
                'name' => 'Todos los Sensores',
                'description' => 'Aquí puedes visualizar todos tus dispositivos.'
            ]);

            $user->groups()->attach($defaultGroup->id, ['owner' => true]);
        }

        $group = new Group;

        $group->name = $request->name;
        $group->description = $request->description;

        $group->save();

        $user->groups()->attach($group->id, ['owner' => true]);

        return back()->with('status', 'Grupo creado correctamente.');
    }

    public function destroy(Group $group)
    {
        if (!$group) {
            abort(404);
        }

        if ($group->name === 'Todos los Sensores') {
            return back()->withErrors(['group' => 'No es posible borrar el grupo que contiene todos tus dispositivos.']);
        }

        if ($group->devices()->count() > 0) {

            return back()->withErrors(['devices' => 'No es posible borrar un grupo con dispositivos.']);
        }

        $group->delete();

        return back()->with('status', 'Grupo eliminado correctamente.');
    }
}
