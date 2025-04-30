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
                <h5 class="card-title text-primary">Acta de Titulacion</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th class="col-4">Tipo</th>
                                <td>{{ $types[$titulation_certificate->type] }}</td>
                            </tr>
                            <tr>
                                <th>Nombre del proyecto</th>
                                <td>{{ $titulation_certificate->project_name }}</td>
                            </tr>
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
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="card-title text-primary">Datos de los estudiantes</h5>
            </div>
            <form action="{{ route('titulation_certificate.add_student', $titulation_certificate->id) }}" method="POST">
                @csrf
                <select class="form-select" placeholder="-" name="student-id">
                    @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->lastname . ' ' . $student->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Apellidos y nombres</th>
                                <th>DNI</th>
                                <th>Carrera Profesional</th>
                                <th></th>
                            </tr>
                        </thead>
                            @foreach($titulation_certificate->students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->lastname . ' ' . $student->name }}</td>
                                    <td>{{ $student->dni }}</td>
                                    <td>{{ $student->career }}</td>
                                    <td>
                                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary btn-sm" title="Editar">Editar</a>
                                        <a href="{{ route('titulation_certificate.drop_student', [$titulation_certificate->id, $student->id]) }}" class="btn btn-danger btn-sm" title="Quitar">Quitar</a>
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