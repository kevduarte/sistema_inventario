@extends('layouts.plantilla_dpto')
@section('title')
:personal registrado
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Personal registrado</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personal</a></li>
              <li class="breadcrumb-item active">lista</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
@if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
    {{ Session::get('message') }}
    </div>
    @endif

   <div class="container">

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Initial';">Lista del personal del departamento de ciencias de la tierra</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE</th>
      <th scope="col">RFC</th>
      <th scope="col">TELÉFONO</th>
      <th scope="col">CORREO</th>
      <th colspan="1">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
       @foreach ($personal as $encargados)
       <tr>
              <th scope="row"> {!! $encargados->nombre !!} {!! $encargados->apellido_paterno !!} {!! $encargados->apellido_materno !!}</th>
              <td>{!! $encargados->rfc !!}</td>
              <td>{!! $encargados->telefono !!}</td>
              <td>{!! $encargados->email !!}</td>
              <td align="center"><a style="color: green;" href="{{ route('actualizar_personas_dpto',$encargados->id_persona)}}" > Actualizar datos</a></td>
            </tr>
         @endforeach
     </tbody>


  
</table>
@if (count($personal))
  {{ $personal->links() }}
@endif


@if($personal->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY PERSONAL REGISTRADO</h2>  
 @endif   

   


</div>

  @endsection
