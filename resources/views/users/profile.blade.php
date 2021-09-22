@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')

<div class="wrapper">

    @include('includes.sidebar')

    <div class="main-panel">

        @include('includes.navdash')

        <div class="content">

            @include('includes.error')
            @include('includes.success')

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">Editar Perfil</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" class="form" novalidate>
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" name="name" class="form-control" placeholder="Nombre..."
                                                value="{{ $user->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Email..."
                                                value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">Cambiar Contraseña</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.password') }}" method="POST" class="form" novalidate>
                                @csrf

                                <div class="row">
                                    <div class="col-md-8 pr-1">
                                        <div class="form-group">
                                            <label>Old Password</label>
                                            <input type="password" name="old_password" class="form-control"
                                                placeholder="Contraseña Anterior...">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 pr-1">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Nueva Contraseña...">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 pr-1">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Confirmar Contraseña...">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-user">
                        <form action="{{ route('profile.avatar') }}" class="form" method="POST"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="fileinput fileinput-new text-center mx-auto" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail img-circle img-raised">
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail img-circle img-raised">
                                        </div>
                                        <div>
                                            <span class="btn btn-raised btn-round btn-default btn-file">
                                                <span class="fileinput-new">Añadir</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="avatar" /></span>
                                            <br />
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                                <p class="description text-center">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </p>
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