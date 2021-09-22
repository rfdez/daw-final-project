@extends('layouts.app')

@section('title', 'Mantenimiento')

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
                        <img class="card-img" src="{{ asset('assets/img/cardimg.jpg') }}" alt="Card image">
                        <div class="card-img-overlay">
                            <h4 class="card-title">Todos los Sensores</h4>
                            <a href="{{ url()->previous() }}" class="text-decoration-none text-reset">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Todos los Sensores</h4>
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>

                            <table id="datatable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nº Serie</th>
                                        <th>Nombre</th>
                                        <th>Modelo</th>
                                        <th class="text-center">Grupos</th>
                                        <th class="text-center">Reglas</th>
                                        <th class="text-center">Alertas</th>
                                        <th class="text-right">Fecha de Registro</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nº Serie</th>
                                        <th>Nombre</th>
                                        <th>Modelo</th>
                                        <th class="text-center">Grupos</th>
                                        <th class="text-center">Reglas</th>
                                        <th class="text-center">Alertas</th>
                                        <th class="text-right">Fecha de Registro</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($devices as $device)
                                    <tr>
                                        <td>{{ $device->serial }}</td>
                                        <td><a href="{{ route('devices.show', ['device' => $device->id]) }}"
                                                class="text-decoration-none">{{ $device->name }}</a></td>
                                        <td>{{ $device->model }}</td>
                                        <td class="text-center">{{$device->groups->count() - 1}}</td>
                                        <td class="text-center">{{$device->rules()->count()}}</td>
                                        <td class="text-center">{{$device->alerts()->count()}}</td>
                                        <td class="text-right">
                                            {{$device->updated_at->format('d/m/Y H:i:s')}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    $("#datatable").DataTable({
    	"pagingType": "full_numbers",
    	"lengthMenu": [
    		[10, 25, 50, -1],
    		[10, 25, 50, "Todos"]
    	],
    	responsive: true,
    	language: {
    		sProcessing: "Procesando...",
    		sLengthMenu: "Mostrar _MENU_ registros",
    		sZeroRecords: "No se encontraron resultados",
    		sEmptyTable: "Ningún dato disponible en esta tabla.",
    		sInfo: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
    		sInfoEmpty: "Mostrando del 0 al 0 de 0 registros",
    		sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    		sInfoPostFix: "",
    		sInfoThousands: ".",
    		sLoadingRecords: "Cargando...",
    		oPaginate: {
    			sFirst: "Primero",
    			sLast: "Último",
    			sNext: "Siguiente",
    			sPrevious: "Anterior"
    		},
    		oAria: {
    			sSortAscending: ": Activar para ordenar la columna de manera ascendente",
    			sSortDescending: ": Activar para ordenar la columna de manera descendente"
    		},
    		buttons: {
    			copy: "Copiar",
    			colvis: "Visibilidad"
    		},
    		search: "_INPUT_",
    		searchPlaceholder: "Buscar sensor",
    	},
    	retrieve: true
    });
</script>
@endpush