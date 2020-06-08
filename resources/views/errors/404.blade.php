@extends('layouts.app')
@section('content')
<div class="container mt-9">
    <div class="error-wrapper">
        <div class="man-icon"></div>
        <h3 class="title">404</h3>
        <p class="info">Oh! Az oldal nem található</p>
        <a href="/"><button type="button" class="mt-3 btn btn-capsule btn-outline-danger">Kezdőlap</button></a>
    </div>
</div>
@stop

@section('css')
<style>
    p, h1, h2, h3, h4, h5 {
        margin: 0;
    }

    body{
        margin: 0;
        padding: 0;
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size: 12px;
        background: #f3f3f3;
    }

    .error-wrapper {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .error-wrapper .title {
        font-size: 32px;
        font-weight: 700;
        color: #000;
    }

    .error-wrapper .info {
        font-size: 14px;
    }


    .man-icon {
        background: url('https://www.hotstar.com/assets/b5e748831c911ca02f9c07afc11f2ae5.svg') center center no-repeat;
        display: inline-block;
        height: 100px;
        width: 118px;
        margin-bottom: 16px;
    }
</style>
@stop
