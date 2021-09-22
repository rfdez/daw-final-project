@extends('layouts.app')

@section('title', 'Login')

@section('content')

@include('includes.navbar')

<div class="wrapper wrapper-full-page ">
    <div class="full-page login-page section-image" filter-color="black"
        style="background-image: url('{{ asset('assets/img/invernadero.jpg') }}">
        <div class="content">
            <div class="container">
                <div class="col-md-4 ml-auto mr-auto">
                    <form class="form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="card card-login card-plain">
                            <div class="card-header ">
                                <div class="logo-container">
                                    <img src="{{ asset('assets/img/logo500.png') }}" alt="">
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="input-group no-border form-control-lg">
                                    <span class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons ui-1_email-85"></i>
                                        </div>
                                    </span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" placeholder="Email..."
                                        autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input-group no-border form-control-lg">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons objects_key-25"></i>
                                        </div>
                                    </div>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Password...">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="custom-control custom-switch mt-4 ml-2">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Mantener sesión iniciada</label>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <input type="submit" value="Iniciar Sesión"
                                    class="btn btn-primary btn-round btn-lg btn-block mb-3">
                                <div class="pull-left">
                                    <h6><a href="{{ route('register') }}" class="link footer-link">Crear Cuenta</a>
                                    </h6>
                                </div>
                                <div class="pull-right">
                                    <h6><a href="{{ route('password.request') }}" class="link footer-link">¿Has olvidado
                                            tu contraseña?</a></h6>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('includes.footer')

    </div>
</div>

@endsection
