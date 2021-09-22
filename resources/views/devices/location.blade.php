@extends('layouts.app')

@section('title', 'Localización')

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
              <h4 class="card-title">Localización</h4>
              <a href="{{ url()->previous() }}" class="text-decoration-none text-reset">
                Volver
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="card ">
            <div class="card-header ">
              <h4 class='card-title'>
                {{ $location->device->name }}
              </h4>
              <small>Última actualización: {{ $location->created_at->format('d/m/Y H:i:s') }}</small>
            </div>
            <div class="card-body ">
              <div id="customSkinMap" class="map" style="min-height:1000px!important"></div>
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

    // Custom Skin & Settings Map
    var myLatlng = new google.maps.LatLng(@json($location->latitude), @json($location->longitude));
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