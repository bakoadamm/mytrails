@extends('layouts.app')

@section('content')
    <section class="header text-center color-white overflow-hidden p-0">
        <div class="background-holder overlay gsap-fade-in"
             style="background-image: {{--url('/assets/images/topo-layer.png'),--}} url('{{ '/storage/covers/' . $track->getCover() }}'); transform: matrix(1, 0, 0, 1, 0, 0); filter: blur(0px); opacity: 1;">
            <div class="layer"></div>
        </div>
        <!--/.background-holder-->
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 py-8">
                    <div class="gsap">
                        <h2 class="gsap-unite parallax fs-2 fs-lg-4 gradient-text" data-rellax-speed="5" style="opacity: 1; transform: translate3d(0px, 0px, 0px);">
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
                    <div>
                        <h4 class="mt-3 mb-3 fw-700 color-2">{{ $track->getTitle() }}</h4>
                        <p class="font-italic fw-400 color-4">
                            Feltöltötte: <a href="#">{{ $track->getUser()->name }}</a><br>
                            <img src="/assets/images/time-outline.svg" style="width:20px"> <time class="timeago mr-1" datetime="{{ $track->getCreatedAt() }}">{{ $track->getCreatedAt() }}</time><br>
                            <span class="distance"><img src="/assets/images/trail-sign-outline.svg" style="width:20px"> Táv: <span></span> km</span><br>
                            <span class="alt"><img src="/assets/images/triangle-outline.svg" style="width:20px"> Szintemelkedés: <span></span> m</span><br>
                            <span class="regions"><img src="/assets/images/map-outline.svg" style="width:20px"> Tájegységek: @foreach($track->getRegions() as $region){{ $region->name }}@if(!$loop->last){{', '}}@endif @endforeach</span>

                        </p>
                        <hr class="color-9">
                        <p class="fs-1 lh-2 color-3">{{ $track->getShortDescription() }}</p>
                        <h5 class="mt-6 mb-3 text-uppercase ls fw-600 color-2">Az útvonalról</h5>
                        <p class="color-4 lh-5">{!!  $track->getDescription() !!}</p>

                    </div>
                </div>
                <div class="col-lg-7 pt-1">
                    <article>
                        <div class="map mt-3 leaflet-map" id="demo-map"></div>
                        <div id="elevation-div" class="leaflet-control elevation"></div>
                        <div id="data-summary" class="data-summary font-italic fw-400 color-4"><span class="totlen"><span class="summarylabel">Hossz: </span><span class="summaryvalue">0</span></span> &mdash; <span class="maxele"><span class="summarylabel">Legmagasabb pont: </span><span class="summaryvalue">0</span></span>
                            &mdash; <span class="minele"><span class="summarylabel">Legalacsonyabb pont: </span><span class="summaryvalue">0</span></span></div>
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
    <link rel="stylesheet" href="/assets/leaflet/Locate.css" />
    <link rel="stylesheet" href="/assets/leaflet/context.css" />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

    <link rel="stylesheet" href="https://unpkg.com/@raruto/leaflet-elevation@0.3.9/leaflet-elevation.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/@raruto/leaflet-elevation@0.3.9/leaflet-elevation.min.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <style>
        #elevation-div {
            width: 100% !important
        }
        .custom-theme.leaflet-control.elevation .area {
            /*fill: rgba(255, 255, 255, 0.85);*/
            fill: #a9d171;
            stroke: hsla(60, 0%, 0%, 0.85);
            stroke-width: 2.8;

        }
        .leaflet-control.elevation .background {
            background: white;
        }

        .custom-theme.height-focus.circle-lower {
            fill: #a9d171;
        }

        .custom-theme.elevation-polyline {
            stroke: #000;
            stroke-opacity: 0.85;
        }

        .elevation-tooltip.leaflet-tooltip,
        .elevation-popup .leaflet-popup-content {
            text-align: center;
            font-weight: 300;
            width: 300px !important;
            white-space: normal;
            padding: 0;
            margin: 0;
            border-radius: 12px;
        }

        .elevation-tooltip>b:first-child,
        .elevation-popup .leaflet-popup-content>b:first-child {
            display: inline-block;
            width: 100%;
            text-align: center;
            font-family: 'averia_seriflightitalic', 'Alexander', serif;
            font-size: 20px;
            font-weight: 700;
            border-radius: 8px 8px 0px 0px;
            border: 1px solid #bbb;
            background: #303030;
            color: #ccc;
            text-shadow: -1px 0px 1px #000;
            box-sizing: content-box;
            margin-left: -1px;
        }

        .elevation-tooltip .wpt-link-image img,
        .elevation-popup .leaflet-popup-content .wpt-link-image img {
            height: 100%;
            width: 300px;
            max-height: 230px;
            object-fit: cover;
            display: block;
        }

        .elevation-tooltip .wpt-link-image,
        .elevation-popup .leaflet-popup-content .wpt-link-image {
            display: inline-block;
        }

        .elevation-tooltip .wpt-desc,
        .elevation-popup .leaflet-popup-content .wpt-desc {
            border-top: solid 1px #ccc;
            margin-top: 5px;
            padding-top: 5px;
            color: #000;
            font-weight: bold;
            text-align: center;
        }
    </style>

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
    <script src="{{ asset('assets/js/leaflet-gpx.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.3/src/leaflet.geometryutil.min.js"></script>
    <script src="/assets/leaflet/distance-marker.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>

    <script src="https://unpkg.com/d3@4.13.0/build/d3.min.js" charset="utf-8"></script>
    <script src="https://unpkg.com/@raruto/leaflet-elevation@0.3.9/leaflet-elevation.min.js"></script>

    <script>
        "use strict";
        function downloadGPX() {
            location.href = '/letoltes'
        }

        function display_gpx(elt) {
            let lineWeight = 5;

            let url = elt.getAttribute('data-gpx-source');
            let mapid = elt.getAttribute('data-map-target');
            if (!url || !mapid) return;

            let opts = {
                elevationControl: {
                    data: url,
                    options: {
                        theme: "custom-theme", // CHANGE: your custom-theme name
                        elevationDiv: "#elevation-div",
                        position: "bottomleft",
                        collapsed: false,
                        width: 500,
                        height: 100,
                        detachedView: false,
                        summary: 'multiline',
                        useHeightIndicator: true, //if false a marker is drawn at map position
                        interpolation: d3.curveLinear, //see https://github.com/d3/d3/wiki/

                    },
                },
                layersControl: {
                    options: {
                        collapsed: true,
                    },
                },
            };

            if (!elt) return;

            let controlElevation = L.control.elevation(opts.elevationControl.options);

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
                resizerControl: true,
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
                    startIconUrl: 'http://mrmufflon.github.io/Leaflet.Elevation/example/lib/leaflet-gpx/pin-icon-start.png',
                    endIconUrl:   'http://mrmufflon.github.io/Leaflet.Elevation/example/lib/leaflet-gpx/pin-icon-end.png',
                    shadowUrl:    '/assets/images/pin-shadow.png',
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

                console.table(gpx)
                console.log(gpx)
                console.log('hr:' + gpx.get_average_hr())

                let distance = gpx.get_distance()/1000;
                let alt = gpx.get_elevation_gain();
                $('.distance span').html(Math.round(distance*10)/10);
                $('.alt span').html(Math.round(alt*10)/10);
            }).addTo(map);

            map.on('fullscreenchange', function () {
                if (map.isFullscreen()) {
                    console.log('entered fullscreen');

                } else {
                    console.log('exited fullscreen');

                }
            });


            let thunderForest = L.tileLayer('https://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png?apikey=3d394f9f31084de9a18c1fb5ef30cb28', {
                attribution: '&copy; <a href="http://www.thunderforest.com/">Thunderforest</a>, &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                apikey: '3d394f9f31084de9a18c1fb5ef30cb28',
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

            let control = L.control.layers(baseMaps, layers).addTo(map);

            map.on('eledata_loaded', function(e) {
                let q = document.querySelector.bind(document);
                let track = e.track_info;

                console.log(track);

                q('.totlen .summaryvalue').innerHTML = track.distance.toFixed(1) + " km";
                q('.maxele .summaryvalue').innerHTML = track.elevation_max.toFixed(1) + " m";
                q('.minele .summaryvalue').innerHTML = track.elevation_min.toFixed(1) + " m";
            });


            controlElevation.loadChart(map);
            controlElevation.loadData(opts.elevationControl.data);

            controlElevation.addTo(map);
        }

        $(function() {
            display_gpx(document.getElementById('map'));
        })

    </script>
@stop
