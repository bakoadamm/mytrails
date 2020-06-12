@extends('layouts.app')

@section('content')

    <div class="container mt-4 header">
        <div class="row">
            <div class="col-6 text-left mb-4">
                <a class="btn btn-outline-dark btn-social radius-round active routes-tab" href="#">
                    <i class="fs-0 fa fa-map-signs fa-2x"></i>
                </a>
                <a class="btn btn-outline-dark btn-social radius-round settings-tab" href="#">
                    <i class="fs-0 fa fa-cog fa-2x"></i>
                </a>
                <a class="btn btn-outline-dark btn-social radius-round favorites-tab" href="#">
                    <i class="fs-0 fa fa-heart-o fa-2x"></i>
                </a>
            </div>
            <div class="col-6 text-right mb-4">
                <a class="btn btn-outline-dark btn-social radius-round new-track" href="/profil/hozzaadas">
                    <i class="fs-0 fa fa-plus fa-2x"></i>
                </a>
            </div>
        </div>
        <div class="row trails">


            <div class="container mt-1">
                <!-- Table -->
                <div class="row">

                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header border-0">
                                <h4 class="mb-0 fs-1">Feltöltött útvonalaim</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Kép</th>
                                        <th scope="col">Útvonal neve</th>
                                        <th scope="col">Státusz</th>
                                        <th scope="col">Látható</th>
                                        <th scope="col">Műveletek</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tracks as $track)
                                    <tr>
                                        <th scope="row" class="w-25">
                                            <div class="media align-items-center">
                                                <a href="#" class=" mr-3">
                                                    <img alt="track image" src="{{ '/storage/covers/' . $track->getCover() }}">
                                                </a>
                                            </div>
                                        </th>
                                        <td>
                                            <span class="fs-0">{{ $track->getTitle() }}</span>
                                        </td>
                                        <td>
                                            @if($track->getStatus() == 1)
                                            <span class="badge badge-success">Aktív</span>
                                            @else
                                                <span class="badge badge-danger">Inaktív</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($track->getPrivate() == 1)
                                                <span class="badge badge-secondary">Private</span>
                                            @else
                                                <span class="badge badge-success">Publikus</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-outline-dark btn-social radius-round mr-1 delete" href="#" data-id="{{ $track->getId() }}">
                                                <i class="fs-0 fa fa-trash fa-2x"></i>
                                            </a>
                                            <a class="btn btn-outline-dark btn-social radius-round mr-1" href="/utvonal/szerkesztes/{{ $track->getId() }}">
                                                <i class="fs-0 fa fa-edit fa-2x"></i>
                                            </a>
                                            <a class="btn btn-outline-dark btn-social radius-round mr-1" target="_blank" href="/utvonal/{{ $track->getId() }}">
                                                <i class="fs-0 fa fa-eye fa-2x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row settings">
            <h4 class="mb-1 fs-1">Profil beállítások</h4>
        </div>
        <div class="row favorites">
            <h4 class="mb-1 fs-1">Kedvenc útvonalaim</h4>
            <div class="container">
                <hr class="color-10">
                <div class="row row-margin-bottom">
                    @foreach($favorites as $fav)

                    <div class="col-md-12 no-padding lib-item" data-category="view">
                        <div class="lib-panel">
                            <div class="row box-shadow">
                                <div class="col-md-4">
                                    <img class="lib-img-show" src="/storage/covers/{{ $fav->getCover() }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="lib-row lib-header">
                                        <a href="/utvonal/{{ $fav->getId() }}">{{ $fav->getTitle() }}</a>
                                        <div class="lib-header-seperator"></div>
                                    </div>
                                    <div class="lib-row lib-desc">
                                        <p>
                                            {{ $fav->getShortDescription() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if (\Session::has('success'))
    <div class="remodal" data-remodal-id="info">
        <button class="remodal-close" data-remodal-action="close"></button>
        <h4 class="modal-title">Siker</h4>
        <div class="modal-body">Sikeresen hozzáadtad az útvonalat!</div>
        <button class="btn btn-sm btn-success mr-3 btn-capsule" data-remodal-action="cancel">Rendben</button>
    </div>
    @endif
@endsection


@section('css')
    <style>
        table {
            border: 0 !important
        }
        table th {
            background: white !important;
        }

        .lib-panel {
            margin-bottom: 20px;
        }
        .lib-panel img {
            width: 100%;
            background-color: transparent;
        }

        .lib-panel .row,
        .lib-panel .col-md-6 {
            padding: 0;
            background-color: #FFFFFF;
        }

        .lib-panel .lib-row {
            padding: 0 20px 0 20px;
        }

        .lib-panel .lib-row.lib-header {
            background-color: #FFFFFF;
            font-size: 20px;
            padding: 10px 20px 0 20px;
        }

        .lib-panel .lib-row.lib-header .lib-header-seperator {
            height: 2px;
            width: 26px;
            background-color: #d9d9d9;
            margin: 7px 0 7px 0;
        }

        .lib-panel .lib-row.lib-desc {
            position: relative;
            height: 100%;
            display: block;
            font-size: 16px;
        }
        .lib-panel .lib-row.lib-desc a{
            position: absolute;
            width: 100%;
            bottom: 10px;
            left: 20px;
        }

        .row-margin-bottom {
            margin-bottom: 20px;
        }

        .box-shadow {
            -webkit-box-shadow: 0 0 10px 0 rgba(0,0,0,.10);
            box-shadow: 0 0 10px 0 rgba(0,0,0,.10);
        }

        .no-padding {
            padding: 0;
        }
    </style>


    <style>


        .table thead th {
            font-size: .65rem;
            padding-top: .75rem;
            padding-bottom: .75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-bottom: 1px solid #e9ecef;
        }

        .table th {
            font-weight: 600;
        }

        .table td,
        .table th {
            font-size: .8125rem;
            white-space: nowrap;
        }

        .table.align-items-center td,
        .table.align-items-center th {
            vertical-align: middle;
        }

        .table .thead-dark th {
            color: #4d7bca;
            background-color: #1c345d;
        }

        .table .thead-light th {
            color: #8898aa;
            background-color: #f6f9fc;
        }

        .table-flush td,
        .table-flush th {
            border-right: 0;
            border-left: 0;
        }

        .table-flush tbody tr:first-child td,
        .table-flush tbody tr:first-child th {
            border-top: 0;
        }

        .table-flush tbody tr:last-child td,
        .table-flush tbody tr:last-child th {
            border-bottom: 0;
        }

        .card .table {
            margin-bottom: 0;
        }

        .card .table td,
        .card .table th {
            padding-right: 1.5rem;
            padding-left: 1.5rem;
        }


    </style>
@stop

@section('js')
    <script>
        const App = {
            trackDelete: function(id, tr) {
                let data = { id: id }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url     : '/track/' + id,
                    data    : data,
                    type    : 'delete',
                    dataType: 'json',
                }).done(function(re) {
                    if(re.message === 'ok') {
                        tr.fadeOut()
                    }
                    Notiflix.Notify.Success('Az útvonalat sikeresen törölted!');
                });
            },
            favoritesTab: function() {
                $('.favorites').show();
                $('.favorites-tab').addClass('active')
                $('.trails').hide().removeClass('active');
                $('.routes-tab').removeClass('active')
                $('.settings').hide().removeClass('active');
                $('.settings-tab').removeClass('active');
            },
            settingTab: function() {
                $('.settings').show().addClass('active');
                $('.settings-tab').addClass('active');
                $('.trails').hide().removeClass('active');
                $('.routes-tab').removeClass('active')
                $('.favorites').hide().removeClass('active');
                $('.favorites-tab').removeClass('active');
            },
            routesTab: function() {
                $('.trails').show();
                $('.routes-tab').addClass('active');
                $('.favorites').hide();
                $('.favorites-tab').removeClass('active');
                $('.settings').hide();
                $('.settings-tab').removeClass('active');
            }
        }
        $(function() {
            $('.settings').hide();
            $('.favorites').hide();
            $('.delete').click(function() {
                let id = $(this).data('id');
                let tr = $(this).closest('tr');
                Notiflix.Confirm.Show('Törlés','Biztosan törlöd az útvonalat? Ez a művelet nem visszavonható!','Igen','Nem',function(){
                    App.trackDelete(id, tr);
                });

            });

            let tab = window.location.hash;
            switch (tab) {
                case '#kedvencek':
                    App.favoritesTab();
                    break;
                case '#adatok':
                    App.settingTab();
                    break;
                case '#utvonalak':
                    App.routesTab();
                    break;
            }


            $('.settings-tab').click(function() {
                App.settingTab();
            });
            $('.routes-tab').click(function() {
                App.routesTab();
            });
            $('.favorites-tab').click(function() {
                App.favoritesTab();
            })

        })
    </script>
    @if (\Session::has('success'))
        <script>
            $(function() {
                Notiflix.Notify.Success('Az útvonalat sikeresen feltöltötted!');
            })
        </script>
    @endif
@stop
