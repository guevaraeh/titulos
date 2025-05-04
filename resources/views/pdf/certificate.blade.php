<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acta de Titulación</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      font-family: "Arial", sans-serif;
      font-size: 11px;
      margin: 30px;
    }

    .header {
      text-align: center;
      margin-bottom: 10px;
    }

    .header img {
      width: 60px;
      height: auto;
    }

    .titulo {
      font-weight: bold;
      margin: 5px 0;
	  text-align: center;
    }

    .institucion {
      font-family: "Arial Narrow", Arial, sans-serif;
      font-size: 10px;
      margin-top: 4px;
	  text-align: center;
    }

    .checkboxes {
      margin-top: 20px;
    }

    .checkboxes span {
      margin-right: 50px;
    }

    .line {
      margin: 10px 0;
    }

    .seccion {
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid black;
      padding: 5px;
      text-align: center;
    }

    .observaciones {
      height: 60px;
      /*border: 1px solid black;*/
      margin-top: 20px;
    }

    .firmas {
      margin-top: 50px;
      width: 100%;
      text-align: center;
    }

    .firmas td {
      border: none;
      padding-top: 30px;
    }

    .lugar-fecha {
      margin-top: 20px;
	  text-align: right;
    }

    .bold {
      font-weight: bold;
    }
	.box {
	  display: inline-block;
	  width: 12px;
	  height: 12px;
	  border: 1px solid #000;
	  margin-right: 5px;
	  font-size: 10px;
	  line-height: 12px;
	  text-align: center;
	  vertical-align: middle;
	  font-weight: bold;
	}

  .logo-izquierda {
      position: relative;
      top: 0;
      left: 0;
      height: 50px;
    }

    .logo-derecha {
      position: absolute;
      top: 0;
      right: 0;
      height: 50px;
    }

    .encabezado {
      text-align: center;
      margin-top: 10px;
    }

    .alineacion td {
      border: none;
      padding: 0;
    }

  </style>
</head>
<body>


<table width="100%" style="margin-bottom: 10px;" class="alineacion">
  <tr>
    <td align="left">
      <img src="{{ public_path('/minedu.png') }}" alt="Logo Perú" height="50">
    </td>
    <td align="center" width="55%">
      
    </td>
    <td align="right">
      <img src="{{ public_path('/logo.png') }}" alt="Logo Institución" height="50">
    </td>
  </tr>
</table>

  {{--
  <img src="{{ public_path('/minedu.png') }}" class="logo-izquierda" alt="Logo Perú">
  <img src="{{ public_path('/logo.png') }}" class="logo-derecha" alt="Logo Institución">
  --}}

    <div class="institucion">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO</div>
    <div class="titulo">"PEDRO P. DÍAZ"</div>

  <div class="header">
    <div class="institucion" style="text-align: left;">Gerencia Regional de Educación de Arequipa</div>
    <div class="titulo">ACTA DE TITULACIÓN</div>
  </div>


  <div class="checkboxes">
    <label>Proyecto vinculado a la formación recibida: <span class="box">{{ $titulation_certificate->type == 0 ? 'X' : '' }}</span></label>
    <label>Examen de suficiencia profesional: <span class="box">{{ $titulation_certificate->type == 1 ? 'X' : '' }}</span></label>
  </div>

  <div class="line"><strong>Nombre del proyecto: </strong> {{ $titulation_certificate->project_name }}</div>

  <div class="seccion">
    <strong>Datos de los Estudiantes:</strong>
    <table>
      <thead>
        <tr>
          <th width="5%">N°</th>
          <th width="30%">Apellidos y Nombres de los Estudiantes</th>
          <th>D.N.I</th>
          <th>Carrera Profesional</th>
          <th>Firma</th>
        </tr>
      </thead>
      <tbody>
        {{--
        <tr><td>1</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>2</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>3</td><td></td><td></td><td></td><td></td></tr>
        --}}
        @foreach($titulation_certificate->students as $student)
        <tr><td>{{ $loop->iteration }}</td><td>{{ $student->lastname . ' ' . $student->name }}</td><td>{{ $student->dni }}</td><td>{{ $student->career }}</td><td></td></tr>
        @endforeach
        
        @if($count_students < 1)
        <tr><td>1</td><td></td><td></td><td></td><td></td></tr>
        @endif
        @if($count_students < 2)
        <tr><td>2</td><td></td><td></td><td></td><td></td></tr>
        @endif
        @if($count_students < 3)
        <tr><td>3</td><td></td><td></td><td></td><td></td></tr>
        @endif

      </tbody>
    </table>
  </div>

  <div class="seccion">
    <strong>Calificación del Jurado:</strong>
    <table>
      <thead>
        <tr>
          <th rowspan="2">Estudiantes</th>
          <th colspan="3">Miembro del Jurado</th>
          <th width="15%" rowspan="2">Promedio de Calificación Personal</th>
          <th rowspan="2">Calificación Final Personal<br>(En letras)</th>
        </tr>
        <tr>
          <th>Presidente</th>
          <th>Secretario</th>
          <th>Vocal</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Estudiante 1</td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Estudiante 2</td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Estudiante 3</td><td></td><td></td><td></td><td></td><td></td></tr>
      </tbody>
    </table>
  </div>

  <div class="seccion">
    <strong>Observaciones:</strong>
    <div class="observaciones">___________________________________________________________________________________________</div>
  </div>

  <div class="lugar-fecha">
    {{-- Arequipa, _____ de ______________ del _______ --}}
    Arequipa, {{ $date }}
  </div>

  <table class="firmas">
    <tr>
      <td>_________________________<br>Presidente</td>
      <td>_________________________<br>Secretario</td>
    </tr>
  </table>

</body>
</html>