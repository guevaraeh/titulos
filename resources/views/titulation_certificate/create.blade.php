@extends('main')

@section('title')
<title>Titula</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Crear titulación</h6>
				</div>
				<div class="card-body">
					
                    <form action="{{ route('student.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Tipo</b><font color="red">*</font></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">Proyecto vinculado a formación recibida</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">Examen de suficiencia profesional</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Nombre del proyecto</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="exampleFirstName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Estudiantes</b><font color="red">*</font></label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>-</option>
                                @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->lastname . ' ' . $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Observaciones</b></label>
                            <textarea class="form-control" id="validationCustom01" name="remarks"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection