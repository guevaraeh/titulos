@extends('main')

@section('title')
Lista de Actas Registradas
@endsection

<?php $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional']; ?>

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold">Lista de Actas Registradas</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" id="datat" width="100%" cellspacing="0">
							<thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre del proyecto</th>
                                    <th>Fecha</th>
                                    <th>Estudiantes</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre del proyecto</th>
                                    <th>Fecha</th>
                                    <th>Estudiantes</th>
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
        ajax:"{{ route('titulation_certificate') }}",
        columns: [
            {data:'type', name:'type'},
            {data:'project_name', name:'project_name'},
            {data:'certificate_date', name:'certificate_date'},
            {data:'student_group', name:'student_group'},
            {data:'actions', name:'actions'},
        ],
    });
    
    dt.on('draw', function() {
        $('.swalDefaultSuccess').click(function(){
            Swal.fire({
                title: '¿Esta seguro que desea eliminarlo?',
                text: '',
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