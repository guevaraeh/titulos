<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('/logo.png') }}" />
    @yield('title')
    @include('includes.styles')
  </head>
  <body>
    

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        @include('includes.bar')

        <!-- Contenido de la pagina -->
        @yield('content')



      </div>
    </div>
    @include('includes.scripts')
    @yield('javascript')
    
    @if(Session::has('success'))
    <script type="text/javascript">
    $( document ).ready(function() {
      toastr.success('<strong>¡Exito!</strong><br>'+'{{ session("success") }}');
    });
    </script>
    @endif
  </body>
</html>


{{--
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Sidebar sobre Navbar</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px; /* Altura del navbar */
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: #212529;
            z-index: 1050; /* Mayor que navbar (1030) */
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-brand {
            padding: 1rem;
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            height: 56px; /* Igual que navbar */
        }
        
        .sidebar-brand i {
            margin-right: 10px;
            font-size: 1.5rem;
        }
        
        .sidebar .nav {
            padding: 1rem;
            overflow-y: auto;
            height: calc(100vh - 56px);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            border-radius: 5px;
            margin-bottom: 5px;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background: #0d6efd;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
            padding-left: 270px; /* Sidebar width + 20px */
            transition: all 0.3s;
        }
        
        /* Eliminamos el colapso del navbar */
        .navbar-collapse {
            display: flex !important;
            flex-basis: auto;
        }
        
        .navbar-toggler {
            display: none !important;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .navbar {
                padding-left: 20px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-collapse {
                display: block !important;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar (sobre navbar) -->
    <div class="sidebar" id="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="bi bi-robot"></i>
            <span class="brand-text">MiApp</span>
        </a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-people"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-file-earmark-text"></i> Reportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-bar-chart"></i> Estadísticas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-gear"></i> Configuración
                </a>
            </li>
        </ul>
    </div>

    <!-- Navbar con menú persistente -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler me-2 sidebar-collapse d-lg-none" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menú que no colapsará -->
            <div class="navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>Usuario
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1 class="mb-4">Contenido Principal</h1>
        <div class="card">
            <div class="card-body">
                <p>Este template mantiene las opciones del navbar visibles en todos los tamaños de pantalla.</p>
                <p>El sidebar sigue estando por encima del navbar y mantiene su comportamiento responsive.</p>
                <p>El navbar ahora muestra siempre sus elementos de menú sin colapsarse.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para manejar el sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.sidebar-collapse');
            
            // Toggle sidebar en móvil
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
            
            // Cerrar sidebar al hacer clic fuera en móvil
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickInsideToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickInsideToggle && window.innerWidth < 992) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
--}}