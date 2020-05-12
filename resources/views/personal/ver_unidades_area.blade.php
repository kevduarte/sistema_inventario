@extends('layouts.plantilla_personal')
@section('title')
:ver unidades
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Ver unidades</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('personal')}}">Inicio</a></li>

              <li class="breadcrumb-item active">ver unidades</li>
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
    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('mess') }}</strong>
    </div>
    @endif

<div class="row">
              <div class="col-12" >

                <div class="row">
                  <div class="col">
                  <div class="info-box bg-info">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">Nombre:</span>
                      <span class="info-box-number" align="center">{{$nombre}}</span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-info">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">Total de unidades:</span>
                      <span class="info-box-number" align="center">{{$num}}</span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-success">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">Unidades disponibles</span>
                      <span class="info-box-number" align="center" >{{$disponible}}</span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-warning">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">Unidades con baja temporal</span>
                      <span class="info-box-number" align="center">{{$no}}<span>
                    </div>
                  </div>
                </div>
              </div>


                </div>
                </div>


  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'initial';">Relación de unidades existentes con el material: {{$ver}} </h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">CÓDIGO UNIDAD</th>
            <th scope="col">NUM. SERIE</th>
            <th scope="col">DESCRIPCIÓN</th>

      <th scope="col">ESTADO</th>
      <th colspan="3">Acciones</th>
    
    
    </tr>
  </thead>
    <tbody>
  @foreach($veruni as $uni)


      <tr>
        <td>{!! $uni->codigo_unidad !!}</td>
        <td>{!! $uni->num_serie !!}</td>
        <td>{!! $uni->descripcion !!}</td>
        <td>{!! $uni->estado !!}</td>
        
         <td WIDTH="50" style="text-align: center;  " colspan="1" ><a style="color: #306D00;"
         href="{{ route('desactivar_unidad',$uni->codigo_unidad)}}" ><?php if($uni->estado=='disponible'){echo "Baja temporal";}?></a></td>

         <td WIDTH="50" style="text-align: center;  " colspan="1" ><a style="color: #306D00;"
         href="{{ route('activar_unidad',$uni->codigo_unidad)}}" ><?php if($uni->estado=='no disponible'){echo "Activar";}?> </a></td>

          <td WIDTH="50" style="text-align: center;  " colspan="1" ><a style="color: red;"
         href="{{ route('baja_unidad_def',$uni->codigo_unidad)}}" ><?php if($uni->estado=='disponible'){echo "Baja definitiva";}?> </a></td>
      
           </tr>
            @endforeach

    </tbody>


  
</table>
@if (count($veruni))
  {{ $veruni->links() }}
@endif


@if($veruni->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">No hay unidades relacionadas con este material</h2>  

 @endif  


</div>





  @endsection


 


 
