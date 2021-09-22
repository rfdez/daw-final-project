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
                            <h4 class="card-title">Alertas de {{ $device->name }}</h4>
                            <p class="text-justify">
                                Aquí puedes ver las alertas producidas por este dispositivo a la hora de recibir los
                                valores que este detecta.
                            </p>
                            <a href="{{ url()->previous() }}" class="text-decoration-none text-reset">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mx-auto">
                    <div class="col-md-12">
                        <div class="card card-timeline card-plain">
                            <div class="card-body">
                                <ul class="timeline">
                                    @foreach ($device->alerts->sortByDesc('created_at') as $alert)
                                    @if ($alert->type === 'humidity')
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge info">
                                            <img src="{{ asset('assets/img/icons/humidity.svg') }}" alt="humidity">
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-info">{{ $alert->name }}</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>{{ $alert->message }}</p>
                                            </div>
                                            <h6>
                                                <i class="ti-time"></i>
                                                {{ $alert->created_at->format('d/m/Y H:i:s') }}
                                            </h6>
                                        </div>
                                    </li>
                                    @elseif ($alert->type === 'temperature')
                                    <li>
                                        <div class="timeline-badge success">
                                            <img src="{{ asset('assets/img/icons/temperature.svg') }}" alt="">
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-success">{{ $alert->name }}</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>{{ $alert->message }}</p>
                                            </div>
                                            <h6>
                                                <i class="ti-time"></i>
                                                {{$alert->created_at->format('d/m/Y H:i:s')}}
                                            </h6>
                                        </div>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
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