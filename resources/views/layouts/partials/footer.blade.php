<footer class="aquamarine-900 d-flex flex-column justify-content-center align-items-center">
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 justify-content-start">
                <span class="col-md-4 mb-0 text-light">Equipo1© 2024</span>
            </div>

            <div class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto">
                <a href="/" class="">
                    <img src="{{ asset('assets/imagenes/logo.svg') }}" alt="logo" class="logo-header">
                </a>
            </div>

            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item">
                    <a href="{{ route('incidencias.index') }}" class="nav-link px-2 text-light">Inicio</a>
                </li>
                @role('administrador')
                    <li class="nav-item">
                        <a href="{{ route('usuarios.index') }}" class="nav-link px-2 text-light">Administar usuarios</a>
                    </li>
                @endrole
            </ul>
        </footer>
    </div>
</footer>
