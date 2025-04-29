@extends('main')

@section('title')
<title>Titulos</title>
@endsection

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
						<table class="table table-bordered" width="100%" cellspacing="0">
							<thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            	<tr>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                </tr>
                                @foreach($titulation_certificates as $titulation_certificate)
                                <tr>
                                    <td>{{ $titulation_certificate->id }}</td>
                                    <td>{{ $titulation_certificate->type }}</td>
                                    <td>{{ $titulation_certificate->name }}</td>
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