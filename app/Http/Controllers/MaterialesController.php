<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\Tipo;
use App\Unidad;
use App\Semestre;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class MaterialesController extends Controller
{


    public function registrar_materiales(Request $request)
    { 
        $this->validate($request, ['id_material' => ['required', 'unique:materiales'],
            'num_serie' => ['required', 'unique:unidades']]);

      $data = $request;
      $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();
      $periodo_semestre=$periodo_semestre->id_semestre;


       $ver=$data['id_material'];
       $insumo=433055;

       if($ver==$insumo){

         $this->validate($request, [
            'marca' => ['required'],
            'total' => ['required'],
            'medida' => ['required'],

       ]);


        $checa=DB::table('materiales')
        ->select('materiales.id_material')
        ->where([['materiales.nombre_material','=',$data['nombre_material']],['materiales.marca','=',$data['marca']]])
        ->take(1)
        ->first();

        if(empty($checa)){

    $numero=random_int(100000,999999);
    $clave_inicio= $data['id_material'].$numero;
    
    function ean13_checksum ($message) {
      $checksum = 0;
      foreach (str_split(strrev($message)) as $pos => $val) {
        $checksum += $val * (3 - 2 * ($pos % 2));
      }
      return ((10 - ($checksum % 10)) % 10);
    }
    $ean=$clave_inicio;
    $digito=ean13_checksum($ean);
    $valor_mate=$clave_inicio.$digito;

      if(empty($data['clave'])){

        $data['clave']='s/c';

      }
      if(empty($data['modelo'])){

        $data['modelo']='s/m';

      }
      if(empty($data['num_serie'])){

       $data['num_serie']='s/n';     
     }
     if(empty($data['marca'])){
      $data['marca']='s/m';

    }
    if(empty($data['tipo'])){
      $data['tipo']=330;

    }
    if(empty($data['area'])){
      $data['area']=55;

    }
     if(empty($data['descripcion'])){
      $data['descripcion']='s/d';

    }

    $nuevo_mat = new Material();
    $nuevo_mat->id_material = $valor_mate;
    $nuevo_mat->nombre_material = $data['nombre_material'];
    $nuevo_mat->clave = $data['clave'];
    $nuevo_mat->modelo = $data['modelo'];
    $nuevo_mat->id_tipo = $data['tipo'];
    $nuevo_mat->marca = $data['marca'];
    $nuevo_mat->id_area = $data['area'];
    
    $nuevo_mat->id_semestre=$periodo_semestre;
    $nuevo_mat->save();

     if($nuevo_mat->save()){

      $contar= DB::table ('unidades')
      ->select('unidades.id_unidad','unidades.id_material','materiales.id_material')
      ->join('materiales','materiales.id_material','=','unidades.id_material')
      ->where('materiales.id_material','=',$valor_mate)
      ->count();

      $estadoi='disponible';

      if(empty($data['cantidad'])){

        $data['cantidad']=1;
      }

      if(empty($data['total'])){

        $data['total']=1;
      }

       if(empty($contar)){

   $conta=$data['cantidad'];
   for ($i = 1; $i <= $conta; $i++) {

    $modelx=new Unidad;
    $modelx->indice=$i;
    $modelx->id_material=$valor_mate;
    $modelx->codigo_unidad=$valor_mate.'-'.$i;
    $modelx->estado=$estadoi;
    $modelx->medida=$data['medida'];
    $modelx->num_serie = $data['num_serie'];
    $modelx->descripcion = $data['descripcion'];
    $modelx->total=$data['total'];
    $modelx->save();

   
}

    Session::flash('message','¡Material agregado con éxito!');
        //return redirect()->route('ver_unidades', ['id_material' => $valor_mate]);

   return redirect()->route('departamento');
    
     }

      
}   
        }

         $checa=DB::table('materiales')
        ->select('materiales.id_material')
        ->where([['materiales.nombre_material','=',$data['nombre_material']],['materiales.marca','=',$data['marca']]])
        ->take(1)
        ->first();
        $checa=$checa->id_material;


        $contar= DB::table ('unidades')
      ->select('unidades.total')
      ->join('materiales','materiales.id_material','=','unidades.id_material')
      ->where('materiales.id_material','=',$checa)
      ->take(1)
      ->first();

      $contar=$contar->total;

      $estadoi='disponible';

       if(empty($data['cantidad'])){

        $data['cantidad']=1;
      }


       if(empty($contar)){

        DB::table('unidades')
     ->where('id_material', $checa)
     ->update(['total' =>$data['total']]);
     Session::flash('message','¡Material agregado con éxito!');
             return redirect()->route('ver_unidades', ['id_material' => $checa]);

     //return redirect()->route('admin');
    
     } else {

      $suma=$data['total']+$contar;

      DB::table('unidades')
     ->where('id_material', $checa)
     ->update(['total' =>$suma]);
     Session::flash('message','¡Material agregado con éxito!');
             return redirect()->route('ver_unidades', ['id_material' => $checa]);

     //return redirect()->route('admin');
     }
     //Session::flash('message','Unidades agregadas.');
            

}
//insumos
$producto=DB::table('materiales')
->select('materiales.id_material')
->where([['materiales.nombre_material','=',$data['nombre_material']],['materiales.marca','=',$data['marca']],
  ['materiales.modelo','=',$data['modelo']]])
  ->take(1)
  ->first();

  if(empty($producto)){

    $this->validate($request, [
            'num_serie' => ['required'],
             'area' => ['required'],
              'tipo' => ['required']
       ]);

     $numero=random_int(100000,999999);

    $clave_inicio= $data['id_material'].$numero;
    
    function ean13_checksum ($message) {
      $checksum = 0;
      foreach (str_split(strrev($message)) as $pos => $val) {
        $checksum += $val * (3 - 2 * ($pos % 2));
      }
      return ((10 - ($checksum % 10)) % 10);
    }
    $ean=$clave_inicio;

    $digito=ean13_checksum($ean);

    $valor_mate=$clave_inicio.$digito;

      if(empty($data['clave'])){

        $data['clave']='s/c';

      }
      if(empty($data['modelo'])){

        $data['modelo']='s/m';

      }
      if(empty($data['num_serie'])){

       $data['num_serie']='s/n';     
     }
     if(empty($data['marca'])){
      $data['marca']='s/m';

    }
    if(empty($data['tipo'])){
      $data['tipo']=330;

    }
    if(empty($data['area'])){
      $data['area']=55;

    }
    if(empty($data['descripcion'])){
      $data['descripcion']='s/d';

    }

    $nuevo_mat = new Material();
    $nuevo_mat->id_material = $valor_mate;
    $nuevo_mat->nombre_material = $data['nombre_material'];
    $nuevo_mat->clave = $data['clave'];
    $nuevo_mat->modelo = $data['modelo'];
    
    $nuevo_mat->id_tipo = $data['tipo'];
    $nuevo_mat->marca = $data['marca'];
    $nuevo_mat->id_area = $data['area'];
    $nuevo_mat->id_semestre=$periodo_semestre;
    $nuevo_mat->save();

     if($nuevo_mat->save()){

        $contar= DB::table ('unidades')
      ->select('unidades.id_unidad','unidades.id_material','materiales.id_material')
      ->join('materiales','materiales.id_material','=','unidades.id_material')
      ->where('materiales.id_material','=',$valor_mate)
      ->count();

      $estadoi='disponible';


       if(empty($contar)){

        $conta=$data['cantidad'];
         for ($i = 1; $i <= $conta; $i++) {

    $modelx=new Unidad;
    $modelx->indice=$i;
    $modelx->id_material=$valor_mate;
    $modelx->codigo_unidad=$valor_mate.'-'.$i;
    $modelx->estado=$estadoi;
    $modelx->medida=$data['medida'];
    $modelx->num_serie = $data['num_serie'];
    $modelx->descripcion = $data['descripcion'];

    $modelx->save();

     DB::table('materiales')
     ->where('id_material', $valor_mate)
     ->update(['n_unidades' =>$i]);

     
}



    Session::flash('message','¡Material agregado con éxito!');
    return redirect()->route('departamento');
    
     } else {

       $contar=$contar+1;

        $conta=$data['cantidad'];

        for ($i = $contar; $i <= $conta-1+$contar ; $i++) {

    $modelx=new Unidad;
    $modelx->indice=$i;
    $modelx->id_material=$valor_mate;
    $modelx->codigo_unidad=$valor_mate.'-'.$i;
     $modelx->estado=$estadoi;
     $modelx->medida=$data['medida'];
         $modelx->descripcion = $data['descripcion'];
             $modelx->num_serie = $data['num_serie'];


    $modelx->save();

     DB::table('materiales')
     ->where('id_material', $valor_mate)
     ->update(['n_unidades' =>$i]);
}
     }

     Session::flash('message','Unidades agregadas.');
            return redirect()->route('departamento');


       

}


  }

   $checa=DB::table('materiales')
        ->select('materiales.id_material')
        ->where([['materiales.nombre_material','=',$data['nombre_material']],['materiales.marca','=',$data['marca']],
  ['materiales.modelo','=',$data['modelo']]])
        ->take(1)
        ->first();
        $checa=$checa->id_material;

        $contar= DB::table ('unidades')
      ->select('unidades.id_unidad','unidades.id_material','materiales.id_material')
      ->join('materiales','materiales.id_material','=','unidades.id_material')
      ->where('materiales.id_material','=',$checa)
      ->count();

      $estadoi='disponible';

        $this->validate($request, [
            'num_serie' => ['required'],
             'area' => ['required'],
              'tipo' => ['required']
       ]);


       if(empty($data['cantidad'])){

        $data['cantidad']=1;
      }


       if(empty($contar)){

        $conta=$data['cantidad'];
         for ($i = 1; $i <= $conta; $i++) {

    $modelx=new Unidad;
    $modelx->indice=$i;
    $modelx->id_material=$checa;
    $modelx->codigo_unidad=$checa.'-'.$i;
    $modelx->estado=$estadoi;
    $modelx->medida=$data['medida'];
        $modelx->num_serie = $data['num_serie'];
                 $modelx->descripcion = $data['descripcion'];


    $modelx->save();

     DB::table('materiales')
     ->where('id_material', $checa)
     ->update(['n_unidades' =>$i]);
}

    Session::flash('message','¡Material agregado con éxito!');
    return redirect()->route('departamento');
    
     } else {

       $contar=$contar+1;

        $conta=$data['cantidad'];

        for ($i = $contar; $i <= $conta-1+$contar ; $i++) {

    $modelx=new Unidad;
    $modelx->indice=$i;
    $modelx->id_material=$checa;
    $modelx->codigo_unidad=$checa.'-'.$i;
     $modelx->estado=$estadoi;
     $modelx->medida=$data['medida'];
              $modelx->descripcion = $data['descripcion'];
                      $modelx->num_serie = $data['num_serie'];


    $modelx->save();

     DB::table('materiales')
     ->where('id_material', $checa)
     ->update(['n_unidades' =>$i]);
}
     }
     Session::flash('message','Nuevas unidades agregadas con éxito');
                  return redirect()->route('ver_unidades', ['id_material' => $checa]);

           // return redirect()->route('admin');


       
}

 public function editar_mat(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      } 
     $data = $request;
    

     $contar= DB::table ('unidades')
  ->select('unidades.id_unidad','unidades.id_material','materiales.id_material')
  ->join('materiales','materiales.id_material','=','unidades.id_material')
  ->where('materiales.id_material','=',$data['id_material'])
  ->count();


    $estadoi='disponible';


     if(empty($contar)){
    $conta=$data['cantidad'];

    for ($i = 1; $i <= $conta; $i++) {

      $modelx=new Unidad;
      $modelx->indice=$i;
      $modelx->id_material=$data['id_material'];
      $modelx->codigo_unidad=$data['id_material'].'-'.$i;
    $modelx->estado=$estadoi;
      $modelx->save();

       DB::table('materiales')
     ->where('id_material', $data['id_material'])
     ->update(['n_unidades' =>$i]);
    }
    Session::flash('message','¡Nuevas unidades agregadas!');
     return redirect()->route('departamento');
    //return redirect()->back();
  }

  else {
    $contar=$contar+1;

    $conta=$data['cantidad'];

    for ($i = $contar; $i <= $conta-1+$contar ; $i++) {

      $modelx=new Unidad;
      $modelx->indice=$i;
      $modelx->id_material=$data['id_material'];
       $modelx->codigo_unidad=$data['id_material'].'-'.$i;
     $modelx->estado=$estadoi;
      $modelx->save();

       DB::table('materiales')
     ->where('id_material', $data['id_material'])
     ->update(['n_unidades' =>$i]);


    }
  }
  Session::flash('message','¡Unidades agregadas con éxito!.');
    return redirect()->route('ver_unidades', ['id_material' => $data['id_material']]);
  // return redirect()->route('admin');
  //return redirect()->back();

     
     Session::flash('message','¡Material actualizado con éxito!');
      return redirect()->route('departamento');
     //return redirect()->back();

 }


  public function editar_mate(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      } 
     $data = $request;
     
     $checa=$data['id_material'];

       $contar= DB::table ('unidades')
      ->select('unidades.total')
      ->join('materiales','materiales.id_material','=','unidades.id_material')
      ->where('materiales.id_material','=',$checa)
      ->take(1)
      ->first();

      $contar=$contar->total;

      $estadoi='disponible';

       


       if(empty($contar)){

        DB::table('unidades')
     ->where('id_material', $checa)
     ->update(['total' =>$data['cantidad']]);
     Session::flash('message','Unidad registrada del inventario');
     return redirect()->route('departamento');
    
     } else {

      $suma=$data['cantidad']+$contar;

      DB::table('unidades')
     ->where('id_material', $checa)
     ->update(['total' =>$suma]);
     Session::flash('message','Insumo actualizado con éxito');
         return redirect()->route('ver_unidades', ['id_material' => $checa]);

     //return redirect()->route('admin');
     }

    

}



  public function editar_mate_jefe(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      } 
     $data = $request;
     

     $checa=$data['id_material'];

       $contar= DB::table ('unidades')
      ->select('unidades.total')
      ->join('materiales','materiales.id_material','=','unidades.id_material')
      ->where('materiales.id_material','=',$checa)
      ->take(1)
      ->first();

      $contar=$contar->total;

      $estadoi='disponible';

       


       if(empty($contar)){

        DB::table('unidades')
     ->where('id_material', $checa)
     ->update(['total' =>$data['cantidad']]);
     Session::flash('message','Unidad registrada del inventario');
     return redirect()->route('jefe');
    
     } else {

      $suma=$data['cantidad']+$contar;

      DB::table('unidades')
     ->where('id_material', $checa)
     ->update(['total' =>$suma]);
     Session::flash('message','Insumo actualizado con éxito');
         return redirect()->route('ver_unidades_jefe', ['id_material' => $checa]);

     //return redirect()->route('admin');
     }

    

}

