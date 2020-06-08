@extends('layouts.app')

@section('content')
<section class="header p-0 text-center">
    <div class="background-holder overlay gsap-fade-in" style="background-image: url('assets/images/topo-layer.png'), url('assets/images/header.jpg') ;"> </div>
    <!--/.background-holder-->
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <div class="gsap has-parallax py-8">
                    <p class="gsap-slide-up lead font-italic color-11 parallax" data-rellax-speed="8">MyTrails</p>
                    <h1 class="gsap-unite fs-2 fs-lg-4 text-uppercase color-white fw-800 mb-6 parallax" data-rellax-speed="5">Töltsd fel
                        <br class="d-md-none" />
                        <span class="d-none d-md-inline-block"></span>Kedvenc útvonalaidat</h1>
                    <div class="gsap-slide-down parallax" data-rellax-speed="3">
                        <a class="btn btn-white btn-capsule text-uppercase ls" href="#about">Tovább</a>
                    </div>
                </div>
            </div>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<section id="about">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-11 col-lg-9">
                <div class="has-parallax">
                    <h4 class="font-2 mb-4 fw-400">Töltsd fel és oszd meg másokkal kedvenc útvonalaidat.</h4>
                </div>
            </div>
        </div>
        <div class="row justify-content-center text-center">
            <div class="col-md-11 col-lg-7">
                <p class="color-4">
                    Töltsd fel a kedvenc túra, futó útvonaladat az oldalra és oszd meg másokkal az élményt. Ha pedig új ösvényeket keresnél amik új kalandokat tartogatnak számodra,
                    az oldal keresés funkciójával ezt is megteheted vagy csak böngéssz a mások által megosztottak között.
                </p>
                <p class="font-italic fw-600">Ha kérdésed van keress minket
                    <a href="mailto:info@yourdomain.com">info@mytrails.com</a>
                </p>
            </div>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<section class="pt-0">
    <div class="container">
        <div class="row justify-content-center text-center">
            <h4 class="fw-800 ls color-primary mt-4 mb-5">Leutóbb feltöltött útvonalak</h4>
        </div>
        <div class="row justify-content-center text-center">
            @foreach($tracks as $track)
            <div class="col-md-5 mb-5 mb-md-0 mr-1">
                <div class="img-holder" style="height: 281px; overflow: hidden; background: url('{{ '/storage/covers/' . $track->getCover() }}') center center; background-size: cover;">
                    {{-- <img src="{{ '/storage/covers/' . $track->getCover() }}" /> --}}
                </div>
                <a href="/utvonal/{{ $track->getId() }}"><h5 class="fs-0 fw-800 ls color-primary mt-4 mb-3 text-uppercase">{{ $track->getTitle() }}</h5></a>
                <p class="color-4">{{ $track->getShortDescription() }}</p>
                <a class="fw-600 font-2" href="/utvonal/{{ $track->getId() }}">Megnézem &xrarr;</a>
            </div>
            @endforeach
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
@include('fragments.footer')
@stop
