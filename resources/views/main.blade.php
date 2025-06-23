
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://res.cloudinary.com/dzcmxfodx/image/upload/w_20,h_20/v1750432107/logo_hq0ose.png" />
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

        @yield('content')

      </div>
    </div>
    @include('includes.scripts')
    @yield('javascript')
    
  </body>
</html>
