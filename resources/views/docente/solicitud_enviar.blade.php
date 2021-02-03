@extends('layouts.plantilla_docente')
@section('title')
:solicitar materiale
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style=" font-family:Georgia; font-weight: 900">Materiales disponibles:</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Materiales</a></li>
              <li class="breadcrumb-item active">seleccionar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  


   <div class="container">


@if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Initial';">Relación de materiales registrados en el laboratorio</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">CODIGO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">MODELO</th>
      <th scope="col">TIPO</th>
      <th scope="col">MARCA</th>
      <th scope="col">DISPONIBILIDAD</th>
      <th colspan="1">ACCIONES</th>
    </tr>
  </thead>
    <tbody>
    @foreach($mate as $material)
    <tr>
      <th>{!! $material->id_material !!}</th>
              <td>{!! $material->nombre_material !!}</td>
              <td>{{ $material->modelo ?? 's/n' }} </td>
                 <td>{!! $material->tipo !!}</td>
                                  <td>{!! $material->marca !!}</td>

                        <td>{!! $material->n_unidades !!}</td>
                        <td>
                        <div class="form-check">
  <input type="checkbox" name="check4" id="bnombre" value="{{$material->id_material}}" class="form-check-input" oninput="mostrar_id_material();" onclick="myFunction()">
</div> </td>
              
        
     
      
        
          
    </tr>

  @endforeach
   
  </tbody>

  
</table>
{{ $mate->links() }}



</div>

<form method="POST" action="{{ route('nuevo_vale') }}" >


        @csrf
    <input type="text" class="form-control @error('id_material') is-invalid @enderror"  id="id_material" name="id_material" >


 <div class="form-group">
     <div class="col-xs-offset-2 col-xs-9" align="center">
      <button type="submit" class="btn btn-primary" id="check">Registrar</button>

    </div>
  </div>

</form>

   


  @endsection
<script type="text/javascript">


  function myFunction() {
  // Get the checkbox
  var checkBox = document.getElementById("bnombre");
  // Get the output text
  var text = document.getElementById("id_material");

   const checar = document.getElementById('bnombre').value;


  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    text.value = checar;
  } else {
    document.getElementById('id_material').value ="";
  }
}
</script>