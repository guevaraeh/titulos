@extends('main')

@section('title')
Estudiante
@endsection

<?php $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional']; ?>

@section('content')
<div class="container">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th class="col-4">Apellidos</th>
                                <td>{{ $student->lastname }}</td>
                            </tr>
                            <tr>
                                <th>Nombres</th>
                                <td>{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <th>DNI</th>
                                <td>{{ $student->dni }}</td>
                            </tr>
                            <tr>
                                <th>Carrera profesional</th>
                                <td>{{ $student->career ? $student->career->name : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="card-footer py-3">
                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info" title="Editar"><i class="bi-pencil"></i> Editar</a>
                <button type="button" class="btn btn-danger swalDefaultSuccess" form="deleteall" formaction="{{ route('student.destroy',$student->id) }}" value="{{ $student->lastname .' '. $student->name }}" title="Eliminar"><i class="bi-trash"></i> Eliminar</button>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Actas</h6>
            </div>

            <div class="card-body">
                @if(count($student->titulation_certificates) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre del proyecto</th>
                                <th>Fecha</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($student->titulation_certificates as $titulation_certificate)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('titulation_certificate.show', $titulation_certificate->id) }}">
                                    @if($titulation_certificate->project_name)
                                    {{ $titulation_certificate->project_name }}
                                    @else
                                    <i>Examen de suficiencia profesional</i>
                                    @endif
                                    </a>
                                </td>
                                <td>
                                    @if($titulation_certificate->certificate_date)
                                    {{ $titulation_certificate->certificate_date }}
                                    @else
                                    <i>No fijado</i>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('titulation_certificate.generate_pdf', $titulation_certificate->id) }}" target="_blank" class="btn btn-secondary" title="Pdf"><i class="bi-file-earmark-pdf"></i></a>
                                        <a href="{{ route('titulation_certificate.edit', $titulation_certificate->id) }}" class="btn btn-info" title="Editar"><i class="bi-pencil"></i></a>
                                        {{--<a href="{{ route('titulation_certificate.drop_student', [$titulation_certificate->id, $student->id]) }}" class="btn btn-danger" title="Quitar"><i class="bi-trash"></i></a>--}}
                                        <button type="button" class="btn btn-danger swaldrop" form="deleteall" formaction="{{ route('titulation_certificate.drop_student', [$titulation_certificate->id, $student->id]) }}" value="{{ $loop->iteration }}" class="btn btn-danger" title="Quitar"><i class="bi-trash"></i></button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    @if(!$student->career)
                    <p>No se le puede asignar acta</p>
                    @else
                    <p>No tiene actas registradas</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">

    $('.swalDefaultSuccess').click(function(){
        Swal.fire({
            title: '¿Esta seguro que desea eliminarlo completamente?',
            text: 'Estudiante: '+$(this).val(),
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

    $('.swaldrop').click(function(){
        Swal.fire({
            title: '¿Esta seguro que desea quitarlo?',
            html: 'Acta N°'+$(this).val()+'<br><small>(Se puede volver a asignar)</small>',
            showDenyButton: true,
            confirmButtonText: "Si, quitar",
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