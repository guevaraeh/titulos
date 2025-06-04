@extends('main')

@section('title')
Acta de Titulacion
@endsection

<?php $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional']; ?>

@section('content')
<div class="container">
    <div class="row">
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
                    <a href="{{ route('titulation_certificate.generate_pdf', $titulation_certificate->id) }}" target="_blank" class="btn btn-secondary" title="Pdf"><i class="bi-file-earmark-pdf"></i> PDF</a>
                    <a href="{{ route('titulation_certificate.edit', $titulation_certificate->id) }}" class="btn btn-info" title="Editar"><i class="bi-pencil"></i> Editar</a>
                    <button type="button" class="btn btn-danger swalDefaultSuccess" form="deleteall" formaction="{{ route('titulation_certificate.destroy',$titulation_certificate->id) }}" value="" title="Eliminar"><i class="bi-trash"></i> Eliminar Acta</button>
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
                                        <td><img src="{{ asset($student->photo ? 'storage/'.$student->photo : 'no-photo.png') }}" height="40" width="30"></td>
                                        <td><a href="{{ route('student.show', $student->id) }}">{{ $student->lastname . ' ' . $student->name }}</a></td>
                                        <td>{{ $student->dni }}</td>
                                        <td>{{ $student->career->name }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary" title="Editar"><i class="bi-pencil"></i></a>
                                                @if(count($titulation_certificate->students) > 1)
                                                <a href="{{ route('titulation_certificate.drop_student', [$titulation_certificate->id, $student->id]) }}" class="btn btn-danger" title="Quitar"><i class="bi-trash"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            <tbody>
                                
                            </tbody>
                        </table>

                        @if(count($titulation_certificate->students) < 3)
                        <button id="openModalBtn" type="button" class="btn btn-primary"><i class="bi-plus-lg"></i> Agregar Estudiante</button>

                        <form action="{{ route('titulation_certificate.add_student', $titulation_certificate->id) }}" method="POST">
                        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="myModalLabel">Agregar estudiante</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <div class="mb-3">
                                            <select class="form-control" id="career" data-live-search="true" placeholder="- Seleccionar Carrera -">
                                                <option data-placeholder="true" selected disabled></option>
                                                @foreach($careers as $career)
                                                <option value="{{ $career->id }}">{{ $career->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3" id="sel">
                                            <select class="form-control select-student" name="student-id" id="student-id" data-live-search="true" placeholder="- Seleccionar Estudiante -" disabled></select>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Agregar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
</div>
@endsection

@section('javascript')
<script type="text/javascript">

    $('#career').select2({
        dropdownParent: $('#myModal'),
        width: '100%',
        language: 'es',
        theme: 'bootstrap-5',
        placeholder: '- Seleccionar Carrera -',
    });

    $('#openModalBtn').on('click', function () {
        var modal = new bootstrap.Modal(document.getElementById('myModal'));
        modal.show();
        
    });

    selected_sts = @json($titulation_certificate->students->pluck('id')->toArray());

    $('#career').on('change', function() {

        $.ajax({
            method: "POST",
            url: "{{ route('student.get_students_by_career_ajax') }}",
            data: {
                _token: "{{ csrf_token() }}",
                career: $(this).val(),
                //selected_students: @json($titulation_certificate->students->pluck('id')->toArray()),
            },
            success: function(results){
                $("#sel").html('');
                $("#sel").append('<select class="form-control" name="student-id" id="student-id" data-live-search="true" placeholder="- Seleccionar Estudiante -" required><option data-placeholder="true" selected disabled></option></select>');

                results.forEach(function(result) {
                    $("#student-id").append(new Option(result.lastname+' '+result.name, result.id));
                });

                for (let i = 0; i < selected_sts.length; i++) 
                    $('#student-id').find('option[value="'+ selected_sts[i]+'"]').prop('disabled', true);

                $('#student-id').select2({
                    dropdownParent: $('#myModal'),
                    width: '100%',
                    language: 'es',
                    theme: 'bootstrap-5',
                    placeholder: '- Seleccionar Estudiante -',
                });
            },
        });

    });

    $('.swalDefaultSuccess').click(function(){
        Swal.fire({
            title: '¿Esta seguro que desea eliminarlo?',
            text: '',
            showDenyButton: true,
            confirmButtonText: "Si, eliminar",
            denyButtonText: "No, cancelar",
            icon: "warning",
            customClass: {
                confirmButton: 'btn btn-primary',
                denyButton: 'btn btn-danger'
            }
        }).then((result) => {
            if(result.isConfirmed){
                $('#deleteall').attr('action', $(this).attr('formaction'));
                $('#deleteall').submit();
            }
        })
    });

</script>
@endsection