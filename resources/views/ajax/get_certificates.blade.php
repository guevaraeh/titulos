@if(count($titulation_certificates) > 0)
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre del proyecto</th>
                <th></th>
            </tr>
        </thead>
            @foreach($titulation_certificates as $titulation_certificate)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($titulation_certificate->project_name)
                        {{ $titulation_certificate->project_name }}
                        @else
                        <i>Examen de suficiencia profesional</i>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('titulation_certificate.certificate', $titulation_certificate->remember_token) }}" target="_blank" class="btn btn-secondary" title="Pdf"><i class="bi-file-earmark-pdf"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        <tbody>
            
        </tbody>
    </table>
</div>
@else
<p>No hay actas a su nombre</p>
@endif