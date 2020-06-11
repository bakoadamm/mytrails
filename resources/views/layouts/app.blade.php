<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  -->
    <!--    Document Title-->
    <!-- =============================================-->
    <title>MyTrails | Find your path.</title>
    <!--  -->
    <!--    Favicons-->
    <!--    =============================================-->
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/favicons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicons/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon.png">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!--  -->
    <!--    Stylesheets-->
    <!--    =============================================-->
    <!-- Default stylesheets-->
    <link href="/assets/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template specific stylesheets-->
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600,600i,700,700i|Muli:400,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/notiflix-1.3.0.min.css">
    <link href="/assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/lib/remodal/dist/remodal.css" rel="stylesheet">
    <link href="/assets/lib/remodal/dist/remodal-default-theme.css" rel="stylesheet"/>
    <link href="/assets/lib/css-hamburgers/dist/hamburgers.css" rel="stylesheet">
    <!-- Main stylesheet and color file-->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
    @yield('css')
</head>
<body data-spy="scroll" data-target=".inner-link" data-offset="60">
<main>
    <div id="preloader">
        <div id="status"></div>
    </div>
    @include('fragments.navbar')
    @yield('content')
</main>
<!--  -->
<!--    JavaScripts-->
<!--    =============================================-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="/assets/lib/jquery/dist/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="/assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/js/notiflix-1.3.0.min.js"></script>
<script src="/assets/js/timeago.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/ScrollToPlugin.min.js"></script>
<script src="/assets/lib/imagesloaded/imagesloaded.pkgd.js"></script>
<script src="/assets/lib/rellax/rellax.js"></script>
<script src="/assets/lib/remodal/dist/remodal.js"></script>
<script src="/assets/js/core.js"></script>
<script src="/assets/js/main.js"></script>

<script>
    const MyTrails = {
        notiflixInit: function() {
            Notiflix.Report.Merge({
                borderRadius:'0px',
                width:'300px',
                fontSize:'14px',
                timeout:4000,
                messageMaxLength:200,
                svgColor:"#36b36a",
                buttonBackground: "#36b36a",
            });

            Notiflix.Confirm.Init({
                borderRadius:"0px",
                titleColor: 'rgb(0,0,0)',
                okButtonBackground: "#36b36a",
            });

            Notiflix.Loading.Merge({
                svgColor:"#36b36a",
                backgroundColor:"transparent",
            });
            Notiflix.Notify.Init({
                borderRadius:'0px',
                okButtonBackground: "#36b36a",
            });
        }
    }

    $(function() {
        $("time.timeago").timeago();
        MyTrails.notiflixInit();

        $('.heart').click(function() {
            let id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url     : '/like/' + id,
                type    : 'post',
                dataType: 'json',
                error: function (xhr, ajaxOptions, thrownError) {
                    switch(xhr.status) {
                        case 401:
                            Notiflix.Notify.Warning('Be kell jelentkezned ehhez a funkcióhoz!');
                            break;
                        default:
                            Notiflix.Notify.Failure('Ismeretlen hiba!');
                            break;
                    }
                }
            }).done(function(re) {
                console.log(re)
                if(re.message === 'dislike') {
                    $('.heart').removeClass('red-heart');
                    Notiflix.Notify.Info('Az útvonalat eltávolítottad a kedvencek közül!');
                } else {
                    $('.heart').addClass('red-heart');
                    Notiflix.Notify.Success('Az útvonalat hozzáadtad a kedvencekhez!');
                }
            });
        })
    })
</script>
@yield('js')
</body>
</html>
