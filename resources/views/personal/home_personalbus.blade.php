@extends('layouts.plantilla_personal')
@section('title')
: Inicio personal
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Bienvenido </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personal</a></li>
              <li class="breadcrumb-item active">Inicio</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

      @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

<div class="container" id="font4">
   <h2 style= "font-family: 'Segoe UI';">Relación de materiales del area de: {{$arean->area}}</h2>

     <div class="form-row">
       <div class="form-group col-sm-4" >

           <form action="{{route ('buscar_material_homep')}}" method="POST">
             {{ csrf_field() }}
             <div class="form-row">
               <div class="input-group ">
                <input type="text" class="form-control" name="buscador" required autofocus placeholder="ingrese el nombre"><p>&nbsp;</p>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><span>&nbsp;
                    <i class="fa fa-search" ></i></span>
                  </button>
                </span>
              </div>
            </div>
          </form>
        </div>

@if(isset($info))
<table class="table table-bordered" id="font5">
  
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">CODIGO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">N.SERIE</th>
      <th scope="col">ÁREA</th>
       <th scope="col">TIPO</th>
      <th colspan="4">ACCIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach($info as $material)
    <tr>
      <th>{!! $material->id_material !!}</th>
              <td>{!! $material->nombre_material !!}</td>
              <td>{{ $material->num_serie ?? 's/n'  }}</td>
                 <td>{!! $material->area !!}</td>
                 <td>{!! $material->tipo !!}</td>
                 
              <td style="text-align: center;  " colspan="1"><a style="color: #306D00;" 
      href="{{ route('ver_unidades_area',$material->id_material )}}">Ver unidades <i class="fa fa-eye"></i></a></td>
     
      
        
          
    </tr>

  @endforeach
   
  </tbody>



  
</table>
@if (count($info))
       {{ $info->links() }}
     @endif
     @endif

 </div>


</div>





  @endsection