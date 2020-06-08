@extends('layouts.app')

@section('content')
    <section class="header text-center color-white overflow-hidden p-0">
        <div class="background-holder overlay gsap-fade-in" style="background-image: url('{{ '/storage/covers/' . $track->getCover() }}'); transform: matrix(1, 0, 0, 1, 0, 0); filter: blur(50px); opacity: 1;">
            <div class="layer"></div>
        </div>
        <!--/.background-holder-->
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 py-8">
                    <div class="gsap">
                        <h2 class="gsap-unite parallax fs-2 fs-lg-4" data-rellax-speed="5" style="opacity: 1; letter-spacing: 0.05em; transform: translate3d(0px, 0px, 0px);">
                            {{ $track->getTitle() }}</h2>
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
    <section id="map" class="gpx" data-gpx-source="{{ '/storage/tracks/' . $track->getGpx() }}" data-map-target="demo-map" style="padding: 0;">
        <div class="container">
            <div class="row text-right">
                <div class="col-md-12 mt-3">
                    <a class="btn btn-outline-dark btn-social radius-round mr-2" href="#">
                        <i class="fs-0 fa fa-download fa-2x"></i>
                    </a>
                    <a class="btn btn-outline-dark btn-social radius-round mr-2 heart @if($track->getUserLiked()){{'red-heart'}}@endif" href="#" data-id="{{ $track->getId() }}">
                        <i class="fs-0 fa fa-heart fa-2x"></i>
                    </a>
                    <a class="btn btn-outline-dark btn-social radius-round" href="#">
                        <i class="fs-0 fa fa-share fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 pt-1">
                    <div class="font-2">
                        <h4 class="mt-3 mb-3 text-uppercase ls fw-600 color-2">{{ $track->getTitle() }}</h4>
                        <p class="font-italic fw-400 color-4">
                            Feltöltötte: <a href="#">{{ $track->getUser()->name }}</a><br>
                            <time class="timeago mr-1" datetime="{{ $track->getCreatedAt() }}">{{ $track->getCreatedAt() }}</time><br>
                            <span class="distance">Táv: <span></span> km</span><br>
                            <span class="alt">Szintemelkedés: <span></span> m</span>
                        </p>
                        <hr class="color-9">
                        <p class="fs-2 lh-2 color-3">{{ $track->getShortDescription() }}</p>
                        <h5 class="mt-6 mb-3 text-uppercase ls fw-600 color-2">Az útvonalról</h5>
                        <p class="color-4 lh-5">{!!  $track->getDescription() !!}</p>

                    </div>
                </div>
                <div class="col-lg-7 pt-1">
                    <article>
                        <div class="map my-3" id="demo-map"></div>
                    </article>
                </div>

            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
    @include('fragments.footer')

@stop


@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/leaflet/Locate.css" />
    <link rel="stylesheet" href="/assets/leaflet/context.css" />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <style type="text/css">
        .red-heart {
            background-color: red !important;
            border-color: red !important;
            color: white;
        }
        body {
            background-image: url('/assets/images/topo-25.png');
            background-size: cover;
        }
        .background-holder {
            /*position: relative;*/
        }
        .layer {
            background: rgb(255,255,255);
            background: linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(255, 255, 255, 0) 30%);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .gpx .map {
            width: 100%;
            height: 750px;
            min-height: 500px;
        }
        .gpx ul.info { list-style: none; margin: 0; padding: 0; font-size: smaller; }
        .gpx ul.info li { color: #666; padding: 2px; display: inline; }
        .gpx ul.info li span { color: black; }


        .dist-marker {
            font-size: 9px;
            border: 1px solid #777;
            border-radius: 10px;
            text-align: center;
            color: #000;
            background: #fff;
        }
        .leaflet-control-layers-list {
            padding: 0
        }
    </style>
@stop


@section('js')

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.0/leaflet.awesome-markers.min.js"></script>
    <script src="/assets/leaflet/context.js"></script>
    <script src="/assets/leaflet/Locate.js" charset="utf-8"></script>
    <script src="https://rawgithub.com/mpetazzoni/leaflet-gpx/master/gpx.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.3/src/leaflet.geometryutil.min.js"></script>
    <script src="/assets/leaflet/distance-marker.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>

    <script>
        "use strict";
        function downloadGPX() {
            location.href = '/letoltes'
        }

        function display_gpx(elt) {
            let lineWeight = 5;

            if (!elt) return;

            var url = elt.getAttribute('data-gpx-source');
            var mapid = elt.getAttribute('data-map-target');
            if (!url || !mapid) return;

            function _t(t) { return elt.getElementsByTagName(t)[0]; }
            function _c(c) { return elt.getElementsByClassName(c)[0]; }

            let tuhu = L.tileLayer('http://map.turistautak.hu/tiles/lines/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });


            var map = L.map(mapid, {
                center: [47.47, 19.39],
                zoom: 10,
                fullscreenControl: true,
                contextmenu: true,
                contextmenuWidth: 140,
                contextmenuItems: [{
                    text: 'Track letöltése',
                    callback: downloadGPX
                }],
                layers: [tuhu]
            });

            //L.control.locate().addTo(map);

            new L.GPX(url, {
                async: true,
                marker_options: {
                    startIconUrl: '',
                    endIconUrl:   '',
                    shadowUrl:    'http://github.com/mpetazzoni/leaflet-gpx/raw/master/pin-shadow.png',
                    wptIconUrls: {
                        '': '/assets/images/map-marker-2.png',
                        'Geocache Found': 'img/gpx/geocache.png',
                        'Park': 'img/gpx/tree.png'
                    }
                },
                polyline_options: {
                    color: 'rgb(0,0,0)',
                    //color: 'rgb(255, 255, 255)',
                    opacity: 1,
                    weight: lineWeight,
                    lineCap: 'round',
                    distanceMarkers: { lazy: true }
                },
            }).on('loaded', function(e) {
                var gpx = e.target;
                map.fitBounds(gpx.getBounds());
                control.addOverlay(gpx, gpx.get_name());

                console.log('hr:' + gpx.get_average_hr())

                let distance = gpx.get_distance()/1000;
                let alt = gpx.get_elevation_gain();
                $('.distance span').html(Math.round(distance*10)/10);
                $('.alt span').html(Math.round(alt*10)/10);
            }).addTo(map);


            let thunderForest = L.tileLayer('https://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png?apikey=3d394f9f31084de9a18c1fb5ef30cb28', {
                attribution: '&copy; <a href="http://www.thunderforest.com/">Thunderforest</a>, &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                apikey: '<your apikey>',
                maxZoom: 22
            });

            let osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
            }).addTo(map);

            let freemap = L.tileLayer('https://outdoor.tiles.freemap.sk/{z}/{x}/{y}{r}', {
                attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
            });


            let baseMaps = {
                "OSM": osm,
                "Freemap.sk": freemap,
                "Thudnerforest": thunderForest
            };

            let layers = {
                "Turistautak": tuhu,
            }

            var control = L.control.layers(baseMaps, layers).addTo(map);

        }

        $(function() {
            display_gpx(document.getElementById('map'));
        })

    </script>
@stop
