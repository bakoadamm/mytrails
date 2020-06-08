<div class="znav-container znav-white" id="znav-container">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand overflow-hidden" href="/">
                <img src='/assets/images/mytrails_logo.png' style="width:80px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger hamburger--emphatic">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto text-center fw-800 color-11">
                    <li>
                        <a href="JavaScript:void(0)">Útvonalak</a>
                        <ul class="dropdown text-left">
                            <li>
                                <a href="/utvonalak">Felfedezés</a>
                            </li>
                        </ul>
                    </li>
                    @guest
                    <li>
                        <a href="/regisztracio">Regisztráció</a>
                    </li>
                    <li>
                        <a class="btn btn-outline-dark btn-capsule btn-sm" href="/bejelentkezes" style="border-width: 2px;">Belépés</a>
                    </li>
                    @else
                        <li>
                            <a href="JavaScript:void(0)">{{ auth()->user()->name }}</a>
                            <ul class="dropdown text-left">
                                <li>
                                    <a href="/profil">Útvonalaim</a>
                                </li>
                                <li>
                                    <a href="/profil#kedvencek">Kedvenceim</a>
                                </li>
                                <li>
                                    <a href="/profil#adatok">Profilom</a>
                                </li>
                                <li>
                                    <a href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Kilépés</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</div>
