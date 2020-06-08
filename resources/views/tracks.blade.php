@extends('layouts.app')

@section('content')
    <section class="text-center color-white overflow-hidden p-0">
        <div class="background-holder overlay gsap-fade-in" style="background-image:url('assets/images/topo-layer.png'), url('assets/images/header.jpg');"> </div>
        <!--/.background-holder-->
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 py-8">
                    <div class="gsap">
                        <h2 class="gsap-unite text-uppercase parallax fs-2 fs-lg-4" data-rellax-speed="5">Útvonalak</h2>
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
                        <h5 class="mb-3 color-primary font-2 fw-600 pt-7">Szűrés</h5>
                        <ul class="no-style fs--1 lh-8 pl-0 text-uppercase ls fw-700" id="nav-elements">
                            <li>
                                <a class="color-7" href="">Tájegység</a>
                                <ul class="dropdown text-left">
                                    <li>
                                        <a href="/profil">Börzsöny</a>
                                    </li>
                                    <li>
                                        <a href="/profil">Gödöllői-dombság</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 pt-7">
                    <div class="font-2">
                        <p class="fs-2 lh-2 color-3 mb-6">Böngéssz a mások által feltöltött útvonalak között és járd végig ami tetszik!</p>
                        @foreach($tracks as $track)
                            <div class="img-container" style="background-image: url('/assets/images/topo-layer.png'), url('{{ '/storage/covers/' . $track->getCover() }}')">
                                <div class="layer">
                                    <div class="title">
                                        <a href="/utvonal/{{ $track->getId() }}"><h5 class="mt-3 mb-2 ls fw-800 color-2">{{ $track->getTitle() }}</h5></a>
                                    </div>
                                </div>
                            </div>
                            <p class="color-5 mb-6">{!! $track->getShortDescription() !!}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
    @include('fragments.footer')
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
    </style>
@stop
