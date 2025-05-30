@if(Auth::user())
<nav class="navbar navbar-expand-lg mb-4 topbar bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    {{--<span class="navbar-brand mb-0 h1"><img src="{{ asset('/logo.png') }}" class="img-fluid" alt="Responsive image" width="20" height="20"> Administrador</span>--}}
    <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('/logo.png') }}" class="d-inline-block align-text-top" alt="Inicio" width="20" height="20"> Administrador</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-file-earmark-text"></i> Actas
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('titulation_certificate') }}">Lista</a></li>
            <li><a class="dropdown-item" href="{{ route('titulation_certificate.create') }}">Crear acta</a></li>
            <li><a class="dropdown-item" href="{{ route('titulation_certificate.generate_pdf_empty') }}" target="_blank">Acta vacia</a></li>
            <li><a class="dropdown-item" href="{{ route('titulation_certificate.create_fast') }}">Acta rapida</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-mortarboard"></i> Estudiantes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('student') }}">Lista</a></li>
            <li><a class="dropdown-item" href="{{ route('student.create') }}">Crear estudiante</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('titulation_certificate.search_certificates') }}">
            <i class="bi bi-search"></i> Buscar
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.edit',Auth::user()) }}">
            <i class="bi bi-person"></i> Editar usuario
          </a>
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
@else
<nav class="navbar navbar-expand-lg mb-4 topbar bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">
            <i class="bi-box-arrow-right"></i> Iniciar Sesión
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('titulation_certificate.generate_pdf_empty') }}" target="_blank">
            <i class="bi-card-file-earmark-text"></i> Acta vacia
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('titulation_certificate.create_fast') }}">
            <i class="bi-card-file-earmark-text"></i> Hacer Acta
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
@endif