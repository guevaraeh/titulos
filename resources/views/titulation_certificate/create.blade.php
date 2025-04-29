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
					
                    <form action="{{ route('titulation_certificate.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" value="0" checked>
                                <label class="form-check-label" for="flexRadioDefault1">Proyecto vinculado a formación recibida</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" value="1">
                                <label class="form-check-label" for="flexRadioDefault2">Examen de suficiencia profesional</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Nombre del proyecto</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="exampleFirstName" name="project-name" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Estudiantes</b><font color="red">*</font></label>
                            <select class="selectpicker form-control" name="students[]" aria-label="Default select example" multiple data-live-search="true" placeholder="-">
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

@section('javascript')
<script type="text/javascript">
    $('.selectpicker').selectpicker();
</script>
@endsection