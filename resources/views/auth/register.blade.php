@extends('layouts.app')

@section('title', 'Registro')

@section('content')

@include('includes.navbar')

<div class="wrapper wrapper-full-page ">
    <div class="full-page register-page section-image" filter-color="black"
        style="background-image: url('{{ asset('assets/img/invernadero.jpg') }}">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 ml-auto">
                        <div class="info-area info-horizontal mt-5">
                            <div class="icon icon-primary">
                                <i class="now-ui-icons media-2_sound-wave"></i>
                            </div>
                            <div class="description">
                                <h5 class="info-title">Monitoring</h5>
                                <p class="description">
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim, asperiores soluta!
                                    Quasi delectus eligendi sequi, quia modi tempora ullam quisquam?
                                </p>
                            </div>
                        </div>
                        <div class="info-area info-horizontal">
                            <div class="icon icon-info">
                                <i class="now-ui-icons users_single-02"></i>
                            </div>
                            <div class="description">
                                <h5 class="info-title">Maintenance</h5>
                                <p class="description">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam error omnis dolores?
                                </p>
                            </div>
                        </div>
                        <div class="info-area info-horizontal">
                            <div class="icon icon-primary">
                                <i class="now-ui-icons ui-1_bell-53"></i>
                            </div>
                            <div class="description">
                                <h5 class="info-title">Custom Alerts</h5>
                                <p class="description">
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus voluptates
                                    dignissimos ratione expedita nisi adipisci? Quaerat neque nesciunt at dolores
                                    tempora delectus ad.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mr-auto">
                        <div class="card card-signup text-center">
                            <div class="card-header ">
                                <h4 class="card-title">Register</h4>
                                <div class="social">
                                    <button class="btn btn-icon btn-round btn-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button class="btn btn-icon btn-round btn-google">
                                        <i class="fab fa-google-plus-g"></i>
                                    </button>
                                    <button class="btn btn-icon btn-round btn-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                    <h5 class="card-description"> or be classical </h5>
                                </div>
                            </div>
                            <form class="form" method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="card-body ">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons users_circle-08"></i>
                                            </div>
                                        </div>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus
                                            placeholder="First Name...">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons ui-1_email-85"></i>
                                            </div>
                                        </div>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Email...">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons objects_key-25"></i>
                                            </div>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" placeholder="Password...">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons objects_key-25"></i>
                                            </div>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Confirm Password...">
                                    </div>
                                    <div class="form-check text-left">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox">
                                            <span class="form-check-sign"></span>
                                            Acepto los <a href="#something">términos y condiciones</a>.
                                        </label>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-round btn-lg">Empezar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('includes.footer')

    </div>
</div>

@endsection