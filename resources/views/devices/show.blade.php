@extends('layouts.app')

@section('title', 'Sensor')

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
              <h4 class="card-title">{{ $device->name }}</h4>
              <a href="{{ url()->previous() }}" class="text-decoration-none text-reset">
                Volver
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card card-chart">
            <div class="card-header">
              <h4 class="card-title">Temperatura</h4>
              <small>Media Histórica: {{ $device->values->median('temperature') }} ºC</small>
              <div class="dropdown">
                <button type="button" class="btn btn-round dropdown-toggle btn-outline-default btn-icon no-caret"
                  data-toggle="dropdown">
                  <i class="now-ui-icons loader_gear"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ url()->current() }}">Actualizar</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="tempChart"></canvas>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="now-ui-icons arrows-1_refresh-69"></i>
                {{ $device->values->last()->created_at->format('d/m/Y H:i:s') }}
              </div>
            </div>
          </div>

          <div class="card card-chart">
            <div class="card-header">
              <h4 class="card-title">Humedad</h4>
              <small>Media Histórica: {{ $device->values->median('humidity') }} %</small>
              <div class="dropdown">
                <button type="button" class="btn btn-round dropdown-toggle btn-outline-default btn-icon no-caret"
                  data-toggle="dropdown">
                  <i class="now-ui-icons loader_gear"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ url()->current() }}">Actualizar</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="humidityChart"></canvas>
              </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="now-ui-icons arrows-1_refresh-69"></i>
                {{ $device->values->last()->created_at->format('d/m/Y H:i:s') }}
              </div>
            </div>
          </div>

          <div class="card card-timeline card-plain">
            <div class="card-header">
              <h4 class="card-title">Últimas Alertas</h4>
            </div>
            <div class="card-body">
              <ul class="timeline timeline-simple">
                @if ($device->alerts->count() > 0)
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
                <li class="timeline-inverted">
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
                @else
                <li class="timeline-inverted">
                  <div class="timeline-badge warning">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                  </div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <span class="badge badge-warning">Alertas</span>
                    </div>
                    <div class="timeline-body">
                      <p>En este apartado podrá ver las alertas generadas cuando el sensor capta valores fuera del rango
                        establecido en las reglas que puede personalizar a cada dispositivo, tanto la humedad como la temperatura.</p>
                    </div>
                  </div>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header ">
              <h4 class='card-title'>
                Localización
              </h4>
              <small>Última actualización:
                {{ $device->locations->last()->created_at->format('d/m/Y H:i:s') }}</small>
            </div>
            <div class="card-body ">
              <div id="customSkinMap" class="map"></div>
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
    
    chartColor = "#FFFFFF";

    gradientChartOptionsConfigurationWithNumbersAndGrid = {
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      tooltips: {
        bodySpacing: 4,
        mode: "nearest",
        intersect: 0,
        position: "nearest",
        xPadding: 10,
        yPadding: 10,
        caretPadding: 10
      },
      responsive: true,
      scales: {
        yAxes: [{
          gridLines: 0,
          gridLines: {
            zeroLineColor: "transparent",
            drawBorder: false
          }
        }],
        xAxes: [{
          display: 0,
          gridLines: 0,
          ticks: {
            display: false
          },
          gridLines: {
            zeroLineColor: "transparent",
            drawTicks: false,
            display: false,
            drawBorder: false
          }
        }]
      },
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 15,
          bottom: 15
        }
      }
    };

    temp = document.getElementById('tempChart').getContext("2d");

    gradientStroke = temp.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#18ce0f');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = temp.createLinearGradient(0, 170, 0, 50);
    gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
    gradientFill.addColorStop(1, hexToRGB('#18ce0f', 0.4));

    myChart = new Chart(temp, {
      type: 'line',
      responsive: true,
      data: {
        labels: @json($dates),
        /* @json($device->values->sortBy('created_at')->chunk(5)->toArray()) */
        datasets: [{
          label: "Temperatura (ºC)",
          borderColor: "#18ce0f",
          pointBorderColor: "#FFF",
          pointBackgroundColor: "#18ce0f",
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          backgroundColor: gradientFill,
          borderWidth: 2,
          data: @json($temperatures)
        }]
      },
      options: gradientChartOptionsConfigurationWithNumbersAndGrid
    });

    hum = document.getElementById('humidityChart').getContext("2d");

    gradientStroke = hum.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#2ca8ff');
    gradientStroke.addColorStop(1, chartColor);

    gradientFill = hum.createLinearGradient(0, 170, 0, 50);
    gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
    gradientFill.addColorStop(1, hexToRGB('#2ca8ff', 0.4));

    myChart = new Chart(hum, {
      type: 'line',
      responsive: true,
      data: {
        labels: @json($dates),
        /* @json($device->values->sortBy('created_at')->chunk(5)->toArray()) */
        datasets: [{
          label: "Humedad (%)",
          borderColor: "#2ca8ff",
          pointBorderColor: "#FFF",
          pointBackgroundColor: "#2ca8ff",
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          backgroundColor: gradientFill,
          borderWidth: 2,
          data: @json($humidity)
        }]
      },
      options: gradientChartOptionsConfigurationWithNumbersAndGrid
    });

    // Custom Skin & Settings Map
    var myLatlng = new google.maps.LatLng(@json($device->locations->last()->latitude), @json($device->locations->last()->longitude));
    var mapOptions = {
      zoom: 14,
      center: myLatlng,
      scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
      disableDefaultUI: false, // a way to quickly hide all controls
      zoomControl: true,
      mapTypeId: 'satellite',
      styles: [{
        "featureType": "water",
        "stylers": [{
          "saturation": 43
        }, {
          "lightness": -11
        }, {
          "hue": "#0088ff"
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
          "hue": "#ff0000"
        }, {
          "saturation": -100
        }, {
          "lightness": 99
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#808080"
        }, {
          "lightness": 54
        }]
      }, {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ece2d9"
        }]
      }, {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ccdca1"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#767676"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "featureType": "poi",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#b8cb93"
        }]
      }, {
        "featureType": "poi.park",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.sports_complex",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.medical",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.business",
        "stylers": [{
          "visibility": "simplified"
        }]
      }]

    }

    var map = new google.maps.Map(document.getElementById("customSkinMap"), mapOptions);

    var marker = new google.maps.Marker({
      position: myLatlng,
      title: "Device location"
    });

    marker.setMap(map);
</script>
@endpush