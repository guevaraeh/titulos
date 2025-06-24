@extends('main')

@section('title')
Editar Estudiante
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
            <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
				<div class="card-header py-3">
					<h5 class="card-title text-primary">Editar Estudiante</h5>
				</div>
				<div class="card-body">
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
                            <input type="tel" pattern="[0-9]{8}" placeholder="00000000" class="form-control" id="exampleFirstName" name="dni" value="{{ $student->dni }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Carrera</b><font color="red">*</font></label>
                            <select class="form-control" id="career-id" name="career-id">
                                <option data-placeholder="true" selected disabled></option>
                                @foreach($careers as $career)
                                <option value="{{ $career->id }}" {{ $student->career_id == $career->id ? 'selected' : '' }} >{{ $career->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{--<div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Foto</b></label>
                            <input type="file" class="form-control" id="exampleFirstName" name="photo" id="photo" accept="image/*">
                        </div>--}}
				</div>
                <div class="card-footer py-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ session('url_from') }}" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">

    $('#career-id').select2({
        width: '100%',
        language: 'es',
        theme: 'bootstrap-5',
        placeholder: '- Seleccionar Carrera -',
    });

</script>
@endsection