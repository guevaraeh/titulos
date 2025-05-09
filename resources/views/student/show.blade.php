@extends('main')

@section('title')
<title>Estudiante</title>
@endsection

<?php $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional']; ?>

@section('content')
<div class="container">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="card-title text-primary">Estudiante</h5>
            </div>
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
                                <td>{{ $student->career->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info" title="Editar">Editar</a>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="card-title text-primary">Proyectos</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre del proyecto</th>
                                <th></th>
                            </tr>
                        </thead>
                            @foreach($student->titulation_certificates as $titulation_certificate)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('titulation_certificate.show', $titulation_certificate->id) }}">
                                        @if($titulation_certificate->project_name)
                                        {{ $titulation_certificate->project_name }}
                                        @else
                                        <i>Examen de suficiencia profesional</i>
                                        @endif
                                        </a></td>
                                    <td>
                                        <a href="{{ route('titulation_certificate.generate_pdf', $titulation_certificate->id) }}" target="_blank" class="btn btn-primary" title="Pdf">PDF</a>
                                        <a href="{{ route('titulation_certificate.drop_student', [$titulation_certificate->id, $student->id]) }}" class="btn btn-danger" title="Quitar">Quitar</a>
                                    </td>
                                </tr>
                            @endforeach
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection