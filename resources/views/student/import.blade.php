@extends('main')

@section('title')
Importar Estudiantes
@endsection

@section('content')
<div class="container">
  <div class="col-lg-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="card-title text-primary">Importar Estudiantes</h5>
      </div>
      <form action="{{ route('student.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="input-group mb-3">
              <input type="file" name="file-students" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
              @error('file-teachers')
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                Incorrecto
              </div>
              @enderror
              <button type="submit" class="btn btn-primary">Subir</button>
              <a href="{{ route('student') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
      </form>

      <div class="card-footer py-3">
      <h6 class="card-title text-primary">Forma de archivo excel</h6>
      <div class="row">
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
              <tr>
                  <th>apellidos</th>
                  <th>nombres</th>
                  <th>dni</th>
                  <th>carrera</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>...</td>
                  <td>...</td>
                  <td>...</td>
                  <td>...</td>
              </tr>
          </tbody>
        </table>
      </div>
      </div>
      </div>

    </div>
  </div>
</div>
@endsection