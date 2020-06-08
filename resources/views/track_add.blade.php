@extends('layouts.app')

@section('content')

    @php($edit = isset($track) ? true : false)

    <div class="container my-5">
        @if($edit)
            <h4 class="mb-1 fs-1">Útvonal szerkesztése</h4>
        @else
        <h4 class="mb-1 fs-1">Új útvonal hozzáadása</h4>
        @endif

        <div class="card bg-light">
            <form class="card-body" novalidate="" action="@if($edit){{ '/track/update' }}@else{{'/track/add'}}@endif" method="post" enctype="multipart/form-data">
                @csrf
                @if($edit)
                    <input type="hidden" name="track_id" value="{{ $track->getId() }}">
                @endif
                <div class="form-group">
                    <label class="fs-0 form-control-label" for="input1">Az útvonal neve</label>
                    <input type="text" class="form-control" name="title" id="title" @if($edit)value="{{ $track->getTitle() }}"@endif required>

                </div>

                <div class="form-group">
                    <label class="fs-0 form-control-label" for="short_description">Rövid leírás</label>
                    <textarea class="form-control" name="short_description" id="short_description" rows="4">@if($edit){{ $track->getShortDescription() }}@endif</textarea>
                </div>

                <div class="form-group">
                    <label class="fs-0 form-control-label" for="description">Leírás</label>
                    <textarea class="form-control summernote" name="description" id="description" required>
                        @if($edit){{ $track->getDescription() }}@endif
                    </textarea>
                </div>
                @if($edit)
                    <p>A jelenlegi fájlok megtartásához hagyd üresen!</p>
                    <p>{{ $track->getGpx() }}</p>
                    <p><img src="/storage/covers/{{ $track->getCover() }}" style="width: 300px;"></p>
                @endif
                <div class="form-group">
                    <label class="fs-0 form-control-label" for="gpx">GPX fájl</label>
                    <input class="form-control" type="file" id="gpx" name="gpx">
                </div>

                <div class="form-group">
                    <label class="fs-0 form-control-label" for="cover">Borítókép</label>
                    <input class="form-control" type="file" id="cover" name="cover">
                </div>

                <div>
                    <button type="submit" class="btn btn-outline-dark btn-capsule" style="border-width: 2px;">@if($edit){{'Szerkesztés'}}@else{{'Hozzáadás'}}@endif</button>
                </div>

            </form>


        </div>
        <!-- /.card -->

    </div>
    <!-- /.container -->
@stop


@section('css')
    <link rel="stylesheet" href="/assets/css/notiflix-1.3.0.min.css">
    <link rel="stylesheet" href="/assets/lib/summernote/summernote-bs4.css">
    <style>
        .btn {
            cursor: pointer
        }
    </style>
@stop

@section('js')
    <script src="/assets/js/notiflix-1.3.0.min.js"></script>
    <script src="/assets/lib/summernote/summernote-bs4.js"></script>
    <script>
        $(function () {
            $('.summernote').summernote({
                placeholder: 'Leírás',
                tabsize: 2,
                height: 300
            })
        })
    </script>
    @if (\Session::has('success'))
        <script>
            Notiflix.Notify.Init({
                borderRadius:'0px',
                okButtonBackground: "#36b36a",
            });
            Notiflix.Notify.Success('Az útvonalat sikeresen szerkesztetted!');
        </script>

    @endif
@stop
