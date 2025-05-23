
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('/logo.png') }}" />
    <title>Actas de Titulación | @yield('title')</title>

    @include('includes.styles')
  </head>
  <body>

    <form method="POST" id="deleteall">
        @csrf
        @method('DELETE')
    </form>

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
