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
                            <h4 class="card-title">Mantenimiento de {{ $group->name }}</h4>
                            <a href="{{ url()->previous() }}" class="text-decoration-none text-reset">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="card card-plain">
                        <div class="card-header">
                            <h4 class="card-title"> Gestión del Personal de Mantenimiento</h4>
                            <a href="{{ route('maintenance.create', ['group' => $group->id]) }}"
                                class="text-decoration-none"> Añadir mantenimiento</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Cargo</th>
                                            <th class="text-center">Eliminar del grupo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group->users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->hasRole('admin'))
                                                Administrador
                                                @else
                                                Mantenimiento
                                                @endif
                                            </td>
                                            <td class="td-actions text-center">
                                                @if ($user->hasRole('admin'))
                                                N/D
                                                @else
                                                <a href="{{ route('maintenance.delete', ['group' => $group->id, 'user' => $user->id]) }}"
                                                    class="btn btn-danger btn-icon btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="Eliminar usuario"><i
                                                        class="now-ui-icons ui-1_simple-remove"></i></a>
                                                @endif
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