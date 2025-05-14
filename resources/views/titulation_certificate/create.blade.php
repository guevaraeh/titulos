@extends('main')

@section('title')
<title>Crear Acta de Titulación</title>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Crear Acta de Titulación</h6>
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
                                    <div class="col-sm-5">
                                        <select class="form-control career" id="career-1" num-data="1" aria-label="Default select example" data-live-search="true" placeholder="- Seleccionar Carrera -">
                                            @foreach($careers as $career)
                                            <option value="{{ $career->id }}">{{ $career->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6" id="sel-1">
                                        <select class="form-control select-student" id="student-1" data-live-search="true" placeholder="- Seleccionar Estudiante -" disabled></select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Fecha</b></label>
                            <input type="text" class="form-control" name="certificate-date" id="cert-date" >
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Observaciones</b></label>
                            <textarea class="form-control" id="validationCustom01" name="remarks"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
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


    new tempusDominus.TempusDominus(document.getElementById("cert-date"), {
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
        option_careers += '<option value="'+career.id+'">'+career.name+'</option>';
    });
    let selected_sts = [];

    $('#career-1').selectpicker();
    
    $('#num-students').on('change', '.select-student', function() {
        selected_sts = [];
        $('select[name="students[]"]').each(function () {
            selected_sts.push($(this).val());
            /*var element = $(this).val();
            console.log('array' ,selected_sts);
            $('[name="students[]"]').each(function() {
                console.log('bucle' ,element);
                console.log('elemento' ,$(this));
                $(this).find('option[value="'+element+'"]').remove();
                $(this).selectpicker('refresh');
            });*/
        });

        /*for (var i=1; i<=num_students; i++) {
            for(var j=0; j<selected_sts.length; j++)
            {
                //$('#student-'+i+' option[value="'+selected_sts[j]+'"]').remove();
                $('#student-'+i).find('[value="'+selected_sts[j]+'"]').remove();
                $('#student-'+i).selectpicker('refresh');
            }
            //$('#student-'+i).selectpicker('refresh');
        }*/
    });

    $('#num-students').on('change', '.career', function() {
        var num_st= $(this).attr('num-data');
        $.ajax({
            method: "POST",
            url: "{{ route('student.get_students_by_career_ajax') }}",
            data: {
                _token: "{{ csrf_token() }}",
                career: $(this).val(),
                selected_students: selected_sts,
            },
            success: function(results){
                $("#sel-"+num_st).html('');
                $("#sel-"+num_st).append('<select class="form-control select-student" id="student-'+num_st+'" name="students[]" data-live-search="true" placeholder="- Seleccionar Estudiante -" required></select>');

                results.forEach(function(result) {
                    $("#student-"+num_st).append(new Option(result.lastname+' '+result.name, result.id));
                });
                $("#student-"+num_st).selectpicker();
            },
        });
    });
    
    //https://www.encodedna.com/2013/07/dynamically-add-remove-textbox-control-using-jquery.htm
    $('#add-student').click(function() {
        if (num_students < 3) 
        {
            num_students = num_students + 1;
            $('#num-students').append(
                '<div id="set-'+num_students+'" class="form-group row mb-3">'+
                    '<div class="col-sm-1">'+
                        '<label class="form-label">Est. '+num_students+'</label>'+
                    '</div>'+
                    '<div class="col-sm-5">'+
                        '<select class="form-control career" id="career-'+num_students+'" num-data="'+num_students+'" aria-label="Default select example" data-live-search="true" placeholder="- Seleccionar Carrera -">'+
                        option_careers
                        +'</select>'+
                    '</div>'+
                    '<div class="col-sm-6" id="sel-'+num_students+'">'+
                        '<select class="form-control select-student" id="student-'+num_students+'" data-live-search="true" placeholder="- Seleccionar Estudiante -" disabled></select>'+
                    '</div>'+
                '</div>'
                );
            $('#career-'+num_students).selectpicker();

            selected_sts = [];
            $('select[name="students[]"]').each(function () {
                selected_sts.push($(this).val());
            });
        }
    });
    $('#del-student').click(function() {
        if (num_students > 1) 
        { 
            $('#set-'+num_students).remove(); 
            num_students = num_students - 1; 
        }
    });
    

    //$('.selectpicker').selectpicker();

});
</script>
@endsection