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
                            <h4 class="card-title">Mantenimiento</h4>
                            <a href="{{ url()->previous() }}" class="text-decoration-none text-reset">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Buscar Usuario</h4>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('maintenance.search') }}">
                            @csrf

                            <input type="hidden" name="group" value="{{ $group->id }}">

                            <div class="card-body ">
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Email</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email del usuario de mantenimiento...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <div class="row">
                                    <label class="col-md-3"></label>
                                    <div class="col-md-9">
                                        <button type="submit" class="btn btn-fill btn-primary">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Crear Nuevo Usuario</h4>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('maintenance.store') }}">
                            @csrf

                            <div class="card-body ">

                                <input type="hidden" name="group" value="{{ $group->id }}">

                                <div class="row">
                                    <label class="col-md-3 col-form-label">Nombre</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Nombre del nuevo usuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Email</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Email del nuevo usuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Contraseña</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Contraseña para el nuevo usuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Confirmar Contraseña</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la contraseña">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <div class="row">
                                    <label class="col-md-3"></label>
                                    <div class="col-md-9">
                                        <button type="submit" class="btn btn-fill btn-primary">Crear</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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