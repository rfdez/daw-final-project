<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('users.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return back()->with('status', 'Datos actualizados correctamente.');
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed|different:old_password',
        ]);

        $validator->after(function ($validator) {
            if (!Hash::check(request('old_password'), auth()->user()->password)) {
                $validator->errors()->add('old_password', 'La antigua contraseña no coincide con la introducida.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user->fill([
            'password' => Hash::make($request->password),
        ])->save();

        return back()->with('status', 'Contraseña actualizada correctamente.');
    }

    public function changeAvatar(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|file|image',
        ]);

        $validator->after(function ($validator) {
            if (!request()->hasFile('avatar') || !request()->file('avatar')->isValid()) {
                $validator->errors()->add('avatar', 'No es posible establecer el nuevo avatar.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $path = $request->file('avatar')->storeAs(
            'avatars',
            $user->id . '.jpg',
            'public'
        );

        $user->avatar = $path;

        $user->save();

        return back()->with('status', 'Avatar actualizado correctamente.');
    }
}
