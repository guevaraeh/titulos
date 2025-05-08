@extends('main')

@section('title')
<title>Editar Estudiante</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Editar Estudiante</h6>
				</div>
				<div class="card-body">
					
                    <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Nombre(s)</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="exampleFirstName" name="name" value="{{ $student->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Apellido(s)</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="exampleFirstName" name="lastname" value="{{ $student->lastname }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>DNI</b><font color="red">*</font></label>
                            <input type="number" class="form-control" id="exampleFirstName" name="dni" value="{{ $student->dni }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Carrera</b><font color="red">*</font></label>
                            <select class="form-control" name="career-id" aria-label="Default select example">
                                @foreach($careers as $career)
                                <option value="{{ $career->id }}" {{ $student->career_id == $career->id ? 'selected' : '' }} >{{ $career->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Foto</b></label>
                            <input type="file" class="form-control" id="exampleFirstName" name="photo" id="photo" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ session('url_from') }}" class="btn btn-danger">Cancelar</a>
                    </form>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection