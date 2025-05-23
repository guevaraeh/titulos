@extends('main')

@section('title')
Titulación
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Editar titulación</h6>
				</div>
				<div class="card-body">
					
                    <form action="{{ route('titulation_certificate.update', $titulation_certificate->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" value="0" {{ $titulation_certificate->type == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexRadioDefault1">Proyecto vinculado a formación recibida</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" value="1" {{ $titulation_certificate->type == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexRadioDefault2">Examen de suficiencia profesional</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Nombre del proyecto</b><font color="red">*</font></label>
                            @if($titulation_certificate->type == 0)
                            <input type="text" class="form-control" id="project-name" name="project-name" value="{{ $titulation_certificate->project_name }}" required>
                            @else
                            <input type="text" class="form-control" id="project-name" name="project-name" value="" disabled>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Fecha</b></label>
                            <input type="text" class="form-control" name="certificate-date" id="cert-date" value="{{ $titulation_certificate->certificate_date }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>Observaciones</b></label>
                            <textarea class="form-control" id="validationCustom01" name="remarks">{{ $titulation_certificate->remarks }}</textarea>
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
            icons: {
                previous: 'bi bi-chevron-left',
                next: 'bi bi-chevron-right',
                clear: 'bi bi-trash',
            },
            buttons: {
                clear: true,
            },
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

});
</script>
@endsection