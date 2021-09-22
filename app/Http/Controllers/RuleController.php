<?php

namespace App\Http\Controllers;

use App\Device;
use App\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{
    public function index(Device $device)
    {
        return view('rules.create', [
            'device' => $device
        ]);
    }

    public function store(Device $device, Request $request)
    {
        if ($request->type == 'temperature') {
            $validator = Validator::make($request->all(), [
                'mintemp' => 'required|numeric|lt:maxtemp',
                'maxtemp' => 'required|numeric|gt:mintemp'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $rule = $device->rules()->updateOrCreate(
                ['type' => 'temperature'],
                ['min' => $request->mintemp, 'max' => $request->maxtemp]
            );

            $rule->save();
        }

        if ($request->type == 'humidity') {
            $validator = Validator::make($request->all(), [
                'minhum' => 'required|numeric|lt:maxhum',
                'maxhum' => 'required|numeric|gt:minhum'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            $rule = $device->rules()->updateOrCreate(
                ['type' => 'humidity'],
                ['min' => $request->minhum, 'max' => $request->maxhum]
            );

            $rule->save();
        }

        return back()->with('status', 'Reglas establecidas correctamente.');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();

        return back()->with('status', 'Regla eliminada correctamente.');
    }
}
