@extends('layouts.plantilla_admin')
@section('title')
:ver eliminados
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Reporte baja definitiva</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="#">Reportes</a></li>

              <li class="breadcrumb-item active"><a href="{{ route('reporte_eliminados')}}">baja definitiva</a></li>
              <li class="breadcrumb-item active">ver</li>
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
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Nombre:</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$nombre}}</span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Área:</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$num->area}}</span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Categoría:</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$disponible->tipo}}</span>
                    </div>
                  </div>
                </div>
                 <div class="col">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Eliminadas:</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$no}}</span>
                    </div>
                  </div>
                    
                  </div>
              
              </div>


                </div>
                </div>


  <table class="table table-bordered" id="font2">
  <h2  style= "font-family: 'initial';">Relación de unidades eliminadas con el material: {{$ver}} </h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
        <th scope="col">CODIGO UNIDAD</th>
    
      <th scope="col">ESTADO</th>
      <th scope="col">FECHA BAJA</th>
      <th colspan="1">Reportes</th>
    
    
    </tr>
  </thead>
    <tbody>
  @foreach($veruni as $uni)


      <tr>
        <td>{!! $uni->codigo_unidad !!}</td>
       
        <td>{!! $uni->estado !!}</td>
                <td>{{ date('j-M-y', strtotime($uni->updated_at))}} </td>

         
      

          <td WIDTH="50"><a href="/baja_definitiva_reporte/{{$uni->codigo_unidad}}/{{$uni->id_material}}" target="_blank"><button type="button" class="btn btn-info btn-sm">Generar</button></a></td>


    
         
         
        
    
       
             
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


 


 
