@extends('layouts.app')

@section('title', 'Reglas')

@section('content')

<div class="wrapper">

    @include('includes.sidebar')

    <div class="main-panel">

        @include('includes.navdash')

        <div class="content">

            @include('includes.error')
            @include('includes.success')

            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-dark text-white">
                        <img class="card-img" src="{{ asset('assets/img/cardimg-black.jpg') }}" alt="Card image">
                        <div class="card-img-overlay">
                            <h4 class="card-title">Reglas de {{ $device->name }}</h4>
                            <p class="text-justify">
                                Aquí puedes establecer las reglas que debe seguir el sensor, puedes establecer
                                libremente un valor mínimo y un valor máximo para cada valor recibido por el sensor.
                            </p>
                            <a href="{{ url()->previous() }}" class="text-decoration-none text-reset">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mx-auto">
                    <div class="card card-plain card-subcategories">
                        <div class="card-header ">
                        </div>
                        <div class="card-body ">
                            <ul class="nav nav-pills nav-pills-success nav-pills-icons justify-content-center"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
                                        <i class="now-ui-icons media-2_sound-wave"></i>
                                        Temperatura
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#link8" role="tablist">
                                        <i class="now-ui-icons media-2_sound-wave"></i>
                                        Humedad
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content tab-space tab-subcategories">
                                <div class="tab-pane active" id="link7">
                                    En este apartado podrás imponer una regla de temperatura al sensor, este creará una
                                    alerta al recibir un valor por debajo del mínimo o por encima del máximo.
                                    <br>
                                    Podrás establecer un mínimo y un maxímo, creando así un rango de valores que
                                    deberían ser el correcto para el clima ambiental deseado.
                                    <br><br>
                                    @if ($device->rules()->firstWhere('type', 'temperature'))
                                    Actualmente la temperatura mínima establecida es: <span
                                        class="badge badge-success">{{$device->rules()->firstWhere('type', 'temperature')->min}}
                                        ºC</span> y la máxima es: <span
                                        class="badge badge-danger">{{$device->rules()->firstWhere('type', 'temperature')->max}}
                                        ºC</span>.

                                    <br><br>

                                    <form action="{{ route('devices.add-rule', ['device' => $device->id]) }}"
                                        method="POST">
                                        @csrf

                                        <input type="hidden" name="type" value="temperature">

                                        La temperatura mínima será <input type="number" name="mintemp"
                                            class="form-control d-inline-block w-auto"
                                            placeholder="Temperatura Mínima..."
                                            value="{{ $device->rules()->firstWhere('type', 'temperature')->min }}"> ºC,
                                        la temperatura máxima será <input type="number" name="maxtemp"
                                            class="form-control d-inline-block w-auto"
                                            placeholder="Temperatura Máxima..."
                                            value="{{ $device->rules()->firstWhere('type', 'temperature')->max }}"> ºC.

                                        <br>

                                        <button type="submit"
                                            class="btn btn-primary btn-sm btn-round">Actualizar</button>
                                        ó <a href="{{ route('rule.delete', ['rule' => $device->rules()->firstWhere('type', 'temperature')->id]) }}"
                                            class="btn btn-danger btn-sm btn-round">Borrar Regla</a>

                                        <br>

                                        <div class="stats">
                                            <i class="now-ui-icons arrows-1_refresh-69"></i>
                                            {{ $device->rules()->firstWhere('type', 'temperature')->updated_at->format('d/m/Y H:i:s') }}
                                        </div>

                                    </form>
                                    @else
                                    <form action="{{ route('devices.add-rule', ['device' => $device->id]) }}"
                                        method="POST">
                                        @csrf

                                        <input type="hidden" name="type" value="temperature">

                                        La temperatura mínima será <input type="number" name="mintemp"
                                            class="form-control d-inline-block w-auto"
                                            placeholder="Temperatura Mínima..."> ºC, la temperatura máxima será <input
                                            type="number" name="maxtemp" class="form-control d-inline-block w-auto"
                                            placeholder="Temperatura Máxima..."> ºC.

                                        <br>

                                        <button type="submit"
                                            class="btn btn-primary btn-sm btn-round">Establecer</button>

                                    </form>
                                    @endif
                                </div>
                                <div class="tab-pane" id="link8">
                                    En este apartado podrás imponer una regla de humedad al sensor, este creará una
                                    alerta al recibir un valor por debajo del mínimo o por encima del máximo.
                                    <br>
                                    Podrás establecer un mínimo y un maxímo o ambos, creando así un rango.
                                    <br><br>
                                    @if ($device->rules()->firstWhere('type', 'humidity'))
                                    Actualmente el porcentaje de humedad mínimo establecido es: <span
                                        class="badge badge-success">{{$device->rules()->firstWhere('type', 'humidity')->min}}
                                        %</span> y el máximo es: <span
                                        class="badge badge-danger">{{$device->rules()->firstWhere('type', 'humidity')->max}}
                                        %</span>.

                                    <form action="{{ route('devices.add-rule', ['device' => $device->id]) }}"
                                        method="POST">
                                        @csrf

                                        <input type="hidden" name="type" value="humidity">

                                        La humedad mínima será <input type="number" name="minhum"
                                            class="form-control d-inline-block w-auto" placeholder="Humedad Mínima..."
                                            value="{{$device->rules()->firstWhere('type', 'humidity')->min}}">
                                        %, la humedad máxima será <input type="number" name="maxhum"
                                            class="form-control d-inline-block w-auto" placeholder="Humedad Máxima..."
                                            value="{{$device->rules()->firstWhere('type', 'humidity')->max}}">
                                        %.

                                        <br>

                                        <button type="submit"
                                            class="btn btn-primary btn-sm btn-round">Actualizar</button>
                                        ó <a href="{{ route('rule.delete', ['rule' => $device->rules()->firstWhere('type', 'humidity')->id]) }}"
                                            class="btn btn-danger btn-sm btn-round">Borrar Regla</a>

                                        <br>

                                        <div class="stats">
                                            <i class="now-ui-icons arrows-1_refresh-69"></i>
                                            {{ $device->rules()->firstWhere('type', 'humidity')->updated_at->format('d/m/Y H:i:s') }}
                                        </div>

                                    </form>
                                    @else
                                    <form action="{{ route('devices.add-rule', ['device' => $device->id]) }}"
                                        method="POST">
                                        @csrf

                                        <input type="hidden" name="type" value="humidity">

                                        La humedad mínima será <input type="number" name="minhum"
                                            class="form-control d-inline-block w-auto" placeholder="Humedad Mínima...">
                                        %, la humedad máxima será <input type="number" name="maxhum"
                                            class="form-control d-inline-block w-auto" placeholder="Humedad Máxima...">
                                        %.

                                        <br>

                                        <button type="submit"
                                            class="btn btn-primary btn-sm btn-round">Establecer</button>

                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @include('includes.footer')

    </div>
</div>

@endsection

@push('scripts')
<script>
    const ps = new PerfectScrollbar('.sidebar-wrapper');
    const ps2 = new PerfectScrollbar('.main-panel');
</script>
@endpush