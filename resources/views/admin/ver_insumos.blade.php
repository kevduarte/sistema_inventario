@extends('layouts.plantilla_admin')
@section('title')
:ver insumos
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Insumos</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Inicio</a></li>

              <li class="breadcrumb-item active">insumos</li>
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
                      <span class="info-box-text" align="center" >Nombre:</span>
                      <span class="info-box-number" align="center">{{$nombre}}</span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-success">
                    <div class="info-box-content">
                      
                      <span class="info-box-text" align="center" >Total disponible:</span>
                      <span class="info-box-number" align="center">{{$num->total}}
                        <?php if($num->total==1){
                          echo $disponible->medida;
                        }else{ 
                          echo $disponible->medida.'s';
                        }?></span>
                         <div class="progress">
                  <div class="progress-bar" style="width:{{$num->total}}%"></div>
                </div>
                    </div>
                  </div>
                </div>
               
              </div>


                </div>
                </div>


  <table class="table table-bordered" id="font2">
  
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
        <th scope="col">CÓDIGO INSUMO</th>
      
      <th scope="col">ESTADO</th>
      <th colspan="1">Acciones</th>
    
    
    </tr>
  </thead>
    <tbody>
  @foreach($veruni as $indice => $uni)
      <tr>
        <td>{!! $uni->codigo_unidad !!}</td>
        <td>{!! $uni->estado !!}</td>
        

         <td><div class="progress">
                  <div class="progress-bar" style="width:{{$uni->total}}%"></div>
                </div></td>

      

    
         
         
        
    
       
             
           </tr>
            @endforeach

    </tbody>


  
</table>
@if (count($veruni))
  {{ $veruni->links() }}
@endif


@if($veruni->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">No hay registros</h2>  

 @endif  


</div>





  @endsection


 


 
