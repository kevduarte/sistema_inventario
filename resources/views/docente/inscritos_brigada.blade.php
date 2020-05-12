@extends('layouts.plantilla_docente')
@section('title')
:gestion de brigadas
@endsection

@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style=" font-family:Helvetica;">Brigada {{$nbrigada->nombre_brigada}} grupo {{$ngrupo}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route ('docente')}}">Docente</a></li>
              <li class="breadcrumb-item active"><a href="{{ route ('brigadas_grupos')}}">grupos</a></li>
              <li class="breadcrumb-item active"><a href="{{ URL::previous() }}">brigadas</a></li>
              <li class="breadcrumb-item active">inscritos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   <div class="container">

@if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('message') }}
    </div>
    @endif
    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
     {{ Session::get('mess') }}
    </div>
    @endif
    
  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Segoe UI';">Lista de estudiantes</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">N°</th>
      <th scope="col">N. CONTROL</th>
      <th scope="col">NOMBRE</th>
       <th scope="col">CARGO</th>

     
      <th colspan="4">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
      @foreach($brig as $indice => $detalles)
       <tr>
              <td >{{$indice+1}}</td>
              <td >{{$detalles->num_control}}</td>
              <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
            
          
                 <td>{{$detalles->cargo}}</a></td>

     <td><a href="/nombrar_jefe/{{ $detalles->id_brigada}}/{{$detalles->num_control}}"><?php if($detalles->cargo!='jefe'){echo '<button type="button" class="btn btn-success btn-sm">Nombrar Jefe  <i class="fa fa-suitcase"></i></button>';}?></a></td>

    

      <td><a href="/cambio_brigada/{{ $detalles->id_brigada}}/{{$detalles->num_control}}">
      <?php $ver= DB::table('detalle_brigadas')
     ->select('detalle_brigadas.id_brigada')
     ->join('brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
     ->join('grupos','grupos.id_grupo','=','brigadas.id_grupo')
     ->where('grupos.id_grupo',$idgrup)
     ->count(); 


     $ver2= DB::table('grupos')
     ->select('grupos.cupo')
     ->where('grupos.id_grupo',$idgrup)
     ->take(1)
     ->first();
     $ver2=$ver2->cupo;
     
if($detalles->cargo!='jefe' && $ver==$ver2){echo '<button type="button" class="btn btn-info btn-sm">Cambiar de brigada  <i class="fa fa-reply"></i></button>';}?></a></td>
             
      
            </tr>
         
         @endforeach
         
           
          
     </tbody>

   

     

  
</table>




@if($brig->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">AÚN NO HAY ESTUDIANTES INSCRITOS</h2>  

 @endif   



</div>



  @endsection
