@extends('main')

@section('title')
Buscar Acta de Titulación
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Buscar Acta de Titulación</h6>
				</div>
				<div class="card-body">
					
                    <form>
                        

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Estudiante</b></label>
                            
                            <div id="num-students">
                                <div id="set-1" class="form-group row">
                                    <div class="col-sm-5 mb-3">
                                        <select class="form-control" id="career" aria-label="Default select example" data-live-search="true" placeholder="- Seleccionar Carrera -">
                                            <option data-placeholder="true" selected disabled></option>
                                            @foreach($careers as $career)
                                            <option value="{{ $career->id }}">{{ $career->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-3" id="sel">
                                        <select class="form-control select-student" name="student-id" id="student-id" data-live-search="true" placeholder="- Seleccionar Estudiante -" disabled required></select>
                                    </div>
                                    <div class="col-sm-1 mb-3">
                                        <button type="button" id="search" class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        
                    </form>

                    <div class="mb-3">
                        <div id="get-certificate"></div>
                    </div>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">

    $('#career').select2({
        width: '100%',
        language: 'es',
        theme: 'bootstrap-5',
        placeholder: '- Seleccionar Carrera -',
    });

    $('#career').on('change', function() {

        $.ajax({
            method: "POST",
            url: "{{ route('student.get_students_by_career_ajax') }}",
            data: {
                _token: "{{ csrf_token() }}",
                career: $(this).val(),
            },
            success: function(results){
                $("#sel").html('');
                $("#sel").append('<select class="form-control" name="student-id" id="student-id" placeholder="- Seleccionar Estudiante -" required><option data-placeholder="true" selected disabled></option></select>');

                results.forEach(function(result) {
                    $("#student-id").append(new Option(result.lastname+' '+result.name, result.id));
                });

                $('#student-id').select2({
                    width: '100%',
                    language: 'es',
                    theme: 'bootstrap-5',
                    placeholder: '- Seleccionar Estudiante -',
                });

            },
        });

    });

    

    $('#search').click(function() {
        
        var data = {
                _token: "{{ csrf_token() }}",
                student_id: $('#student-id').val(),
            };
        console.log(data);

        $.ajax({
            method: "POST",
            url: "{{ route('titulation_certificate.get_certificates_ajax') }}",
            data: {
                _token: "{{ csrf_token() }}",
                student_id: $('#student-id').val(),
            },
            success: function(result){
                $("#get-certificate").html('');
                $("#get-certificate").html(result);
            },
            error: function(result){
                $("#get-certificate").html('');
                $("#get-certificate").html(result);
            }
        });

    });

</script>
@endsection