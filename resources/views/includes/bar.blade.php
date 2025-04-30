<nav class="navbar navbar-expand-lg mb-4 topbar bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Administrador</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-mortarboard"></i> Actas
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('titulation_certificate') }}">Lista</a></li>
            <li><a class="dropdown-item" href="{{ route('titulation_certificate.create') }}">Crear acta</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi-card-people"></i> Estudiantes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('student') }}">Lista</a></li>
            <li><a class="dropdown-item" href="{{ route('student.create') }}">Crear estudiante</a></li>
          </ul>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto navbar-right">
        <form id="nav-logout" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="nav-link"><i class="bi-box-arrow-left"></i> Cerrar Sesión</button>
        </form>
      </ul>

    </div>
  </div>
</nav>