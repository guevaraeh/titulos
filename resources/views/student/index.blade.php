@extends('main')

@section('title')
<title>Estudiantes</title>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Estudiantes</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" width="100%" cellspacing="0">
							<thead>
                                <tr>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>DNI</th>
                                    <th>Carrera Profesional</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>DNI</th>
                                    <th>Carrera Profesional</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($students as $student)
                                
                                <tr>
                                    <td>{{ $student->lastname }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->dni }}</td>
                                    <td>{{ $student->career }}</td>
                                    <td>
                                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info btn-sm" title="Editar">Editar</a>
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