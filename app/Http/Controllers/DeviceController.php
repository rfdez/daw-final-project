<?php

namespace App\Http\Controllers;

use App\Device;
use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class DeviceController extends Controller
{
    public function index(User $user)
    {
        $group = $user->groups()->where('name', 'Todos los Sensores')->first();

        return view('devices.index', [
            'devices' => $group->devices
        ]);
    }

    public function destroy(Group $group, Device $device)
    {
        if ($group->name === 'Todos los Sensores') {
            return back()->withErrors(['group' => 'No puedes eliminar los sensores de este grupo.']);
        }

        if ($device->rules()->count() > 0) {
            return back()->withErrors(['rules' => 'Borra las alertas asociadas al sensor antes de eliminarlo.']);
        }

        $group->devices()->detach($device->id);

        return back()->with('status', 'Sensor eliminado del grupo correctamente.');
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user = auth()->user();
        $device = Device::where('serial', $request->serial)->first();
        $group = Group::find($request->groupId);
        $defaultGroup = $user->groups()->where('name', 'Todos los Sensores')->first();

        if ($group->devices->contains($device->id)) {
            return back()->withErrors(['device' => 'El dispositivo ya pertenece al grupo.']);
        }

        if (!$device || !$group || !$defaultGroup) {
            return back()->withErrors(['device' => 'No se ha encontrado un dispositivo con el número de serie especificado.']);
        }

        if ($defaultGroup->devices->contains($device->id)) {
            $device->groups()->attach($group->id);
            return back()->with('status', 'Dispositivo añadido correctamente.');
        }

        $device->name = 'Sensor de ' . auth()->user()->name . ' ' . ($defaultGroup->devices()->count() + 1);
        $device->save();

        if ($defaultGroup->id == $group->id) {
            $device->groups()->attach($group->id);
            return back()->with('status', 'Dispositivo añadido correctamente.');
        }

        $device->groups()->attach([$defaultGroup->id, $group->id]);

        return back()->with('status', 'Dispositivo añadido correctamente.');
    }

    //Ver localización
    public function showLocation(Device $device)
    {
        if ($device->locations()->count() < 1) {
            return back()->withErrors(['device' => 'No se ha encontrado ninguna localización del dispositivo.']);
        }

        $lastLocation = $device->locations->last();

        return view('devices.location', [
            'location' => $lastLocation
        ]);
    }

    public function show(Device $device)
    {
        return view('devices.show', [
            'device' => $device,
            'dates' => $device->values->take(-10)->pluck('created_at')->toArray(),
            'temperatures' => $device->values->take(-10)->pluck('temperature')->toArray(),
            'humidity' => $device->values->take(-10)->pluck('humidity')->toArray()
        ]);
    }
}
