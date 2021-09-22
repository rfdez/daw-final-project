@extends('layouts.app')

@section('title', 'Grupos')

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
                            <h4 class="card-title">Grupos</h4>
                            @can('create-group')
                            <!-- Button trigger modal -->
                            <a href="#groupModal" class="text-decoration-none text-reset" data-toggle="modal">
                                Crear grupo
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="groupModal" tabindex="-1" role="dialog"
                                aria-labelledby="groupModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-dark" id="groupModalLabel">Crear grupo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('groups.create', ['user' => auth()->user()->id]) }}"
                                            method="post" class="form">
                                            @csrf

                                            <div class="modal-body">

                                                <div class="input-group no-border">
                                                    <span class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="now-ui-icons text_caps-small"></i>
                                                        </div>
                                                    </span>
                                                    <input type="text" class="form-control" name="name" required
                                                        placeholder="Name..." autofocus>
                                                </div>

                                                <div class="input-group no-border">
                                                    <span class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="now-ui-icons text_align-left"></i>
                                                        </div>
                                                    </span>

                                                    <textarea name="description" class="form-control" cols="30" rows="5"
                                                        required placeholder="Description..."></textarea>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                    @if ($groups->count() > 0)
                    @foreach ($groups as $group)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title d-inline">
                                {{ $group->name }}
                            </h5>
                            <a data-toggle="collapse" href="{{ '#collapseGroup' . $group->id }}" aria-expanded="false"
                                aria-controls="{{ 'collapseGroup' . $group->id }}" title="Ver sensores">
                                <i class="now-ui-icons travel_info"></i>
                            </a>
                            <p class="text-justify">{{ $group->description }}</p>
                            <div class="toolbar mb-1">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                                @role('admin')
                                <!-- Button trigger modal -->
                                <a href="{{'#deviceModal' . $group->id}}" class="badge badge-info"
                                    data-toggle="modal">Registrar
                                    sensor</a>

                                <!-- Modal -->
                                <div class="modal fade" id="{{'deviceModal' . $group->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="{{'deviceModalLabel' . $group->id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="{{'deviceModalLabel' . $group->id}}">
                                                    Introduce un Número de
                                                    Serie.</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('devices.search') }}" method="post" class="form">
                                                @csrf
                                                <div class="modal-body">

                                                    <input type="hidden" name="groupId" value="{{ $group->id }}">

                                                    <div class="input-group no-border">
                                                        <span class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons tech_mobile"></i>
                                                            </div>
                                                        </span>
                                                        <input type="text" class="form-control" name="serial" required
                                                            placeholder="Serial Number..." autofocus>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('maintenance.show', ['group' => $group->id]) }}"
                                    class="badge badge-primary">Gestionar mantenimiento</a>
                                <a href="{{ route('groups.delete', ['group' => $group->id]) }}"
                                    class="badge badge-danger">Eliminar</a>
                                @endrole
                            </div>
                        </div>
                        <div class="collapse" id="{{ 'collapseGroup' . $group->id }}">
                            <div class="card-body">

                                @if ($group->devices()->count() > 0)
                                <table name="datatable" class="table table-hover table-bordered" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nº Serie</th>
                                            <th>Nombre</th>
                                            <th>Modelo</th>
                                            <th class="text-center">Reglas</th>
                                            <th class="text-center">Alertas</th>
                                            <th class="disabled-sorting text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nº Serie</th>
                                            <th>Nombre</th>
                                            <th>Modelo</th>
                                            <th class="text-center">Reglas</th>
                                            <th class="text-center">Alertas</th>
                                            <th class="disabled-sorting text-right">Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($group->devices as $device)
                                        <tr>
                                            <td>{{ $device->serial }}</td>
                                            <td><a href="{{ route('devices.show', ['device' => $device->id]) }}"
                                                    class="text-decoration-none">{{ $device->name }}</a></td>
                                            <td>{{ $device->model }}</td>
                                            <td class="text-center">{{$device->rules()->count()}}</td>
                                            <td class="text-center">{{$device->alerts()->count()}}</td>
                                            <td class="text-right">
                                                <a href="{{ route('devices.location', ['device' => $device->id]) }}"
                                                    class="btn btn-round btn-success btn-icon btn-sm m-1"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Ver localización"><i
                                                        class="now-ui-icons location_pin"></i></a>
                                                <a href="{{ route('devices.alerts', ['device' => $device->id]) }}"
                                                    class="btn btn-round btn-warning btn-icon btn-sm m-1"
                                                    data-toggle="tooltip" data-placement="top" title="Ver alertas"><i
                                                        class="now-ui-icons ui-1_bell-53"></i></a>
                                                @role('admin')
                                                <a href="{{ route('devices.rules', ['device' => $device->id]) }}"
                                                    class="btn btn-round btn-default btn-icon btn-sm m-1"
                                                    data-toggle="tooltip" data-placement="top" title="Ajustar Reglas"><i
                                                        class="now-ui-icons ui-1_settings-gear-63"></i></a>
                                                <a href="{{ route('devices.delete', ['group' => $group->id, 'device' => $device->id]) }}"
                                                    class="btn btn-round btn-danger btn-icon btn-sm m-1"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Eliminar sensor"><i
                                                        class="now-ui-icons ui-1_simple-remove"></i></a>
                                                @endrole
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <h6 class="text-center">No hay dispositivos en este grupo.</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">No hay grupos para mostrar.</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="text-center">Crea grupos nuevos y registra sensores para empezar a disfrutar de
                                todas las funcionalidades.</h6>
                        </div>
                    </div>
                    @endif
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

    $("[name='datatable']").DataTable({
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
    		sEmptyTable: "Ningún dato disponible en esta tabla =(",
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