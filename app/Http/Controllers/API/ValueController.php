<?php

namespace App\Http\Controllers\API;

use App\Device;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValueController extends Controller
{
    public function store(Device $device, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $values = $device->values()->create([
            'temperature' => $request->temperature,
            'humidity' => $request->humidity
        ]);

        if ($device->rules()->count() > 0) {
            $temperature = $device->rules()->where('type', 'temperature')->first();
            if ($temperature) {
                if ($request->temperature < $temperature->min) {
                    //crear alerta de temperatura minima
                    $device->alerts()->create([
                        'type' => $temperature->type,
                        'name' => 'Temperatura mínima',
                        'message' => 'La temperatura detectada es menor a la establecida en las reglas del sensor. El valor detectado de la temperatura fué ' . $request->temperature . ' ºC, mientras que la temperatura mínima estaba establecida en ' . $temperature->min . ' ºC.'
                    ]);
                }

                if ($request->temperature > $temperature->max) {
                    //crear alerta de temperatura maxima superada
                    $device->alerts()->create([
                        'type' => $temperature->type,
                        'name' => 'Temperatura máxima',
                        'message' => 'La temperatura detectada es mayor a la establecida en las reglas del sensor. El valor detectado de la temperatura fué ' . $request->temperature . ' ºC, mientras que la temperatura máxima estaba establecida en ' . $temperature->max . ' ºC.'
                    ]);
                }
            }

            $humidity = $device->rules()->where('type', 'humidity')->first();
            if ($humidity) {
                if ($request->humidity < $humidity->min) {
                    //Crear alerta de humedad minima
                    $device->alerts()->create([
                        'type' => $humidity->type,
                        'name' => 'Humedad mínima',
                        'message' => 'La humedad detectada es menor a la establecida en las reglas del sensor. El valor detectado de la humedad fué ' . $request->humidity . ' %, mientras que la humedad mínima estaba establecida en ' . $humidity->min . ' %.'
                    ]);
                }

                if ($request->humidity > $humidity->max) {
                    //crear alerta de humedad maxima superada
                    $device->alerts()->create([
                        'type' => $humidity->type,
                        'name' => 'Humedad máxima',
                        'message' => 'La humedad detectada es mayor a la establecida en las reglas del sensor. El valor detectado de la humedad fué ' . $request->humidity . ' %, mientras que la humedad mínima estaba establecida en ' . $humidity->max . ' %.'
                    ]);
                }
            }

            return response()->json(['message' => 'Valores insertados con posibles alertas generadas.'], 201);
        }

        return response()->json(['message' => 'Valores insertados correctamente.', 'Values' => $values], 201);
    }
}
