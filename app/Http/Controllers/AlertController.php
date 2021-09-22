<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(Device $device)
    {
        if($device->alerts->count() < 1){
            return back()->withErrors(['Error' => 'No hay alertas para mostrar de ' . $device->name . '.']);
        }

        return view('alerts.index', [
            'device' => $device->load('alerts')
        ]);
    }
}
