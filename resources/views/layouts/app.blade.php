<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Almacén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { background-color: #343a40; color: white; min-height: 100vh; padding-top: 2rem; }
        .sidebar .nav-link { color: #adb5bd; transition: color 0.3s; }
        .sidebar .nav-link:hover { color: white; }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                transition: all 0.3s;
                z-index: 1000;
            }
            .sidebar.active {
                left: 0;
            }
            main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block sidebar">
                <div class="sidebar-sticky">
                    <h4 class="text-white text-center mb-4">Menú Principal</h4>
                    <ul class="nav flex-column">
                        @if(Auth::check())
                            @if(Auth::user()->rol_asignado == 'Administrador')
                                <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Gestión de Usuarios</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('categorias.index') }}">Gestión de Categorías</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('productos.index') }}">Gestión de Productos</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Gestión de Clientes</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('ventas.index') }}">Módulo de Venta</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('reportes.index') }}">Módulo de Reportes</a></li>
                            @elseif(Auth::user()->rol_asignado == 'Vendedor')
                                <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Gestión de Clientes</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('ventas.index') }}">Módulo de Venta</a></li>
                            @elseif(Auth::user()->rol_asignado == 'Almacenero')
                                <li class="nav-item"><a class="nav-link" href="{{ route('categorias.index') }}">Gestión de Categorías</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('productos.index') }}">Gestión de Productos</a></li>
                            @endif
                        @endif
                    </ul>
                    <hr class="text-white mt-4">
                    <form class="text-center" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                    </form>
                </div>
            </nav>

            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>