@extends('layouts.plantilla_admin')
@section('title')
: Foto ito
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family:Lucida Sans Unicode; font-weight: 900;">Actualizar escudo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route ('admin')}}">Administrador</a></li>
              <li class="breadcrumb-item active">escudo</li>
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

<div class="table-responsive" id="font5">
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <td scope="col"> 
     
        
                        <form class="form-horizontal" method="POST" action="" validate  enctype="multipart/form-data" data-toggle="validator">
                            {{ csrf_field() }}                                                                 

                          
                              <span style="color: #000000"> </span>
                             
                               
                                
                          
                             <br /> <br />
                            <div class="form-group" align="center">
                                <div class="col-md-12 col-md-offset-12">
                                    <button type="submit" class="btn btn-primary">
                                       Actualizar Foto
                                    </button>
                                </div>
								</div>
                            
                        </form>
						 </td>
             <td scope="col" align="center">

    

               <p style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">Actualizar escudo oficial</p>
               <h1 style="color: #0B173B; font-size: 19px;"><strong>Instrucciones</strong> </h1>
               <p  align="left">
                
     </p>

   </td>
	  </tr>
  </thead>
  <tbody>
    <tr> 
    </tr>
	</tbody>
</table>
</div>

</div>

  @endsection
