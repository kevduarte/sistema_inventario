@extends('layouts.plantilla_docente')
@section('title')
: mis grupos
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Mis grupos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('docente')}}">Docente</a></li>
              <li class="breadcrumb-item active">grupos</li>
                            <li class="breadcrumb-item active">mis grupos</li>

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
  <div class="table-responsive">

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family:Initial;">Grupos registrados durante el semestre: {{$detalle}}</h2>
   <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th style="width: auto;;">GRUPO</th>
      <th scope="col">MATERIA</th>
      <th scope="col">CONTRASEÑA</th>
      <th scope="col">CUPO</th>
      <th scope="col">CURSANDO</th>
      <th style=" font-weight:900; " >LUGARES DISPONIBLES</th>
          
            
       <th scope="col">DÍAS</th>
        <th scope="col">ÁREA</th>
       

     
      <th colspan="2">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
       @foreach ($dato as $datos)
       <tr >
              
              <td>{{$datos->grupo}}</td>
              <td>{{$datos->materia}}</td>
              <td style = "color: #000000; font-weight: 900;">{{$datos->clave}}</td>
                <td>{{$datos->cupo}}</td>

                <td><?php $inscritos= ($datos->cupo)-($datos->control_cupo); echo $inscritos;?></td>
                <td>{{$datos->control_cupo}}</td>
                     
                  

                       <td><?php if($datos->dia_uno==1){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_uno);}?> 
                       <?php if($datos->dia_dos==2){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_dos);}?>  
                       <?php if($datos->dia_tres==3){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_tres);}?>  
                       <?php if($datos->dia_cuatro==4){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cuatro);}?>  
                      <?php if($datos->dia_cinco==5){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cinco);}?> </td>
                       <td>{{$datos->area}}</td>
                     
                        

             <td WIDTH="50"><a href="/inscritos_grupo/{{$datos->id_grupo}}/{{$datos->id_docente}}"><button type="button" class="btn btn-info btn-sm">Gestionar</button></a></td>
     
            </tr>
         @endforeach
     </tbody>


  
</table>



@if (count($dato))
  {{ $dato->links() }}
@endif

@if($dato->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO TIENE GRUPOS REGISTRADOS</h2>  

 @endif   


</div>

</div>



  @endsection
