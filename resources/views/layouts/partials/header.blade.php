<header class="p-3 mb-3 border-bottom aquamarine-600 sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand link-body-emphasis text-white" href="#">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07"
                aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse fs-4" id="navbarsExample07">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-4 link-body-emphasis text-white"
                            href="{{ route('incidencias.index') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-4 link-body-emphasis text-white" href="#">Administrar usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-4 link-body-emphasis text-white" href="#">Informes</a>
                    </li>
                </ul>
                <div class="nav-item dropdown">
                    <a href="#"
                        class="d-block link-body-emphasis text-decoration-none dropdown-toggle nav-link px-4 text-white"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white"
                            class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                    </a>
                    @auth
                        <ul class="dropdown-menu text-small" style="">
                            <li><a class="dropdown-item" href="#">{{ auth()->user()->name }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ auth()->user()->email }}</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="d-flex align-items-center">

                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" name="logout">
                                        Cerrar sesión
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                            <path fill-rule="evenodd"
                                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                        </svg>
                                    </button>
                                </form>

                            </li>
                        </ul>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
