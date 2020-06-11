@extends('layouts.app')

@section('content')
    <section class="text-center color-white overflow-hidden p-0">
        <div class="background-holder overlay gsap-fade-in" style="background-image:url('assets/images/topo-layer.png'), url('assets/images/header.jpg');"> </div>
        <!--/.background-holder-->
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 py-8">
                    <div class="gsap">
                        <h2 class="gsap-unite parallax fs-2 fs-lg-4 gradient-text" data-rellax-speed="5">Útvonalak</h2>
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
    <section class="header font-1 pt-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="sticky-top pl-4">
                        <h5 class="mb-3 color-primary fw-600 pt-7">Szűrés</h5>
                        <hr class="color-primary">
                        <p>Tájegység</p>
                        <form class="search-form">
                            <ul class="no-style lh-8 pl-0 ls fw-400" id="nav-elements">
                                @foreach($regions as $region)
                                <li>
                                    <label class="cb-container">{{ $region->name }}
                                        <input type="checkbox" name="region" value="{{ $region->slug }}" @if(in_array($region->slug, $params['region']))checked="checked"@endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 pt-7">
                    <div>
                        <p class="fs-2 lh-2 color-3 mb-6 font-2">Böngéssz a mások által feltöltött útvonalak között és járd végig ami tetszik!</p>
                        @foreach($tracks as $track)
                            <div class="img-container" style="background-image: url('/assets/images/topo-layer.png'), url('{{ '/storage/covers/' . $track->getCover() }}')">
                                <div class="layer">
                                    <div class="title">
                                        @foreach($track->getRegions() as $region)<span class="badge badge-secondary mr-1">{{ $region->name }}</span>@endforeach
                                        <a href="/utvonal/{{ $track->getId() }}"><h5 class="mb-2 fw-800 color-2">{{ $track->getTitle() }}</h5></a>
                                    </div>
                                </div>
                            </div>
                            <p class="color-5 mb-6 description">{!! $track->getShortDescription() !!}</p>
                        @endforeach
                    </div>

                    {!! $links !!}
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
    @include('fragments.footer')
@stop

@section('js')
    <script src="/assets/js/search.js"></script>
@stop

@section('css')
    <style>
        .img-container {
            position: relative;
            border-radius: 5px;
            height: 300px;
            width: 100%;
            background-position: center center !important;
            background-size:cover !important;
        }

        .layer {
            background: rgb(255,255,255);
            background: linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(219,143,130,0) 45%);

            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .title {
            position: absolute;
            left: 15px;
            right: 15px;
            bottom: 0;
        }
        .description {
            padding: 0 15px;
        }

    </style>
@stop
