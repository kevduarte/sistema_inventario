@extends('layouts.plantilla_personal')
@section('title')
:detalles materiales area
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Materiales</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('personal')}}">Materiales</a></li>

              <li class="breadcrumb-item active">detalles</li>
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
  <h2 style= "font-family: 'Segoe UI';">Relación de unidades existentes con el material: {{$material}} </h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">N°</th>
        <th scope="col">CODIGO UNIDAD</th>
      <th scope="col">NOMBRE MATERIAL</th>
      <th scope="col">ESTADO UNIDAD</th>
      <th scope="col">OBSERVACIONES</th>
           
    
    
    </tr>
  </thead>
    <tbody>
  @foreach($unidades as $uni)


      <tr>
        <th> {!! $uni->id_unidad !!} </th>
        <td>{!! $uni->codigo_unidad !!}</td>
        <td>{!! $uni->nombre_material !!}</td>
        <td>{!! $uni->estado !!}</td>
               <td>{!! $uni->observaciones ?? 's/d' !!}</td>
                
    
       
             
           </tr>
            @endforeach

    </tbody>


  
</table>
@if (count($unidades))
  {{ $unidades->links() }}
@endif





</div>





  @endsection


 
