@extends('main')

@section('title')
Estudiantes
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Estudiantes</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" id="datat" width="100%" cellspacing="0">
							<thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>DNI</th>
                                    <th>Carrera Profesional</th>
                                    <th>Nro. de Actas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Foto</th>
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>DNI</th>
                                    <th>Carrera Profesional</th>
                                    <th>Nro. de Actas</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>

                            </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {

    var dt = $('#datat').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        processing: true,
        serverSide: true,
        ajax: "{{ route('student') }}",
        columns: [
            {data:'photo', name:'photo'},
            {data:'lastname', name:'lastname'},
            {data:'name', name:'name'},
            {data:'dni', name:'dni'},
            {data:'career', name:'career'},
            {data:'num_certificates', name:'num_certificates'},
            {data:'actions', name:'actions'},
        ],
    });  
    
    dt.on('draw', function() {
        $('.swalDefaultSuccess').click(function(){
            Swal.fire({
                title: '¿Esta seguro que desea eliminarlo?',
                text: 'Estudiante: '+$(this).val(),
                showDenyButton: true,
                confirmButtonText: "Si, eliminar",
                denyButtonText: "No, cancelar",
                icon: "warning",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    denyButton: 'btn btn-danger'
                }
            }).then((result) => {
                if(result.isConfirmed){
                    $('#deleteall').attr('action', $(this).attr('formaction'));
                    $('#deleteall').submit();
                }
            })
        });
    });

});
</script>
@endsection