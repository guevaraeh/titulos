@extends('main')

@section('title')
<title>Crear Acta de Titulación rápida</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Crear Acta de Titulación rápida</h6>
				</div>
				<div class="card-body">
					
                    <small>Nota: No se guardarán los registros, es solo para generar un acta con datos</small><hr>

                    <form action="{{ route('titulation_certificate.generate_pdf_fast') }}" method="POST" target="_blank">
                        @csrf
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" value="0" checked>
                                <label class="form-check-label" for="flexRadioDefault1">Proyecto vinculado a formación recibida</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" value="1">
                                <label class="form-check-label" for="flexRadioDefault2">Examen de suficiencia profesional</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Nombre del proyecto</b><font color="red">*</font></label>
                            <input type="text" class="form-control" id="project-name" name="project-name" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Estudiantes</b><font color="red">*</font></label>
                            
                            <button type="button" id="add-student" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i></button>
                            <button type="button" id="del-student" class="btn btn-danger btn-sm"><i class="bi bi-dash-lg"></i></button>
                            
                            <div id="num-students">
                                <div id="set-1" class="form-group row mb-3">
                                    <div class="col-sm-1">
                                        <label class="form-label">Est. 1</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="students[0][lastname]" id="lastname-1" placeholder="Apellidos" required>
                                        <input type="text" class="form-control" name="students[0][name]" id="name-1" placeholder="Nombres" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control career" name="students[0][career][name]" id="career-1" num-data="1" aria-label="Default select example" data-live-search="true" placeholder="- Seleccionar Carrera -">
                                            <option data-placeholder="true">- Seleccionar Carrera -</option>
                                            @foreach($careers as $career)
                                            <option value="{{ $career->name }}">{{ $career->name }}</option>
                                            @endforeach
                                            <option value="">Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" name="students[0][dni]" id="dni-1" placeholder="DNI" required>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Fecha</b></label>
                            <input type="text" class="form-control" id="certificate-date" name="certificate-date" >
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Observaciones</b></label>
                            <textarea class="form-control" id="remarks" name="remarks"></textarea>
                        </div>

                        <button type="submit" id="generate" class="btn btn-primary">Generar</button>
                        <a href="{{ route('titulation_certificate') }}" class="btn btn-danger">Cancelar</a>
                    </form>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {

    $('input[name="type"]').change(function(){
        if($(this).val() == 1)
        {
            $('#project-name').prop('required', false);
            $('#project-name').prop('disabled', true);
        }
        else
        {
            $('#project-name').prop('disabled', false);
            $('#project-name').prop('required', true);
        }
    });

    new tempusDominus.TempusDominus(document.getElementById("certificate-date"), {
        useCurrent: false,
        display: {
            //icons: iconsDate,
            viewMode: 'calendar',
            components: {
              clock: false,
              decades: false,
              year: true,
              month: true,
              date: true,
            },
        },
        localization: {
            locale: 'es',
            format: "yyyy-MM-dd"
        },
    });

    var num_students = 1;
    var careers = @json($careers);
    var option_careers = ''
    careers.forEach(function(career) {
        option_careers += '<option value="'+career.name+'">'+career.name+'</option>';
    });

    //$('#career-1').selectpicker();
    new SlimSelect({
        select: '#career-1',
        settings: {
            searchPlaceholder: 'Buscar',
            searchText: 'Sin resultados',
            searchingText: 'Buscando...',
        },
    });
    
    $('#add-student').click(function() {
        if (num_students < 3) 
        {
            num_students = num_students + 1;
            $('#num-students').append(
                '<div id="set-'+num_students+'" class="form-group row mb-3">'+
                    '<div class="col-sm-1">'+
                        '<label class="form-label">Est. '+num_students+'</label>'+
                    '</div>'+
                    '<div class="col-sm-6">'+
                        '<div class="input-group">'+
                        '<input type="text" class="form-control" name="students['+(num_students-1)+'][lastname]" id="lastname-'+num_students+'" placeholder="Apellidos" required>'+
                        '<input type="text" class="form-control" name="students['+(num_students-1)+'][name]" id="name-'+num_students+'" placeholder="Nombres" required>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-sm-3">'+
                        '<select class="form-control career" name="students['+(num_students-1)+'][career][name]" id="career-'+num_students+'" num-data="'+num_students+'" aria-label="Default select example" data-live-search="true" placeholder="- Seleccionar Carrera -">'+
                            '<option data-placeholder="true">- Seleccionar Carrera -</option>'+
                            option_careers+
                            '<option value="">Otro</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="col-sm-2">'+
                        '<input type="number" class="form-control" name="students['+(num_students-1)+'][dni]" id="dni-'+num_students+'" placeholder="DNI" required>'+
                    '</div>'+

                '</div>'
                );
            //$('#career-'+num_students).selectpicker();
            new SlimSelect({
                select: '#career-'+num_students,
                settings: {
                    searchPlaceholder: 'Buscar',
                    searchText: 'Sin resultados',
                    searchingText: 'Buscando...',
                },
            });

            /*selected_sts = [];
            $('select[name="students[]"]').each(function () {
                selected_sts.push($(this).val());
            });*/
        }
    });
    $('#del-student').click(function() {
        if (num_students > 1) 
        { 
            $('#set-'+num_students).remove(); 
            num_students = num_students - 1; 
        }
    });
    

});
</script>
@endsection