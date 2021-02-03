@extends('layouts.plantilla_estudiante')
@section('title')
:mis brigadas
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Brigadas</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('grupos_disponibles')}}">Grupos</a></li>
          <li class="breadcrumb-item active">mis grupos</li>
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

    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('mess') }}
    </div>
    @endif




<div class="container">



    <div class="table-responsive">

  <table class="table table-bordered" id="font2">
   <h2 style= "font-family: 'Initial';">Mis brigadas :{{$sem}}</h2>
   <thead>
    <tr>
      <th scope="col">GRUPO</th>
      <th scope="col">DOCENTE</th>

      <th scope="col">HORARIO</th>
      <th scope="col">DÍAS DE PRÁCTICA</th>
      <th scope="col">ÁRE DE PRÁCTICA</th>
            <th scope="col">BRIGADA</th>



      
      <th colspan="2">CARGO</th>

     
    </tr>
  </thead>
  <tbody>
    @foreach($dato as $datos)

    <tr>

      <th>{{$datos->grupo}}</th>
      <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>


      <td><?php if(empty($datos->hora_fin)){ echo $datos->hora_inicio;} else{echo date("H:i a", strtotime($datos->hora_inicio)); echo " a "; echo date("H:i a", strtotime($datos->hora_fin));} ?>
    </td>

    <td><?php if($datos->dia_uno==1){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_uno);}?> 
                       <?php if($datos->dia_dos==2){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_dos);}?>  
                       <?php if($datos->dia_tres==3){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_tres);}?>  
                       <?php if($datos->dia_cuatro==4){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cuatro);}?>  
                      <?php if($datos->dia_cinco==5){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cinco);}?> </td>
                              <td>{{$datos->area}}</td>

      <td><span style='height:auto; font-size:15px;' class='right badge badge-success'>{{$datos->nombre_brigada}}</span></td>

    
    <td><?php if($datos->cargo=='miembro'){  echo "<span style='height:auto; font-size:15px;' class='right badge badge-warning'>miembro</span>";  } else{ echo  "<span style='height:auto; font-size:15px;' class='right badge badge-success'>jefe de brigada</span>";}?></td>

    <td><a href="/ver_miembros_jefebrig/{{$datos->id_brigada}}"><?php if ($datos->cargo=='jefe') {
echo "<span style='height:auto; font-size:15px;' class='right badge badge-info'>Ver integrantes</span>";
}
?></a></td>



  </tr>
  @endforeach
</tbody>
</table>
</div>

@if (count($dato))
{{ $dato->links() }}
@endif

@if($dato->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO FORMAS PARTE DE UNA BRIGADA AÚN</h2>  

 @endif   
  
 
</div>



  @endsection
