@extends('main')

@section('title')
<title>Acta de Titulacion</title>
@endsection

<?php $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional']; ?>

@section('content')
<div class="container">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="card-title text-primary">Acta de Titulación</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th class="col-4">Tipo</th>
                                <td>{{ $types[$titulation_certificate->type] }}</td>
                            </tr>
                            @if(!$titulation_certificate->type)
                            <tr>
                                <th>Nombre del proyecto</th>
                                <td>{{ $titulation_certificate->project_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Fecha</th>
                                <td>{{ $date }}</td>
                            </tr>
                            <tr>
                                <th>Observaciones</th>
                                <td>{{ $titulation_certificate->remarks }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('titulation_certificate.generate_pdf', $titulation_certificate->id) }}" target="_blank" class="btn btn-secondary" title="Pdf">PDF</a>
                <a href="{{ route('titulation_certificate.edit', $titulation_certificate->id) }}" class="btn btn-info" title="Editar">Editar</a>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="card-title text-primary">Datos de los estudiantes</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Foto</th>
                                <th>Apellidos y nombres</th>
                                <th>DNI</th>
                                <th>Carrera Profesional</th>
                                <th></th>
                            </tr>
                        </thead>
                            @foreach($titulation_certificate->students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($student->photo ? 'storage/'.$student->photo : 'no-photo.png') }}" height="50" width="40"></td>
                                    <td>{{ $student->lastname . ' ' . $student->name }}</td>
                                    <td>{{ $student->dni }}</td>
                                    <td>{{ $student->career->name }}</td>
                                    <td>
                                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary btn-sm" title="Editar">Editar</a>
                                        <a href="{{ route('titulation_certificate.drop_student', [$titulation_certificate->id, $student->id]) }}" class="btn btn-danger btn-sm" title="Quitar">Quitar</a>
                                    </td>
                                </tr>
                            @endforeach
                        <tbody>
                            
                        </tbody>
                    </table>

                    @if(count($titulation_certificate->students) < 3)
                    <button id="openModalBtn" type="button" class="btn btn-primary">Agregar Estudiante</button>

                    <form action="{{ route('titulation_certificate.add_student', $titulation_certificate->id) }}" method="POST">
                    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Agregar estudiante</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <select class="selpick form-control" placeholder="- Selecciona estudiante -" name="student-id" id="student-id" data-live-search="true">
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    //$('.selectpicker').selectpicker();

    var data_on = false;
    $('#openModalBtn').on('click', function () {

        if(!data_on)
        {
            $.ajax({
                method: "POST",
                url: "{{ route('student.get_students_ajax') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    selected_students: @json($titulation_certificate->students->pluck('id')->toArray()),
                },
                success: function(results){
                    //$('#student-select').html(result);
                    results.forEach(function(result) {
                        $("#student-id").append(new Option(result.lastname+' '+result.name, result.id));
                    });
                    $('.selpick').selectpicker();
                }
            });
        }
        data_on = true;

        var modal = new bootstrap.Modal(document.getElementById('myModal'));
        modal.show();
    });

</script>
@endsection