public function editar_mat_jefe(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      } 
     $data = $request;
     DB::table('materiales')
     ->where('id_material', $data['id_material'])
     ->update(['descripcion' =>$data['descripcion']]);

     $contar= DB::table ('unidades')
  ->select('unidades.id_unidad','unidades.id_material','materiales.id_material')
  ->join('materiales','materiales.id_material','=','unidades.id_material')
  ->where('materiales.id_material','=',$data['id_material'])
  ->count();


    $estadoi='disponible';


     if(empty($contar)){
    $conta=$data['cantidad'];

    for ($i = 1; $i <= $conta; $i++) {

      $modelx=new Unidad;
      $modelx->indice=$i;
      $modelx->id_material=$data['id_material'];
      $modelx->codigo_unidad=$data['id_material'].'-'.$i;
    $modelx->estado=$estadoi;
      $modelx->save();

       DB::table('materiales')
     ->where('id_material', $data['id_material'])
     ->update(['n_unidades' =>$i]);
    }
    Session::flash('message','¡Nuevas unidades agregadas!');
     return redirect()->route('jefe');
    //return redirect()->back();
  }

  else {
    $contar=$contar+1;

    $conta=$data['cantidad'];

    for ($i = $contar; $i <= $conta-1+$contar ; $i++) {

      $modelx=new Unidad;
      $modelx->indice=$i;
      $modelx->id_material=$data['id_material'];
       $modelx->codigo_unidad=$data['id_material'].'-'.$i;
     $modelx->estado=$estadoi;
      $modelx->save();

       DB::table('materiales')
     ->where('id_material', $data['id_material'])
     ->update(['n_unidades' =>$i]);


    }
  }
  Session::flash('message','¡Unidades agregadas con éxito!.');
    return redirect()->route('ver_unidades_jefe', ['id_material' => $data['id_material']]);
  // return redirect()->route('admin');
  //return redirect()->back();

     
     Session::flash('message','¡Material actualizado con éxito!');
      return redirect()->route('jefe');
     //return redirect()->back();

 }






   
}
