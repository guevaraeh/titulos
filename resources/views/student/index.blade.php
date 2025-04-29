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
						<table class="table table-bordered" width="100%" cellspacing="0">
							<thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($students as $student)
                                
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->lastname }}</td>
                                    <td>{{ $student->name }}</td>
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