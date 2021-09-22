@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="wrapper">

  @include('includes.sidebar')

  <div class="main-panel">

    @include('includes.navdash')

    <div class="content">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="card card-plain card-subcategories">
            <div class="card-header">
              <h1 class="card-title text-center mt-4">¡Bienvenido/a, {{ auth()->user()->name }}!</h1>
              <br />
            </div>
            <div class="card-body ">
              <ul class="nav nav-pills nav-pills-primary nav-pills-icons justify-content-center" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
                    <i class="now-ui-icons location_bookmark"></i>
                    Grupos
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#link8" role="tablist">
                    <i class="now-ui-icons tech_mobile"></i>
                    Sensores
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                    Alertas
                  </a>
                </li>
              </ul>
              <div class="tab-content tab-space tab-subcategories">
                <div class="tab-pane active" id="link7">
                  @role('admin')
                  @if (auth()->user()->groups->count() > 2)
                  Tienes {{auth()->user()->groups->count() - 1}} grupos creados, además tienes un grupo con todos tus
                  dispositivos registrados. Añade personal de mantenimiento en caso que lo necesites.
                  @else
                  Aún no tienes grupos, crea grupos para mantener una mejor organización de tus dispositivos. Tendrás
                  disposible un grupo por defecto con todos tus sensores registrados en el caso que no necesites crear
                  grupos de dispositivos.
                  @endif
                  @endrole

                  @role('maintenance')
                  @if (auth()->user()->groups->count() > 0)
                  Tienes {{auth()->user()->groups->count()}} grupos asignados para su mantenimiento.
                  @else
                  Aún no tienes grupos asignados.
                  @endif
                  @endrole
                </div>
                <div class="tab-pane" id="link8">
                  @role('admin')
                  @if (auth()->user()->groups()->where('name', 'Todos los Sensores')->first()->devices->count() > 0)
                  Tienes {{auth()->user()->groups()->where('name', 'Todos los Sensores')->first()->devices->count()}}
                  sensores registrados. Puedes ver los valores que estos captan y asignarle reglas que produzcan
                  alertas.
                  @else
                  Introduce el número de serie del dispositivo que quieres registrar, tanto en grupos creados por ti
                  como en el apartado de sensores.
                  @endif
                  @endrole

                  @role('maintenance')
                  Tienes todos los dispositivos de los {{auth()->user()->groups->count()}} grupos asignados disposibles
                  para visualizar valores detectados.
                  @endrole
                </div>
                <div class="tab-pane" id="link9">
                  Las alertas son avisos que la aplicación producirá, en caso que existan reglas asignadas a los
                  diferentes sensores, para poder tener un mayor control del clima ambiental en lugares donde estos
                  dispositivos estén instalados.
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