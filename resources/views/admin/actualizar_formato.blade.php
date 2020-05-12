@extends('layouts.plantilla_admin')
@section('title')
:actualizar formatos
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Actualizar Formatos</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin') }}">Sistema</a></li>
          <li class="breadcrumb-item active">formatos</li>
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

 <div class="container" id="font1" >
 </br>
   
      <div class="card" style="background-image: url('/image/logos_ito/itofondo.png'); background-size: cover; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF ;" align="center">

         <form method="POST" action="{{ route('actualizar_formato_prueba') }}">
   
      @csrf


      <div class="form-group">

        <div class="form-group col-md-8">
          <label for="frase_cabecera">Frase encabezado</label>
          <input type="text"  value="{{$textos->frase_cabecera}}" class="form-control @error('frase_cabecera') is-invalid @enderror"
          id="frase_cabecera" name="frase_cabecera">
          @error('frase_cabecera')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror
       </div>

        <div class="col-md-12 ">
            <div class="login-or">
             <hr class="hr-or">

           </div>
         </div>

         <br>
         <br>
         <br>

        <div class="form-group" align="left">

       <div class="form-group col-md-6">
        <label for="lema_uno">ATENTAMENTE</label>
        <input type="text" value="{{$textos->lema_uno}}" class="form-control @error('lema_uno') is-invalid @enderror" id="lema_uno" name="lema_uno">
        @error('lema_uno')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>


      <div class="form-group col-md-6">
        <input type="text" value="{{$textos->lema_dos}}" class="form-control @error('lema_dos') is-invalid @enderror" 
        id="lema_dos" name="lema_dos">
         @error('lema_dos')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

  </div>

   

           <br>
         <br>
         <br>

 <div class="col-md-12 ">
            <div class="login-or">
             <hr class="hr-or">

           </div>
         </div>

   <div class="form-group col-md-4">
          <label for="telefono">Teléfono y página oficial</label>
          <input type="text"  value="{{$textos->telefono}}" class="form-control @error('telefono') is-invalid @enderror"
          id="telefono" name="telefono">
          @error('telefono')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror
       </div>

   <div class="form-group col-md-4">
          <input type="text"  value="{{$textos->pagina}}" class="form-control @error('pagina') is-invalid @enderror"
          id="pagina" name="pagina">
          @error('pagina')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror
       </div>
  
 </div>

  <div class="form-group">
   <div class="col-xs-offset-2 col-xs-9" align="center">
    <button type="submit" class="btn btn-primary">actualizar</button>

  </div>
</div>
</form>
 </div>


  

 



</div>

@endsection
