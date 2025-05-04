@extends('main')

@section('title')
<title>Titulos</title>
@endsection

<?php $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional']; ?>

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Actas de titulacion</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" width="100%" cellspacing="0">
							<thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre del proyecto</th>
                                    <th>Fecha</th>
                                    <th>Estudiantes</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre del proyecto</th>
                                    <th>Fecha</th>
                                    <th>Estudiantes</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($titulation_certificates as $titulation_certificate)
                                <tr>
                                    <td>{{ $types[$titulation_certificate->type] }}</td>
                                    <td>{{ $titulation_certificate->project_name }}</td>
                                    <td>{{ $titulation_certificate->certificate_date }}</td>
                                    <td>
                                    @foreach($titulation_certificate->students as $student)
                                        <li>{{ $student->lastname . ' ' . $student->name }}</li>
                                    @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('titulation_certificate.show', $titulation_certificate->id) }}" class="btn btn-primary btn-sm" title="Ver">Ver</a>
                                        <a href="{{ route('titulation_certificate.edit', $titulation_certificate->id) }}" class="btn btn-info btn-sm" title="Editar">Editar</a>
                                        <a href="{{ route('titulation_certificate.generate_pdf', $titulation_certificate->id) }}" target="_blank" class="btn btn-secondary btn-sm" title="Pdf">PDF</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection