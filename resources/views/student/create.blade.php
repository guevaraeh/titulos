@extends('main')

@section('title')
<title>Estudiantes</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Crear Estudiante</h6>
				</div>
				<div class="card-body">
					
                    <form action="{{ route('student.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Nombre(s)</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="exampleFirstName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Apellido(s)</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="exampleFirstName" name="lastname" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>DNI</b><font color="red">*</font></label>
                            <input type="number" class="form-control" id="exampleFirstName" name="dni" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Carrera</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="exampleFirstName" name="career" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection