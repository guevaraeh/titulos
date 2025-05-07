<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acta de Titulación</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      /*font-family: "Arial", sans-serif;*/
      /*font-family: 'Helvetica', 'Arial', sans-serif;*/
      font-family:'Helvetica', sans-serif;
      font-size: 11px;
      margin: 30px;
    }
    .datos{
      font-family:'Arial';
      font-size: 12px;
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

    .titulo-principal {
      font-weight: bold;
      font-size: 14px;
      margin: 6px 0;
     text-align: center;
    }

    .institucion {
      /*font-family: "Arial Narrow", "Arial", sans-serif;*/
      /*font-size: 10px;*/
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
      margin-bottom: 0px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
    }

    th, td {
      border: 1px solid black;
      padding: 3px;
      text-align: center;
      height: 26px;
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
      margin-top: 50px;
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


    .encabezado {
      text-align: center;
      margin-top: 10px;
    }

    .alineacion-imagen td {
      border: none;
      padding: 0;
    }

    .alineacion td {
      border: none;
      padding-left: 0;
      padding-bottom: 10px;
      text-align: left;
    }

    .lineas td {
      border-top: none;
      border-left: none;
      border-right: none;
      padding: 0;
      text-align: left;
    }

  </style>
</head>
<body>


<table width="100%" style="margin-bottom: 10px;" class="alineacion-imagen">
  <tr>
    <td align="left">
      <img src="{{ public_path('/minedu.png') }}" alt="Logo Perú" height="50">
    </td>
    <td align="center" width="55%">
      
    </td>
    <td align="right">
      <img src="{{ public_path('/logo.png') }}" alt="Logo Institución" height="60">
    </td>
  </tr>
</table>


    <div class="institucion">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO</div>
    <div class="titulo">"PEDRO P. DÍAZ"</div>

  <div class="header">
    <div class="institucion" style="text-align: left;">Gerencia Regional de Educación de Arequipa</div>
    <div class="titulo-principal">ACTA DE TITULACIÓN</div>
  </div>

<!--
  <div class="checkboxes">
    <label>Proyecto vinculado a la formación recibida: <span class="box">{{ $titulation_certificate->type == 0 ? 'X' : '' }}</span></label>
    <label>Examen de suficiencia profesional: <span class="box">{{ $titulation_certificate->type == 1 ? 'X' : '' }}</span></label>
  </div>
-->
<table width="100%" class="alineacion">
  <tr>
    <td width="50%">Proyecto vinculado a la formación recibida: <span class="box">{{ $titulation_certificate->type == 0 ? 'X' : '' }}</span></td>
    <td width="50%">Examen de suficiencia profesional: <span class="box">{{ $titulation_certificate->type == 1 ? 'X' : '' }}</span></td>
  </tr>
</table>

<!--
  <div class="line">Nombre del proyecto: <u>{{ $titulation_certificate->project_name }}</u>______________________________________</div>
-->
<table width="100%" class="lineas">
  <tr>
    <td width="17%" style="border-bottom: none;">Nombre del proyecto:</td>
    <td class="datos">{{ $titulation_certificate->project_name }}</td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>


  <div class="seccion">
    <strong>Datos de los Estudiantes:</strong>
    <table>
      <thead>
        <tr>
          <td width="5%">N°</td>
          <td width="35%">Apellidos y Nombres de los <br>Estudiantes</td>
          <td width="15%">D.N.I</td>
          <td width="25%">Carrera Profesional</td>
          <td>Firma</th>
        </tr>
      </thead>
      <tbody>
        <!--
        <tr><td>1</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>2</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>3</td><td></td><td></td><td></td><td></td></tr>
        -->
        @foreach($titulation_certificate->students as $student)
        <tr><td>{{ $loop->iteration }}</td><td class="datos">{{ $student->lastname . ' ' . $student->name }}</td><td class="datos">{{ $student->dni }}</td><td class="datos">{{ $student->career }}</td><td></td></tr>
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
          <td rowspan="2">Estudiantes</td>
          <td colspan="3" style="height: 13px;">Miembro del Jurado</td>
          <td width="15%" rowspan="2">Promedio de Calificación Personal</td>
          <td rowspan="2">Calificación Final Personal<br>(En letras)</td>
        </tr>
        <tr>
          <td style="height: 13px;">Presidente</td>
          <td style="height: 13px;">Secretario</td>
          <td style="height: 13px;">Vocal</td>
        </tr>
      </thead>
      <tbody>
        <tr><td>Estudiante 1</td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Estudiante 2</td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Estudiante 3</td><td></td><td></td><td></td><td></td><td></td></tr>
      </tbody>
    </table>
  </div>

<!--
  <div class="seccion">
    <small>OBSERVACIONES:</small><br>
    <div class="observaciones"><u>{{ $titulation_certificate->remarks }}</u>___________________________________________________________________________________________</div>
  </div>
  -->
  <div class="seccion">
    <small>OBSERVACIONES:</small><br>
    <table width="100%" class="lineas">
      <tr>
        <td class="datos">{{ $titulation_certificate->remarks }}</td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
  </div>

  <div class="lugar-fecha">
    {{-- Arequipa, _____ de ______________ del _______ --}}
    Arequipa, {{ $date }}
  </div>

  <table class="firmas">
    <tr>
      <td style="white-space: nowrap;">_________________________<br>Presidente</td>
      <td></td>
      <td>_________________________<br>Secretario</td>
    </tr>
    <tr>
      <td></td>
      <td>_________________________<br>Vocal</td>
      <td></td>
    </tr>
  </table>

</body>
</html>