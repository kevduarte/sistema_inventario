<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Storage;
use DateTime;


use App\Area;
use App\Brigada;
use App\Materia;
use App\Matcarro;

use App\Personal;
use App\Persona;
use App\Prestamo;

use App\User;
use App\Tipo;
use App\Material;
use App\Unidad;
use App\Semestre;
use App\Cuenta;
use App\Detalle_grupo;
use App\Unidades_temp;
use App\Detalle_brigada;
use App\Vale_material;
use App\Vale_estudiante;
use App\Solicitud;
use App\Vale;

class DocenteController extends Controller
{
  
  //mostrar la pag. principal del docente
  public function home(){
    
      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

       $id=$usuario_actual->id_user;
  
 $id_docente = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
   $id_p=$id_docente->id_docente;

    $semestre = DB::table('semestre')
         ->select('semestre.id_semestre')
         ->where('semestre.estatus_semestre', '=', 'actual')
         ->take(1)
         ->first();
          $semestre= $semestre->id_semestre;

          $num=DB::table('grupos')
          ->select('grupos.id_grupo')
           ->join('docentes','grupos.id_docente','=','docentes.id_docente')
    ->join('semestre','grupos.id_semestre','=','semestre.id_semestre')
      ->join('materias','grupos.id_materia','=','materias.id_materia')
  ->where([['grupos.id_docente',$id_p],['grupos.bandera', '=', '1'],['grupos.id_semestre', $semestre]])
 ->orderBy('grupos.created_at', 'asc')
  ->count();

    $grupos= DB::table('grupos')
    ->select('grupos.id_grupo', 'grupos.grupo', 'grupos.cupo', 'grupos.control_cupo','grupos.bandera','materias.materia','grupos.hora_inicio', 'grupos.hora_fin','grupos.id_semestre','grupos.clave','grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco','areas.area','docentes.id_docente','semestre.nombre_semestre','personas.nombre',
   'personas.apellido_paterno', 'personas.apellido_materno')
  
  ->join('docentes','grupos.id_docente','=','docentes.id_docente')
    ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
    ->join('semestre','grupos.id_semestre','=','semestre.id_semestre')
    ->join('areas','areas.id_area','=','grupos.id_area')
      ->join('materias','grupos.id_materia','=','materias.id_materia')


  ->where([['grupos.id_docente',$id_p],['grupos.bandera', '=', '1'],['grupos.id_semestre', $semestre]])
 ->orderBy('grupos.created_at', 'asc')
  ->simplePaginate(10);

  $det=DB::table('semestre')
  ->select('semestre.nombre_semestre')
         ->where('semestre.estatus_semestre', '=', 'actual')
         ->take(1)
         ->first();
          $det= $det->nombre_semestre;

       
  return view('docente.home_docente')->with('dato', $grupos)->with('detalle', $det)->with('info', $num);
  }


  public function solicitar_material(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

   $id=$usuario_actual->id_user;
  
   $id_docente = DB::table('docentes')
   ->select('docentes.id_persona','docentes.id_docente')
   ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
   ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
   ->where('users.id_user', $id)
   ->take(1)
   ->first();
   $id_p=$id_docente->id_docente;

   $semestre = DB::table('semestre')
   ->select('semestre.id_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre= $semestre->id_semestre;


   $grupos= DB::table('grupos')
   ->select('grupos.id_grupo', 'grupos.grupo', 'grupos.cupo', 'grupos.control_cupo','grupos.bandera','materias.materia','grupos.hora_inicio', 'grupos.hora_fin','grupos.id_semestre','grupos.clave','grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco','areas.area','docentes.id_docente')
   ->join('docentes','grupos.id_docente','=','docentes.id_docente')
   ->join('areas','areas.id_area','=','grupos.id_area')
   ->join('materias','grupos.id_materia','=','materias.id_materia')
   ->where([['grupos.id_docente',$id_p],['grupos.bandera', '=', '1'],['grupos.id_semestre', $semestre]])
   ->orderBy('grupos.created_at', 'asc')
   ->simplePaginate(10);

   $det=DB::table('semestre')
   ->select('semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $det= $det->nombre_semestre;
     
   return view('docente.solicitud_material')->with('dato', $grupos)->with('detalle', $det);
  }



   public function solicitud_grupo($id_grupo){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

  $id=$usuario_actual->id_user; 
  $id_d=$usuario_actual->id_docente;

 $id_docente = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente','personas.nombre','personas.apellido_paterno')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
 $id_p=$id_docente->nombre;

  $id_docentes = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente','personas.nombre','personas.apellido_paterno')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
 $id_pat=$id_docentes->apellido_paterno;

 $idg= $id_grupo;

   $result = DB::table('grupos')
  ->select('grupos.id_grupo', 'grupos.grupo','materias.materia', 'grupos.cupo', 'grupos.hora_inicio', 'grupos.hora_fin' , 'grupos.control_cupo','areas.area')
  ->join('materias','materias.id_materia','=','grupos.id_materia')
  ->join('areas','areas.id_area','=','grupos.id_area')
   ->where([['grupos.id_grupo', '=', $idg]])
  ->take(1)
  ->first();



  $area=DB::table('grupos')
  ->select('grupos.id_area')
  ->join('areas','areas.id_area','=','grupos.id_area')
  ->where('grupos.id_grupo','=',$idg)
  ->take(1)
  ->first();
  $area=$area->id_area;

  $now = new \DateTime();


//////////////////////////////////////////////////////////////////////////////////////

  $grupo=DB::table('grupos')
->select('grupos.dia_uno')
->where([['grupos.id_grupo','=',$idg],['grupos.id_docente','=',$id_d]])
->take(1)
->first();
$lunes=$grupo->dia_uno;

$grupo2=DB::table('grupos')
->select('grupos.dia_dos')
->where([['grupos.id_grupo','=',$idg],['grupos.id_docente','=',$id_d]])
->take(1)
->first();
$martes=$grupo2->dia_dos;

$grupo3=DB::table('grupos')
->select('grupos.dia_tres')
->where([['grupos.id_grupo','=',$idg],['grupos.id_docente','=',$id_d]])
->take(1)
->first();
$miercoles=$grupo3->dia_tres;

$grupo4=DB::table('grupos')
->select('grupos.dia_cuatro')
->where([['grupos.id_grupo','=',$idg],['grupos.id_docente','=',$id_d]])
->take(1)
->first();
$jueves=$grupo4->dia_cuatro;

$grupo5=DB::table('grupos')
->select('grupos.dia_cinco')
->where([['grupos.id_grupo','=',$idg],['grupos.id_docente','=',$id_d]])
->take(1)
->first();
$viernes=$grupo5->dia_cinco;

$hoy=date("w");

//dd($hoy);
//$hoy=7;

if($lunes=='Lunes'){
$lunes=1;
}else{
  $lunes='Lunes';
}

if($martes=='Martes'){
$martes=2;
}else{
  $martes='Martes';
}

if($miercoles=='Miercoles'){
$miercoles=3;
}else{
  $miercoles='Miercoles';
}

if($jueves=='Jueves'){
$jueves=4;
}else{
  $jueves='Jueves';
}

if($viernes=='Viernes'){
$viernes=5;
}else{
  $viernes='Viernes';
}


$base= array($lunes,$martes,$miercoles,$jueves,$viernes);
$n=intval($base[0]);
$n2=intval($base[1]);
$n3=intval($base[2]);
$n4=intval($base[3]);
$n5=intval($base[4]);

$n6=intval($hoy);
$n7=$n6-1;



$num= array($n,$n2,$n3,$n4,$n5);



$longitud = count($num);



$x=[];




if($n6==5){
//Recorro todos los elementos
for($i=0; $i<$longitud; $i++)
      {

        if(empty($num[0])){

           Session::flash('mes','¡La práctica es la proxima semana, realice la solicitu el día Lunes!');
        return redirect()->back(); 
         
        }
     
      }
      $z=1;
      $a=3;

$fecha = date('Y-m-j');
$nuevafecha = strtotime ( +$a.'day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

$tipop=DB::table('prestamos')
->select('prestamos.id_prestamo','prestamos.tipo_prestamo')
->get();

return view('docente.solicitud_grupo')->with('dato', $result)->with('areas',$area)->with('fecha',$now)->with('nombre',$id_p)->with('ap',$id_pat)->with('idc',$id_d)->with('nueva',$nuevafecha)->with('presta',$tipop);
}




if($n6==6){
//Recorro todos los elementos
for($i=0; $i<$longitud; $i++)
      {

        if(empty($num[0])){

           Session::flash('mes','¡La práctica es la proxima semana, realice la solicitu el día Lunes!');
        return redirect()->back(); 
         
        }
     
      }
      $z=1;
      $a=2;

$fecha = date('Y-m-j');
$nuevafecha = strtotime ( +$a.'day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );


$tipop=DB::table('prestamos')
->select('prestamos.id_prestamo','prestamos.tipo_prestamo')
->get();

return view('docente.solicitud_grupo')->with('dato', $result)->with('areas',$area)->with('fecha',$now)->with('nombre',$id_p)->with('ap',$id_pat)->with('idc',$id_d)->with('nueva',$nuevafecha)->with('presta',$tipop);
}



if($n6==7){
//Recorro todos los elementos
for($i=0; $i<$longitud; $i++)
      {

        if(empty($num[0])){

           Session::flash('mes','¡La práctica es la proxima semana, realice la solicitu el día Lunes!');
        return redirect()->back(); 
         
        }
     
      }
      $z=1;
      $a=1;

$fecha = date('Y-m-j');
$nuevafecha = strtotime ( +$a.'day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );


$tipop=DB::table('prestamos')
->select('prestamos.id_prestamo','prestamos.tipo_prestamo')
->get();

return view('docente.solicitud_grupo')->with('dato', $result)->with('areas',$area)->with('fecha',$now)->with('nombre',$id_p)->with('ap',$id_pat)->with('idc',$id_d)->with('nueva',$nuevafecha)->with('presta',$tipop);
}


//Recorro todos los elementos
for($i=0; $i<$longitud; $i++)
      {

        if($num[$i]>$n6){
         $x[$i]=$num[$i];
        }
     
      }

  if(empty($x)){

    Session::flash('mes','¡No hay prácticas programadas para el resto de la semana!');
        return redirect()->back(); 

  }
$z=min ($x);



$a=$z-$hoy;

$fecha = date('Y-m-j');
$nuevafecha = strtotime ( +$a.'day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

$tipop=DB::table('prestamos')
->select('prestamos.id_prestamo','prestamos.tipo_prestamo')
->get();


return view('docente.solicitud_grupo')->with('dato', $result)->with('areas',$area)->with('fecha',$now)->with('nombre',$id_p)->with('ap',$id_pat)->with('idc',$id_d)->with('nueva',$nuevafecha)->with('presta',$tipop);
}




public function enviar_solicitud(Request $request){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='docente'){
     return redirect()->back();
    }

     $semestre = DB::table('semestre')
  ->select('semestre.id_semestre')
  ->where('semestre.estatus_semestre', '=', 'actual')
  ->take(1)
  ->first();
  $semestre= $semestre->id_semestre;

  $id_d=$usuario_actual->id_docente;

  $data=$request;
  $id_g=$data['id_grupo'];
  //$id_d=$data['id_docente'];
  $dia=$data['dia'];
  $area=$data['area'];
  $fechahoy=$data['fecha_prestamo'];
  $prestamo=$data['prestamo'];
  $hora_inicio_sol=$data['hora_inicio'];
  $hora_fin_sol=$data['hora_fin'];

  $encargado=DB::table('personal')
  ->select('personal.id_personal')
  ->where([['personal.id_area','=',$area],['personal.estado','=','actual']])
  ->take(1)
  ->first();

  $encargado=$encargado->id_personal;


function generarCodigo($longitud) {
 $key = '';
 $pattern = '1234567890';
 $max = strlen($pattern)-1;
 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
 return $key;
}

$limite=4294967295;
//Ejemplo de uso
$codigo=generarCodigo(4); // genera un código de 6 caracteres de longitud.
$hoy = date("ymd");
$folio=$hoy.$codigo; 

if($folio>$limite){
      Session::flash('mess','¡Ha ocurrido un error!');
 return redirect()->back();
}
$sol=DB::table('solicitudes')
->select('solicitudes.id_solicitud')
->where('solicitudes.id_solicitud','=',$folio)
->count();
if(!empty($sol)){
      Session::flash('mess','¡Ha ocurrido un error, por favor intentelo de nuevo!');
 return redirect()->back();
}

$brig=DB::table('brigadas')
->select('brigadas.id_brigada')
->join('grupos','grupos.id_grupo','=','brigadas.id_grupo')
->where('grupos.id_grupo','=',$id_g)
->count();

if($prestamo==1 && $brig==0){
   Session::flash('mess','¡Aún no ha formado brigadas para este grupo!');
 return redirect()->back();
}

if($prestamo==1){


$solicitud=new Solicitud;
$solicitud->id_solicitud=$folio;
$solicitud->fecha_solicitud=$fechahoy;
$solicitud->id_docente=$id_d;
$solicitud->fecha_prestamo=$dia;
$solicitud->hora_inicio_sol=$hora_inicio_sol;
$solicitud->hora_fin_sol=$hora_fin_sol;
$solicitud->id_grupo=$id_g;
$solicitud->id_prestamo=$prestamo;
$solicitud->id_semestre=$semestre;
$solicitud->id_area=$area;
$solicitud->estado='pendiente';
$solicitud->save();

  if($solicitud->save()){

  $bda=DB::table('brigadas')
  ->select('brigadas.id_brigada')
  ->where('brigadas.id_grupo','=',$id_g)
  ->get();
 
 foreach ($bda as $c =>$valor ) {
 $n=$valor->id_brigada;
  $vale=new Vale;
  $vale->id_solicitud=$folio;
  $vale->id_personal=$encargado;
  $vale->id_brigada=$n;
  $vale->id_semestre=$semestre;
  $vale->id_area=$area;
  $vale->fecha_prestamo_vale=$dia;
  $vale->hora_inicio_vale=$hora_inicio_sol;
  $vale->hora_fin_vale=$hora_fin_sol;
  $vale->estado_vale='pendiente';
  $vale->save();
  }
        

}


$infosol=DB::table('solicitudes')
->select('solicitudes.id_solicitud')
->where('solicitudes.id_solicitud','=',$folio)
->take(1)
->first();

$infosol=$infosol->id_solicitud;




return redirect()->route('seleccionar_material',['id_solicitud' => $infosol]);



   //return view('docente.seleccionar_material')->with('solicitud',$infosol)->with('mater',$material);

  





}



}


   public function seleccionar_material($id_solicitud){

      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

     $id_sol=$id_solicitud;

     $area=DB::table('solicitudes')
     ->select('solicitudes.id_area')
     ->where('solicitudes.id_solicitud','=',$id_sol)
     ->take(1)
     ->first();

     $area=$area->id_area;

      $namearea=DB::table('areas')
     ->select('areas.area')
     ->join('solicitudes','solicitudes.id_area','=','areas.id_area')
     ->where('solicitudes.id_solicitud','=',$id_sol)
     ->take(1)
     ->first();

     $namearea=$namearea->area;



 $material=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.modelo','materiales.n_unidades','areas.area','tipos.tipo')
->join('areas','materiales.id_area','=','areas.id_area')
->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
->where([['materiales.id_area','=',$area],['materiales.bandera','=','1']])
 ->get();


 $matcarro=DB::table('matcarro')
->select('matcarro.id_material','matcarro.nombre_material','matcarro.clave','matcarro.marca','matcarro.modelo','matcarro.n_unidades','matcarro.area','matcarro.tipo')
->where([['matcarro.area','=',$area],['matcarro.bandera','=','1'],['matcarro.id_solicitud','=',$id_sol]])
->distinct()
->simplePaginate(10);
       
return view('docente.seleccionar_material')
->with('solicitud',$id_sol)->with('mate',$material)->with('matcar',$matcarro)->with('area',$namearea);
  }


  public function agregar_material(Request $request){

      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }


      $data=$request;
      $mate=$data['material'];
      $sol=$data['solicitud'];



 $material=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.modelo','materiales.n_unidades','materiales.id_area','materiales.id_tipo')
->where([['materiales.id_material','=',$mate],['materiales.bandera','=','1']])
->take(1)
->first();
 $nombre=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.modelo','materiales.n_unidades','materiales.id_area','materiales.id_tipo')
->where([['materiales.id_material','=',$mate],['materiales.bandera','=','1']])
->take(1)
->first();
$clave=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.clave','materiales.marca','materiales.modelo','materiales.n_unidades','materiales.id_area','materiales.id_tipo')
->where([['materiales.id_material','=',$mate],['materiales.bandera','=','1']])
->take(1)
->first();
$modelo=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.modelo','materiales.n_unidades','materiales.id_area','materiales.id_tipo')
->where([['materiales.id_material','=',$mate],['materiales.bandera','=','1']])
->take(1)
->first();
$marca=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.modelo','materiales.n_unidades','materiales.id_area','materiales.id_tipo')
->where([['materiales.id_material','=',$mate],['materiales.bandera','=','1']])
->take(1)
->first();
$unidades=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.modelo','materiales.n_unidades','materiales.id_area','materiales.id_tipo')
->where([['materiales.id_material','=',$mate],['materiales.bandera','=','1']])
->take(1)
->first();
$area=DB::table('materiales')
->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.modelo','materiales.n_unidades','materiales.id_area','materiales.id_tipo')
->where([['materiales.id_material','=',$mate],['materiales.bandera','=','1']])
->take(1)
->first();


$material=$material->id_material;
$nombre=$nombre->nombre_material;
$clave=$clave->clave;
$modelo=$modelo->modelo;
$marca=$marca->marca;
$unidades=$unidades->n_unidades;
$area=$area->id_area;


 $checa=DB::table('matcarro')
->select('matcarro.id_material')
->where([['matcarro.area','=',$area],['matcarro.bandera','=','1'],['matcarro.id_solicitud','=',$sol],['matcarro.id_material','=',$mate]])
->count();


if($checa>0){
Session::flash('mes','¡El material ya fué agregado!');
    return redirect()->back();
}

$vales=DB::table('vales')
      ->select('vales.id_vale')
      ->where('vales.id_solicitud','=',$sol)
      ->count();


$uni=DB::table('unidades')
       ->select('unidades.id_unidad','unidades.id_material')
      ->join('materiales','unidades.id_material','=','materiales.id_material')
      ->where('unidades.id_material','=',$mate)
      ->take($vales)
      ->get();


      $nuevale=DB::table('vales')
      ->select('vales.id_vale')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      
      ->where('vales.id_solicitud','=',$sol)
      ->get();




  foreach ($uni as $d =>$valor2 ) {
 $x=$valor2->id_unidad;
$carro=new Matcarro;
$carro->id_material=$material;
$carro->id_unidad=$x;
$carro->nombre_material=$nombre;
$carro->clave=$clave;
$carro->modelo=$modelo;
$carro->marca=$marca;
$carro->n_unidades=$unidades;
$carro->area=$area;
$carro->id_solicitud=$sol;
$carro->save();
}


        /* declaramos el array */
        $datos_a_insertar = array();
       
        /* añadimos los datos al array */
        foreach ($nuevale as $n =>$valor3) 
        {
            $datos_a_insertar[$n]= $valor3->id_vale;
           
        }

         $contar=count($datos_a_insertar);

         //dd($datos_a_insertar);

         $carrito=DB::table('matcarro')
         ->select('matcarro.id_unidad')
         ->where('matcarro.id_material','=',$material)
         ->get();


         //dd($carrito);

          foreach ($carrito as $k =>$valor4) 
        {

          $ma=$valor4->id_unidad;
           

           DB::table('matcarro')
    ->where('matcarro.id_unidad', $ma)
    ->update(
      ['id_vale' => $datos_a_insertar[$k]]);

        
           
        }


return redirect()->route('seleccionar_material',['id_solicitud' => $sol]);





    }



     public function quitar_carro($id_material){

      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

      $material=$id_material;

      $sol=DB::table('matcarro')
      ->select('matcarro.id_solicitud')
      ->where('matcarro.id_material','=',$material)
      ->take(1)
      ->first();

      $sol=$sol->id_solicitud;

      DB::table('matcarro')->where('id_material', '=', $material)->delete();



return redirect()->route('seleccionar_material',['id_solicitud' => $sol]);


    }


     public function solicitud_enviada(Request $request){

      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

      

      $data=$request;

      $id_solicitud=$data['numsol'];

      $materiales=DB::table('matcarro')
      ->select('matcarro.id_material')
      ->where('matcarro.id_solicitud','=',$id_solicitud)
      ->count();

      if(empty($materiales)){
    Session::flash('mes','¡Aún no ha seleccionado materiales para la práctica!');
    return redirect()->back();
      }

      $contvale=DB::table('vales')
      ->select('vales.id_vale')
      ->where('vales.id_solicitud','=',$id_solicitud)
      ->count();

      $carro=DB::table('matcarro')
      ->select('matcarro.id_vale','matcarro.id_material','matcarro.id_unidad')
      ->where('matcarro.id_solicitud','=',$id_solicitud)
      ->get();



       $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();
      $periodo_semestre= $periodo_semestre->id_semestre;


      foreach ($carro as $k =>$valor5) 
        {

          $ma=$valor5->id_vale;
          $me=$valor5->id_material;
          $mi=$valor5->id_unidad;
      
$nueva=new Vale_material;
$nueva->id_vale=$ma;
$nueva->id_material=$me;
$nueva->id_unidad=$mi;
$nueva->id_semestre=$periodo_semestre;

$nueva->save();
        
           
        }


         $vales=DB::table('vales')
      ->select('vales.id_vale','detalle_brigadas.num_control')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
      ->join('detalle_brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
      ->where('vales.id_solicitud','=',$id_solicitud)
      ->get();

 foreach ($vales as $v =>$valor6){

          $va=$valor6->id_vale;
          $ve=$valor6->num_control;
      
$nuevos=new Vale_estudiante;
$nuevos->num_control=$ve;
$nuevos->id_vale=$va;
$nuevos->id_semestre=$periodo_semestre;
$nuevos->save();
        
           
        }


        if($nueva->save() && $nuevos->save() ){


      $borrar=DB::table('matcarro')
      ->select('matcarro.id_solicitud')
      ->where('matcarro.id_solicitud','=',$id_solicitud)
      ->take(1)
      ->first();
      $borrar=$borrar->id_solicitud;
      DB::table('matcarro')->where('id_solicitud', '=', $borrar)->delete();

           DB::table('solicitudes')
    ->where('solicitudes.id_solicitud', $id_solicitud)
    ->update(
      ['estado' => 'aprobada']);




/*

     DB::table('vales')
    ->where('vales.id_solicitud', $id_solicitud)
    ->update(
      ['estado_vale' => 'aprobado']);

*/
        }




       


   //return view('docente.mis_solicitudes')->with('solicitudes',$aprobadas);


return redirect()->route('mis_solicitudes');

}








  
    public function mis_solicitudes(){

      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

       $id=$usuario_actual->id_user;
  
 $id_docente = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
   $id_p=$id_docente->id_docente;

    $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();
      $periodo_semestre= $periodo_semestre->id_semestre;

       $semestre = DB::table('semestre')
      ->select('semestre.nombre_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();
      $semestre= $semestre->nombre_semestre;



        $aprobadas=DB::table('solicitudes')
  ->select('solicitudes.id_solicitud','solicitudes.fecha_solicitud','solicitudes.fecha_prestamo','solicitudes.estado','grupos.grupo')
  ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
  ->where([['solicitudes.id_semestre', '=', $periodo_semestre],['solicitudes.id_docente','=',$id_p],['solicitudes.estado','=','aprobada']])
  ->paginate(5);


  return view('docente.mis_solicitudes')->with('solicitudes',$aprobadas)->with('semestre',$semestre);

      }



        public function mis_solicitudes_fin()
    {
        $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

       $id=$usuario_actual->id_user;
  
 $id_docente = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
   $id_p=$id_docente->id_docente;

    $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();
      $periodo_semestre= $periodo_semestre->id_semestre;

       $semestre = DB::table('semestre')
      ->select('semestre.nombre_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();
      $semestre= $semestre->nombre_semestre;



        $aprobadas=DB::table('solicitudes')
  ->select('solicitudes.id_solicitud','solicitudes.fecha_solicitud','solicitudes.fecha_prestamo','solicitudes.estado','grupos.grupo')
  ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
  ->where([['solicitudes.id_semestre', '=', $periodo_semestre],['solicitudes.id_docente','=',$id_p],['solicitudes.estado','=','finalizado']])
  ->paginate(5);


  return view('docente.mis_solicitudes_fin')->with('solicitudes',$aprobadas)->with('semestre',$semestre);
    }







  
    public function registrar_grupo(){

      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

      $area=DB::table('areas')
      ->select('areas.area','areas.id_area')
      ->where('areas.area','!=','laboratorio')
      ->get();

      $materia=DB::table('materias')
      ->select('materias.id_materia','materias.materia')
      ->get();
       

   return view('docente.registrar_grupo')->with('area',$area)->with('mate',$materia);
  }

   public function registrar_grupos(Request $request){

      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

       
     $this->validate($request, 
    ['grupo' => ['required', 'string', 'max:80','unique:grupos']]);

     $data = $request;
     $id=$usuario_actual->id_user;



     if($data['hora_c']!=0){

        Session::flash('mes','¡la hora de registro debe ser sin minutos!');
        return redirect()->back();
     }

$lu=$data['lu'];
     $ma=$data['ma'];
         $mie=$data['mie'];
             $ju=$data['ju'];
                 $vi=$data['vi'];


                   if(empty($lu)){

                    $uno=1;

                   }else{
                     $uno=0;
                   }
                   
                   if(empty($ma)){

                    $dos=1;

                   }else{
                    $dos=0;
                   }
                   
                   if(empty($mie)){

                    $tres=1;

                   }else{

                    $tres=0;
                   }
                   
                   if(empty($ju)){

                    $cuatro=1;

                   }else{
                    $cuatro=0;
                   }
                   
                   if(empty($vi)){

                    $cinco=1;

                   }else{
                    $cinco=0;
                   }
$datos = array ($uno,$dos,$tres,$cuatro,$cinco);
$suma = 0;
foreach ($datos as $numero) {
  $suma += $numero;
}
 if($suma==5){
     Session::flash('mes','¡Seleccione un dia de la semana!');
      return redirect()->back();
 }

 if(empty($lu) ){
$lu=1;
 }
  if(empty($ma) ){
$ma=2;
 }
  if(empty($mie) ){
$mie=3;
 }
  if(empty($ju) ){
$ju=4;
 }
  if(empty($vi) ){
$vi=5;
 }

   $id_persona = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
   $id_p=$id_persona->id_docente;

    $semestre = DB::table('semestre')
   ->select('semestre.id_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre= $semestre->id_semestre;

   $grupover=DB::table('grupos')
   ->select('grupos.id_grupo')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->count();

   if(!empty($grupover)){

//lunes
    $dia = DB::table('grupos')
   ->select('grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->get();

   foreach ($dia as $c =>$valor  ) {

    $thearray = (array) $valor;
    $n=$valor->dia_uno;

    if($lu==$n){

    //si la hora de entrada es la misma
   $hora = DB::table('grupos')
   ->select('grupos.hora_inicio','grupos.hora_fin')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->whereTime('grupos.hora_inicio', '=', $data['hora_inicio'])
   ->count();
   if(!empty($hora)){

     Session::flash('mess','¡Ya tiene un grupo registrado los dás lunes a la misma hora!');

     return redirect()->back();

   } 
//si la hora inicio de un grupo registrado esta entre mis horas nuevas no se puede


$users = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_inicio']],['grupos.hora_fin','>',$data['hora_inicio']]])
  ->count();
  // dd($users);


  //si hay uno entonces la hora inicio esta dentro de la inicio y fin de la base

  
   if(!empty($users)){

         Session::flash('mess','¡La hora de inicio esta dentro del rango de horas de otro grupo del día lunes!');
  
       return redirect()->back();

  } 

$users2 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_fin']],['grupos.hora_fin','>=',$data['hora_fin']]])
  ->count();

 // dd($users2);

    //si hay uno entonces la hora fin esta dentro de la inicio y fin de la base


 if( !empty($users2)){

         Session::flash('mess','¡La hora de salida esta dentro del rango de horas de un grupo del día luneso!');
  
       return redirect()->back();

  } 

  $users3 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','>',$data['hora_inicio']],['grupos.hora_fin','<',$data['hora_fin']]])
  ->count();
   //dd($users3);

   //si hay uno entonces un grupo esta adentro de las horas data

   if( !empty($users3)){

         Session::flash('mess','¡Ya tiene un grupo registrado dentro del rango de horas de entrada y salida los días lunes!');
  
       return redirect()->back();

  } 


   }
      
}

//martes
 $dia2 = DB::table('grupos')
   ->select('grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->get();

   foreach ($dia2 as $c =>$valor  ) {

    $thearray = (array) $valor;
    $n=$valor->dia_dos;

    if($ma==$n){

    //si la hora de entrada es la misma
   $hora = DB::table('grupos')
   ->select('grupos.hora_inicio','grupos.hora_fin')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->whereTime('grupos.hora_inicio', '=', $data['hora_inicio'])
   ->count();
   if(!empty($hora)){

     Session::flash('mess','¡Ya tiene un grupo registrado los dás martes a la misma hora!');

     return redirect()->back();

   } 
//si la hora inicio de un grupo registrado esta entre mis horas nuevas no se puede


$users = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_inicio']],['grupos.hora_fin','>',$data['hora_inicio']]])
  ->count();
  // dd($users);


  //si hay uno entonces la hora inicio esta dentro de la inicio y fin de la base

  
   if(!empty($users)){

         Session::flash('mess','¡La hora de inicio esta dentro del rango de horas de un grupo los días martes!');
  
       return redirect()->back();

  } 

$users2 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_fin']],['grupos.hora_fin','>=',$data['hora_fin']]])
  ->count();

 // dd($users2);

    //si hay uno entonces la hora fin esta dentro de la inicio y fin de la base


 if( !empty($users2)){

         Session::flash('mess','¡La hora de salida esta dentro del rango de horas de un grupo del día martes!');
  
       return redirect()->back();

  } 

  $users3 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','>',$data['hora_inicio']],['grupos.hora_fin','<',$data['hora_fin']]])
  ->count();
   //dd($users3);

   //si hay uno entonces un grupo esta adentro de las horas data

   if( !empty($users3)){

         Session::flash('mess','¡Y tiene un grupo registrado dentro del rango de horas de entrada y salida los días martes !');
  
       return redirect()->back();

  } 


   }
      
}

//miercoles
 $dia3 = DB::table('grupos')
   ->select('grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->get();

   foreach ($dia3 as $c =>$valor  ) {

    $thearray = (array) $valor;
    $n=$valor->dia_tres;

    if($mie==$n){

    //si la hora de entrada es la misma
   $hora = DB::table('grupos')
   ->select('grupos.hora_inicio','grupos.hora_fin')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->whereTime('grupos.hora_inicio', '=', $data['hora_inicio'])
   ->count();
   if(!empty($hora)){

     Session::flash('mess','¡Ya tiene un grupo registrado los dás miercoles a la misma hora!');

     return redirect()->back();

   } 
//si la hora inicio de un grupo registrado esta entre mis horas nuevas no se puede


$users = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_inicio']],['grupos.hora_fin','>',$data['hora_inicio']]])
  ->count();
  // dd($users);


  //si hay uno entonces la hora inicio esta dentro de la inicio y fin de la base

  
   if(!empty($users)){

         Session::flash('mess','¡La hora de inicio esta dentro del rango de horas de un grupo los días miercoles!');
  
       return redirect()->back();

  } 

$users2 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_fin']],['grupos.hora_fin','>=',$data['hora_fin']]])
  ->count();

 // dd($users2);

    //si hay uno entonces la hora fin esta dentro de la inicio y fin de la base


 if( !empty($users2)){

         Session::flash('mess','¡La hora de salida esta dentro del rango de horas de un grupo los dias miercoles!');
  
       return redirect()->back();

  } 

  $users3 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','>',$data['hora_inicio']],['grupos.hora_fin','<',$data['hora_fin']]])
  ->count();
   //dd($users3);

   //si hay uno entonces un grupo esta adentro de las horas data

   if( !empty($users3)){

         Session::flash('message','¡Ya tiene un grupo registrado dentro del rango de entrada y salida los días miercoles!');
  
       return redirect()->back();

  } 


   }
      
}


//jueves
 $dia4 = DB::table('grupos')
   ->select('grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->get();

   foreach ($dia4 as $c =>$valor  ) {

    $thearray = (array) $valor;
    $n=$valor->dia_cuatro;

    if($ju==$n){

    //si la hora de entrada es la misma
   $hora = DB::table('grupos')
   ->select('grupos.hora_inicio','grupos.hora_fin')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->whereTime('grupos.hora_inicio', '=', $data['hora_inicio'])
   ->count();
   if(!empty($hora)){

     Session::flash('mess','¡Ya tiene un grupo registrado los dás jueves a la misma hora!');

     return redirect()->back();

   } 
//si la hora inicio de un grupo registrado esta entre mis horas nuevas no se puede


$users = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_inicio']],['grupos.hora_fin','>',$data['hora_inicio']]])
  ->count();
  // dd($users);


  //si hay uno entonces la hora inicio esta dentro de la inicio y fin de la base

  
   if(!empty($users)){

         Session::flash('mess','¡La hora de inicio esta dentro del rango de horas de un grupo los días jueves!');
  
       return redirect()->back();

  } 

$users2 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_fin']],['grupos.hora_fin','>=',$data['hora_fin']]])
  ->count();

 // dd($users2);

    //si hay uno entonces la hora fin esta dentro de la inicio y fin de la base


 if( !empty($users2)){

         Session::flash('mess','¡La hora de salida esta dentro del rango de horas de un grupo de los días jueves!');
  
       return redirect()->back();

  } 

  $users3 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','>',$data['hora_inicio']],['grupos.hora_fin','<',$data['hora_fin']]])
  ->count();
   //dd($users3);

   //si hay uno entonces un grupo esta adentro de las horas data

   if( !empty($users3)){

         Session::flash('mess','¡Ya tiene un grupo registrado dentro del rango de horas los dias jueves!');
  
       return redirect()->back();

  } 


   }
      
}

//viernes
 $dia5 = DB::table('grupos')
   ->select('grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->get();

   foreach ($dia5 as $c =>$valor  ) {

    $thearray = (array) $valor;
    $n=$valor->dia_cinco;

    if($vi==$n){

    //si la hora de entrada es la misma
   $hora = DB::table('grupos')
   ->select('grupos.hora_inicio','grupos.hora_fin')
   ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre]])
   ->whereTime('grupos.hora_inicio', '=', $data['hora_inicio'])
   ->count();
   if(!empty($hora)){

     Session::flash('mess','¡Ya tiene un grupo registrado los dás viernes a la misma hora de inicio!');

     return redirect()->back();

   } 
//si la hora inicio de un grupo registrado esta entre mis horas nuevas no se puede


$users = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_inicio']],['grupos.hora_fin','>',$data['hora_inicio']]])
  ->count();
  // dd($users);


  //si hay uno entonces la hora inicio esta dentro de la inicio y fin de la base

  
   if(!empty($users)){

         Session::flash('mess','¡La hora de inicio esta dentro del rango de horas de un grupo los dias viernes!');
  
       return redirect()->back();

  } 

$users2 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','<',$data['hora_fin']],['grupos.hora_fin','>=',$data['hora_fin']]])
  ->count();

 // dd($users2);

    //si hay uno entonces la hora fin esta dentro de la inicio y fin de la base


 if( !empty($users2)){

         Session::flash('mess','¡La hora de salida esta dentro del rango de horas de un grupo los dias viernes!');
  
       return redirect()->back();

  } 

  $users3 = DB::table('grupos')
 ->select('grupos.id_grupo')
 ->where([['grupos.id_docente','=',$id_p],['grupos.id_semestre','=',$semestre],['grupos.hora_inicio','>',$data['hora_inicio']],['grupos.hora_fin','<',$data['hora_fin']]])
  ->count();
   //dd($users3);

   //si hay uno entonces un grupo esta adentro de las horas data

   if( !empty($users3)){

         Session::flash('mess','¡Ya tiene un grupo registrado dentro del rango de horas los días viernes!');
  
       return redirect()->back();

  } 


   }
      
}

}


$caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
for($x = 0; $x < 1; $x++){
  $aleatoria = substr(str_shuffle($caracteres), 0, 5);
}

$clave=$aleatoria;

 $grupo=new Grupo;
        $grupo->grupo=$data['grupo'];

        $grupo->id_materia=$data['materia'];
        $grupo->cupo=$data['cupo'];
        $grupo->control_cupo=$data['cupo'];
        $grupo->hora_inicio=$data['hora_inicio'];
        $grupo->hora_fin=$data['hora_fin'];
        $grupo->id_docente=$id_p;
        $grupo->id_semestre=$semestre;
        $grupo->id_area=$data['area'];
        $grupo->clave=$clave;
         $grupo->dia_uno=$lu;
          $grupo->dia_dos=$ma;
           $grupo->dia_tres=$mie;
            $grupo->dia_cuatro=$ju;
             $grupo->dia_cinco=$vi;
        $grupo->save();

         Session::flash('message','¡Grupo registrado con éxito!');
  
       return redirect()->route('mis_grupos');



  










}

 public function mis_grupos(){

    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }
   
   $id=$usuario_actual->id_user;
  
 $id_docente = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
   $id_p=$id_docente->id_docente;

    $semestre = DB::table('semestre')
         ->select('semestre.id_semestre')
         ->where('semestre.estatus_semestre', '=', 'actual')
         ->take(1)
         ->first();
          $semestre= $semestre->id_semestre;


    $grupos= DB::table('grupos')
    ->select('grupos.id_grupo', 'grupos.grupo', 'grupos.cupo', 'grupos.control_cupo','grupos.bandera','materias.materia','grupos.hora_inicio', 'grupos.hora_fin','grupos.id_semestre','grupos.clave','grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco','areas.area','docentes.id_docente','semestre.nombre_semestre','personas.nombre',
   'personas.apellido_paterno', 'personas.apellido_materno')
  
  ->join('docentes','grupos.id_docente','=','docentes.id_docente')
    ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
    ->join('semestre','grupos.id_semestre','=','semestre.id_semestre')
    ->join('areas','areas.id_area','=','grupos.id_area')
      ->join('materias','grupos.id_materia','=','materias.id_materia')
  ->where([['grupos.id_docente',$id_p],['grupos.bandera', '=', '1'],['grupos.id_semestre', $semestre]])
 ->orderBy('grupos.created_at', 'asc')
  ->simplePaginate(10);

  $det=DB::table('semestre')
  ->select('semestre.nombre_semestre')
         ->where('semestre.estatus_semestre', '=', 'actual')
         ->take(1)
         ->first();
          $det= $det->nombre_semestre;

    return view('docente.grupos_registrados')->with('dato', $grupos)->with('detalle', $det);
    }

    public function actualizar_grupo($id_grupo)
{
  $id= $id_grupo;
   $result = DB::table('grupos')
  ->select('grupos.id_grupo', 'grupos.grupo','materias.materia', 'grupos.cupo', 'grupos.hora_inicio', 'grupos.hora_fin' , 'grupos.control_cupo')
  ->join('materias','grupos.id_materia','=','materias.id_materia')
   ->where([['grupos.id_grupo', '=', $id]])
  ->take(1)
  ->first();
  
return view('docente.editar_grupo')
->with('dato', $result);
}

public function actualizar_g(Request $request)
{
  

  $data = $request;
  
   $result = DB::table('grupos')
  ->select('grupos.cupo', 'grupos.control_cupo')
   ->where('grupos.id_grupo', '=', $data['id_grupo'])
  ->take(1)
  ->first();
  
  $nuevo_cupo = ($result->cupo)+ $data['aumento'];
  $nuevo_control_cupo = ($result->control_cupo)+$data['aumento'];
  
DB::table('grupos')
    ->where('grupos.id_grupo', $data['id_grupo'])
    ->update(['cupo' => $nuevo_cupo, 
            'control_cupo' => $nuevo_control_cupo]);
      Session::flash('message','¡Grupo actualizado con éxito!');
return redirect()->route('mis_grupos');
}


    public function inscritos_grupo($id_grupo,$id_docente)
{
  
      $id= $id_grupo;
     $id_doc=$id_docente;
     
      $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('grupos')
      ->select('grupos.id_grupo','estudiantes.num_control','grupos.grupo', 'personas.nombre','personas.apellido_paterno','personas.apellido_materno','detalle_grupos.estado','docentes.id_docente')


      ->join('detalle_grupos', 'detalle_grupos.nom_grupo', '=', 'grupos.id_grupo')

      ->join('estudiantes', 'estudiantes.num_control', '=', 'detalle_grupos.num_control')

      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')

      ->join('docentes','docentes.id_docente','=','grupos.id_docente')

      ->where([['grupos.bandera', '=' , '1'] , ['grupos.id_docente', $id_doc], 
        ['detalle_grupos.nom_grupo', $id],
        ['grupos.id_semestre', $periodo_semestre->id_semestre]])
      ->orderBy('personas.nombre', 'asc')
      
      ->simplePaginate(10);

      $formar=DB::table('grupos')
      ->select('id_grupo','id_docente')
      ->where([['grupos.id_docente','=',$id_doc],['grupos.id_grupo','=',$id]])
       ->take(1)
      ->first();
 //dd($formar);

      $resultado = DB::table('grupos')
      ->select('grupos.grupo')
      ->where('grupos.id_grupo', $id)
      ->take(1)
      ->first();

      $formab = DB::table('grupos')
      ->select('grupos.control_cupo')
      ->where('grupos.id_grupo', $id)
      ->take(1)
      ->first();



return view('docente.gestion_grupo')
->with('data', $result)->with('detalle', $resultado)->with('id_grupo', $id)->with('forma', $formar)
->with('controla',$formab);
  
}

public function desactivar_estudiante_grupo($id_grupo,$num_control)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='docente'){
     return redirect()->back();
    }
       $id= $id_grupo;
     $id_est=$num_control;

     DB::table('detalle_grupos')
         ->where([['detalle_grupos.num_control', $id_est], ['detalle_grupos.nom_grupo', $id]])
         ->update(
             ['estado' => 'baja' ,'equipo' => '1']);

         $result = DB::table('grupos')
 ->select('grupos.control_cupo')
->where('grupos.id_grupo',$id)
->take(1)
->first();



           $aumentar=($result->control_cupo)+1;
          


          DB::table('grupos')
              ->where('grupos.id_grupo',$id )
              ->update(['control_cupo' => $aumentar]);

            $si=DB::table('brigadas')
            ->select('brigadas.id_brigada')
            ->where('brigadas.id_grupo','=',$id)
            ->count();

if(!empty($si)){


            $brigada= DB::table('brigadas')
            ->select('brigadas.id_brigada','brigadas.cupo_brigada','brigadas.control_brigada')
            ->join('detalle_brigadas','detalle_brigadas.id_brigada','=','brigadas.id_brigada')
            ->where('detalle_brigadas.num_control','=',$id_est)
            ->take(1)
            ->first();

             $sumacupo=($brigada->control_brigada)+1;

             DB::table('brigadas')
              ->where('brigadas.id_brigada',$brigada->id_brigada)
              ->update(['control_brigada' => $sumacupo]);




       DB::table('detalle_brigadas')
       ->join('brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
         ->where([['detalle_brigadas.num_control', $id_est], ['brigadas.id_grupo', $id]])
         ->update(
             ['estado' => 'baja']);  

             } 


 Session::flash('mess','¡Se ha dado de baja al estudiante del grupo!');
 return redirect()->back();

}

public function activar_estudiante_grupo($id_grupo,$num_control)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='docente'){
     return redirect()->back();
    }

     $id= $id_grupo;
     $id_est=$num_control;

 $activo=DB::table('detalle_grupos')
    ->select('detalle_grupos.nom_grupo')
    ->where([['detalle_grupos.nom_grupo','=',$id],['detalle_grupos.estado','=','cursando']])
    ->count();

  

    $vercupo=DB::table('grupos')
    ->select('grupos.cupo')
    ->where('grupos.id_grupo','=',$id)
    ->take(1)
    ->first();

    $vercupo=$vercupo->cupo;

    if($activo<$vercupo){


     DB::table('detalle_grupos')
         ->where([['detalle_grupos.num_control', $id_est], ['detalle_grupos.nom_grupo', $id]])
         ->update(
             ['estado' => 'cursando' ,'equipo' => '2']);

          $result = DB::table('grupos')
 ->select('grupos.control_cupo')
->where('grupos.id_grupo',$id)
->take(1)
->first();



           $disminuir=($result->control_cupo)-1;
          


          DB::table('grupos')
              ->where('grupos.id_grupo',$id )
              ->update(['control_cupo' => $disminuir]);



            $si=DB::table('brigadas')
            ->select('brigadas.id_brigada')
            ->where('brigadas.id_grupo','=',$id)
            ->count();

if(!empty($si)){


       DB::table('detalle_brigadas')
       ->join('brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
         ->where([['detalle_brigadas.num_control', $id_est], ['brigadas.id_grupo', $id]])
         ->update(
             ['estado' => 'brigada']);  

              $brigada= DB::table('brigadas')
            ->select('brigadas.id_brigada','brigadas.cupo_brigada','brigadas.control_brigada')
            ->join('detalle_brigadas','detalle_brigadas.id_brigada','=','brigadas.id_brigada')
            ->where('detalle_brigadas.num_control','=',$id_est)
            ->take(1)
            ->first();

             $cupo=($brigada->control_brigada)-1;

             DB::table('brigadas')
              ->where('brigadas.id_brigada',$brigada->id_brigada)
              ->update(['control_brigada' => $cupo]);
 
}

         Session::flash('message','¡Se ha activado al estudiante!');
 return redirect()->back();




    }

      
    Session::flash('mess','¡No se puede activar el estudiante,cupo lleno!');
 return redirect()->back();



}



 public function mis_grupos_brigadas(){

    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }
   
   $id=$usuario_actual->id_user;
  
 $id_docente = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

   $id_p=$id_docente->id_docente;

    $semestre = DB::table('semestre')
         ->select('semestre.id_semestre')
         ->where('semestre.estatus_semestre', '=', 'actual')
         ->take(1)
         ->first();
          $semestre= $semestre->id_semestre;


    $grupos= DB::table('grupos')
    ->select('grupos.id_grupo', 'grupos.grupo', 'grupos.cupo', 'grupos.control_cupo','grupos.bandera','materias.materia','grupos.hora_inicio', 'grupos.hora_fin','grupos.id_semestre','grupos.clave','grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco','docentes.id_docente','areas.area')
  ->join('docentes','grupos.id_docente','=','docentes.id_docente')
      ->join('materias','grupos.id_materia','=','materias.id_materia')
      ->join('areas','areas.id_area','=','grupos.id_area')
  ->where([['grupos.id_docente',$id_p],['grupos.bandera', '=', '1'],['grupos.id_semestre', $semestre]])
 ->orderBy('grupos.created_at', 'asc')
  ->paginate(10);

  $det=DB::table('semestre')
  ->select('semestre.nombre_semestre')
         ->where('semestre.estatus_semestre', '=', 'actual')
         ->take(1)
         ->first();
          $det= $det->nombre_semestre;
     

     

    return view('docente.brigadas')->with('dato', $grupos)->with('detalle', $det);
    }



    public function formar_brigadas($id_grupo,$id_docente)
    {
      $usuario_actual=\Auth::user();
      if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
     }
     $semestre = DB::table('semestre')
     ->select('semestre.id_semestre')
     ->where('semestre.estatus_semestre', '=', 'actual')
     ->take(1)
     ->first();
     $semestre= $semestre->id_semestre;

     $id=$id_grupo;
     $id_doc=$id_docente;
     $check='cursando';

     $result = DB::table('detalle_grupos')
     ->select('detalle_grupos.nom_grupo')
     ->where([['detalle_grupos.nom_grupo','=',$id],['detalle_grupos.estado','=',$check]])
     ->count();

     $checa=DB::table('grupos')
     ->select('grupos.cupo','grupos.control_cupo')
     ->where([['grupos.id_grupo','=',$id]])
     ->take(1)
     ->first();

     $checa=$checa->cupo;

    $checa2=DB::table('grupos')
     ->select('grupos.cupo','grupos.control_cupo')
     ->where([['grupos.id_grupo','=',$id]])
     ->take(1)
     ->first();

   $checa2=$checa2->control_cupo;

     $brig = DB::table('brigadas')
     ->select('brigadas.nombre_brigada')
     ->where('brigadas.id_grupo','=',$id)
     ->count();

   if(empty($result) || $checa2!=0){
       Session::flash('mess','¡Aún no hay suficientes alumnos inscritos para formar brigadas!');
       return redirect()->back();
     }else{

      if($result==$checa){
       if(empty($brig)){

        $a=$result;
        $b=6;
        $r= intval($a/$b);
        $rb=$a % $b;

       //brigadas completas.
        if($rb==0){

         for ($i = 1; $i <= $r; $i++) {

          $modelx=new Brigada;
          $modelx->nombre_brigada=$i;
          $modelx->cupo_brigada=$b;
          $modelx->control_brigada=$b;
          $modelx->id_grupo=$id;
          $modelx->id_semestre=$semestre;
          $modelx->save();
        }

        Session::flash('message','¡Brigadas agregadas con éxito!');
        return redirect()->back();

      }else{


        if($rb==5){

          if($r==2){

            $r5=$r+1;

            for ($i = 1; $i <= $r5; $i++) {

             switch ($i) {

               case $i<=$r:
               $modelx=new Brigada;
               $modelx->nombre_brigada=$i;
               $modelx->cupo_brigada=$b;
               $modelx->control_brigada=$b;
               $modelx->id_grupo=$id;
               $modelx->id_semestre=$semestre;
               $modelx->save(); 
               break;

               case $i=$r5:
               $modelx=new Brigada;
               $modelx->nombre_brigada=$i;
               $modelx->cupo_brigada=$b-1;
               $modelx->control_brigada=$b-1;
               $modelx->id_grupo=$id;
               $modelx->id_semestre=$semestre;
               $modelx->save(); 

               break;
             }

           }

           Session::flash('message','¡Brigadas agregadas!');
           return redirect()->back();
         }

         if($r==3){

           for ($i = 1; $i <= $r; $i++) {

             switch ($i) {

               case $i<$r:
               $modelx=new Brigada;
               $modelx->nombre_brigada=$i;
               $modelx->cupo_brigada=$b+2;
               $modelx->control_brigada=$b+2;
               $modelx->id_grupo=$id;
               $modelx->id_semestre=$semestre;
               $modelx->save(); 
               break;

               case $i=$r:
               $modelx=new Brigada;
               $modelx->nombre_brigada=$i;
               $modelx->cupo_brigada=$b+1;
               $modelx->control_brigada=$b+1;
               $modelx->id_grupo=$id;
               $modelx->id_semestre=$semestre;
               $modelx->save(); 

               break;
             }

           }

           Session::flash('message','¡Brigadas agregadas!');
           return redirect()->back();
         }

         if($r==4){

           for ($i = 1; $i <= $r; $i++) {

             switch ($i) {

               case $i<$r:
               $modelx=new Brigada;
               $modelx->nombre_brigada=$i;
               $modelx->cupo_brigada=$b+1;
               $modelx->control_brigada=$b+1;
               $modelx->id_grupo=$id;
               $modelx->id_semestre=$semestre;
               $modelx->save(); 
               break;

               case $i=$r:
               $modelx=new Brigada;
               $modelx->nombre_brigada=$i;
               $modelx->cupo_brigada=$b+2;
               $modelx->control_brigada=$b+2;
               $modelx->id_grupo=$id;
               $modelx->id_semestre=$semestre;
               $modelx->save(); 

               break;
             }

           }

           Session::flash('message','¡Brigadas agregadas!');
           return redirect()->back();
         }

         if($r==5){

           for ($i = 1; $i <= $r; $i++) {

             switch ($i) {

               case $i<=$r:
               $modelx=new Brigada;
               $modelx->nombre_brigada=$i;
               $modelx->cupo_brigada=$b+1;
               $modelx->control_brigada=$b+1;
               $modelx->id_grupo=$id;
               $modelx->id_semestre=$semestre;
               $modelx->save(); 

               break;
             }

           }

           Session::flash('message','¡Brigadas agregadas!');
           return redirect()->back();
         }

         $r6=$r-4;

         for ($i = 1; $i <= $r; $i++) {


           switch ($i) {

             case $i<$r6:
             $modelx=new Brigada;
             $modelx->nombre_brigada=$i;
             $modelx->cupo_brigada=$b;
             $modelx->control_brigada=$b;
             $modelx->id_grupo=$id;
             $modelx->id_semestre=$semestre;
             $modelx->save(); 

             break;

             case $i<=$r:
             $modelx=new Brigada;
             $modelx->nombre_brigada=$i;
             $modelx->cupo_brigada=$b+1;
             $modelx->control_brigada=$b+1;
             $modelx->id_grupo=$id;
             $modelx->id_semestre=$semestre;
             $modelx->save(); 

             break;

           }

         }

         Session::flash('message','¡Brigadas agregadas!');
         return redirect()->back();




       }

       if($rb==4){

        if($r==2){

         for ($i = 1; $i <= $r; $i++) {

           switch ($i) {

             case $i<$r:
             $modelx=new Brigada;
             $modelx->nombre_brigada=$i;
             $modelx->cupo_brigada=$b+2;
             $modelx->control_brigada=$b+2;
             $modelx->id_grupo=$id;
             $modelx->id_semestre=$semestre;
             $modelx->save(); 
             break;

             case $i=$r:
             $modelx=new Brigada;
             $modelx->nombre_brigada=$i;
             $modelx->cupo_brigada=$b+2;
             $modelx->control_brigada=$b+2;
             $modelx->id_grupo=$id;
             $modelx->id_semestre=$semestre;
             $modelx->save(); 

             break;
           }

         }

         Session::flash('message','¡Brigadas agregadas!');
         return redirect()->back();
       }

       if($r==3){

         for ($i = 1; $i <= $r; $i++) {

           switch ($i) {

             case $i<$r:
             $modelx=new Brigada;
             $modelx->nombre_brigada=$i;
             $modelx->cupo_brigada=$b+1;
             $modelx->control_brigada=$b+1;
             $modelx->id_grupo=$id;
             $modelx->id_semestre=$semestre;
             $modelx->save(); 
             break;

             case $i=$r:
             $modelx=new Brigada;
             $modelx->nombre_brigada=$i;
             $modelx->cupo_brigada=$b+2;
             $modelx->control_brigada=$b+2;
             $modelx->id_grupo=$id;
             $modelx->id_semestre=$semestre;
             $modelx->save(); 

             break;
           }

         }

         Session::flash('message','¡Brigadas agregadas!');
         return redirect()->back();
       }

       $r4=$r-3;

       for ($i = 1; $i <= $r; $i++) {


         switch ($i) {

           case $i<$r4:
           $modelx=new Brigada;
           $modelx->nombre_brigada=$i;
           $modelx->cupo_brigada=$b;
           $modelx->control_brigada=$b;
           $modelx->id_grupo=$id;
           $modelx->id_semestre=$semestre;
           $modelx->save(); 

           break;

           case $i<$r:
           $modelx=new Brigada;
           $modelx->nombre_brigada=$i;
           $modelx->cupo_brigada=$b+1;
           $modelx->control_brigada=$b+1;
           $modelx->id_grupo=$id;
           $modelx->id_semestre=$semestre;
           $modelx->save(); 

           break;

           case $i=$r:
           $modelx=new Brigada;
           $modelx->nombre_brigada=$i;
           $modelx->cupo_brigada=$b+1;
           $modelx->control_brigada=$b+1;
           $modelx->id_grupo=$id;
           $modelx->id_semestre=$semestre;
           $modelx->save(); 

           break;
         }

       }

       Session::flash('message','¡Brigadas agregadas!');
       return redirect()->back();



       
     }else{

      if($rb==3){

        if($r==2){

         for ($i = 1; $i <= $r; $i++) {

          switch ($i) {

           case $i<$r:
           $modelx=new Brigada;
           $modelx->nombre_brigada=$i;
           $modelx->cupo_brigada=$b+1;
           $modelx->control_brigada=$b+1;
           $modelx->id_grupo=$id;
           $modelx->id_semestre=$semestre;
           $modelx->save(); 

           break;

           case $i=$r:
           $modelx=new Brigada;
           $modelx->nombre_brigada=$i;
           $modelx->cupo_brigada=$b+2;
           $modelx->control_brigada=$b+2;
           $modelx->id_grupo=$id;
           $modelx->id_semestre=$semestre;
           $modelx->save(); 

           break;
         }


       }

       Session::flash('message','¡Brigadas agregadas!');
       return redirect()->back();


     }

     $r3=$r-2;

     for ($i = 1; $i <= $r; $i++) {


       switch ($i) {

         case $i<$r3:
         $modelx=new Brigada;
         $modelx->nombre_brigada=$i;
         $modelx->cupo_brigada=$b;
         $modelx->control_brigada=$b;
         $modelx->id_grupo=$id;
         $modelx->id_semestre=$semestre;
         $modelx->save(); 

         break;

         case $i<$r:
         $modelx=new Brigada;
         $modelx->nombre_brigada=$i;
         $modelx->cupo_brigada=$b+1;
         $modelx->control_brigada=$b+1;
         $modelx->id_grupo=$id;
         $modelx->id_semestre=$semestre;
         $modelx->save(); 

         break;

         case $i=$r:
         $modelx=new Brigada;
         $modelx->nombre_brigada=$i;
         $modelx->cupo_brigada=$b+1;
         $modelx->control_brigada=$b+1;
         $modelx->id_grupo=$id;
         $modelx->id_semestre=$semestre;
         $modelx->save(); 

         break;
       }

     }

     Session::flash('message','¡Brigadas agregadas!');
     return redirect()->back();

   }else{

    if($rb==1){

      $r2=$r-1;

      for ($i = 1; $i <= $r; $i++) {

       switch ($i) {

         case $i<=$r2:
         $modelx=new Brigada;
         $modelx->nombre_brigada=$i;
         $modelx->cupo_brigada=$b;
         $modelx->control_brigada=$b;
         $modelx->id_grupo=$id;
         $modelx->id_semestre=$semestre;
         $modelx->save(); 

         break;

         case $i=$r:
         $modelx=new Brigada;
         $modelx->nombre_brigada=$i;
         $modelx->cupo_brigada=$b+1;
         $modelx->control_brigada=$b+1;
         $modelx->id_grupo=$id;
         $modelx->id_semestre=$semestre;
         $modelx->save(); 

         break;
       }
     }

     Session::flash('message','¡Brigadas registradas!');
     return redirect()->back();

   }else{

    if($rb==2){

      $r5=$r-2;

      for ($i = 1; $i <= $r; $i++) {

       switch ($i) {

         case $i<=$r5:
         $modelx=new Brigada;
         $modelx->nombre_brigada=$i;
         $modelx->cupo_brigada=$b;
         $modelx->control_brigada=$b;
         $modelx->id_grupo=$id;
         $modelx->id_semestre=$semestre;
         $modelx->save(); 

         break;
         case $i<=$r:
         $modelx=new Brigada;
         $modelx->nombre_brigada=$i;
         $modelx->cupo_brigada=$b+1;
         $modelx->control_brigada=$b+1;
         $modelx->id_grupo=$id;
         $modelx->id_semestre=$semestre;
         $modelx->save(); 

         break;
       }
     }

     Session::flash('message','¡Brigadas agregadas!');
     return redirect()->back();

   }
 }
}
}
}
}
Session::flash('mess','¡Ya hay brigadas formadas!');
return redirect()->back();

}else{

 Session::flash('mess','¡Hay alumnos dados de baja actualize las brigadas!');
 return redirect()->back();


}
}
}

 public function brigadas_formadas($id_grupo,$id_docente){

       $usuario_actual=\Auth::user();
      if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
     }
     $semestre = DB::table('semestre')
     ->select('semestre.id_semestre','semestre.nombre_semestre')
     ->where('semestre.estatus_semestre', '=', 'actual')
     ->take(1)
     ->first();
     $semestre= $semestre->nombre_semestre;

     $id=$id_grupo;
     $id_doc=$id_docente;

      $grup = DB::table('grupos')
     ->select('grupos.id_grupo','grupos.grupo','materias.materia')
       ->join('materias','grupos.id_materia','=','materias.id_materia')

     ->where('grupos.id_grupo', '=',$id )
     ->take(1)
     ->first();

     $grup=$grup->grupo;

      $mate = DB::table('grupos')
     ->select('grupos.id_grupo','grupos.grupo','materias.materia')
       ->join('materias','grupos.id_materia','=','materias.id_materia')

     ->where('grupos.id_grupo', '=',$id )
     ->take(1)
     ->first();


     $mate=$mate->materia;

       $infor = DB::table('grupos')
     ->select('grupos.id_grupo','grupos.grupo','materias.materia')
       ->join('materias','grupos.id_materia','=','materias.id_materia')

     ->where('grupos.id_grupo', '=',$id )
     ->take(1)
     ->first();


     $infor=$infor->id_grupo;

      $info = DB::table('grupos')
     ->select('grupos.cupo','grupos.control_cupo')
     ->where('grupos.id_grupo', '=',$id )
     ->take(1)
     ->first();

      $brig = DB::table('brigadas')
     ->select('brigadas.nombre_brigada')
     ->where('brigadas.id_grupo','=',$id)
     ->count();

     $check='cursando';

     $result = DB::table('detalle_grupos')
     ->select('detalle_grupos.nom_grupo')
     ->where([['detalle_grupos.nom_grupo','=',$id],['detalle_grupos.estado','=',$check]])
     ->count();







$brigada = DB::table('brigadas')
->select('brigadas.id_brigada','brigadas.cupo_brigada','brigadas.control_brigada','brigadas.nombre_brigada')
->where('brigadas.id_grupo','=',$id)
->orderBy('brigadas.nombre_brigada')
->get();  
//  ->count();

     

    return view('docente.brigadas_formadas')->with('dato', $brigada)->with('detalle',$grup)->with('detalles',$mate)->with('info',$info)->with('num',$brig)->with('det',$result)->with('deta',$infor)->with('doce',$id_doc);
    }



      
public function registro_brigada($deta,$doce){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      }

      $id=$deta;
      $id_doc=$doce;

      $info = DB::table('grupos')
     ->select('grupos.grupo')
     ->where('grupos.id_grupo', '=',$id )
     ->take(1)
     ->first();

     $grupo=DB::table('grupos')
  ->select('grupos.cupo')
  ->where('grupos.id_grupo',$id)
  ->take(1)
  ->first();

  $grupo=$grupo->cupo;

  $brigada=DB::table('brigadas')
  ->select('brigadas.cupo_brigada')
  ->where('brigadas.id_grupo',$id)
  ->get();

  $suma=0;
  foreach ($brigada as $c =>$valor ) {
    $thearray = (array) $valor;
    $n=$valor->cupo_brigada;
    $suma += $n;
  }

  $vale=$suma;


  $conta=$vale+3;

  if($grupo<$conta){

      Session::flash('mess','¡Ya existen suficientes brigadas para este grupo!');
     return redirect()->back();


  }



  return view('docente.registro_nueva_brigada')->with('grupo',$id)->with('name',$info);
}

public function registrar_brigadas_nueva(Request $request){

 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='docente'){
       return redirect()->back();
      } 

      $semestre = DB::table('semestre')
         ->select('semestre.id_semestre')
         ->where('semestre.estatus_semestre', '=', 'actual')
         ->take(1)
         ->first();
          $semestre= $semestre->id_semestre;
 
  $data = $request;
  $id_grupo=$data['id_grupo'];


     $grupo=DB::table('grupos')
  ->select('grupos.cupo')
  ->where('grupos.id_grupo',$id_grupo)
  ->take(1)
  ->first();

  $grupo=$grupo->cupo;

  $brigada=DB::table('brigadas')
  ->select('brigadas.cupo_brigada')
  ->where('brigadas.id_grupo',$id_grupo)
  ->get();

  $suma=0;
  foreach ($brigada as $c =>$valor ) {
    $thearray = (array) $valor;
    $n=$valor->cupo_brigada;
    $suma += $n;
  }

  $vale=$suma;

  $valor=$data['cupo_brigada'];


  $conta=$vale+$valor;

  if($conta>$grupo){

 Session::flash('mess','¡El numero de integrantes exede el cupo del grupo!');
  return redirect()->back();



  }

  $modelx=new Brigada;
  $modelx->nombre_brigada=$data['nombre_brigada'];
  $modelx->cupo_brigada=$data['cupo_brigada'];
  $modelx->control_brigada=$data['cupo_brigada'];
  $modelx->id_grupo=$id_grupo;
  $modelx->id_semestre=$semestre;
  $modelx->save();
  Session::flash('message','¡Brigada creada!');
  return redirect()->back();


  }

   public function llenar_brigada($id_brigada){

    $data = $id_brigada;

    $cupo = DB::table('brigadas')
    ->select('brigadas.cupo_brigada')
    ->where('brigadas.id_brigada', '=', $data)
    ->take(1)
    ->first();

    $cupo=$cupo->cupo_brigada;

     $grupo = DB::table('brigadas')
    ->select('brigadas.id_grupo')
    ->where('brigadas.id_brigada', '=', $data)
    ->take(1)
    ->first();

    $grupo=$grupo->id_grupo;


     $aa = DB::table('detalle_brigadas')
      ->select('detalle_brigadas.id_brigada')
      ->join('brigadas', 'brigadas.id_brigada', '=', 'detalle_brigadas.id_brigada')
      ->where('detalle_brigadas.id_brigada',$data)
      ->take(1)
      ->first();

      if(empty($aa)){

 $contar=DB::table('detalle_grupos')
 ->select('detalle_grupos.num_control')
->where([['detalle_grupos.nom_grupo','=',$grupo],['detalle_grupos.estado','=','cursando']])
->count();



$grup=DB::table('grupos')
->select('grupos.cupo')
->where('grupos.id_grupo','=',$grupo)
->take(1)
->first();

$grup=$grup->cupo;


if($contar<$grup){

   Session::flash('mess','No hay alumnos suficientes para llenar la brigada');
      return redirect()->back();


}

  $periodo_semestre = DB::table('semestre')
  ->select('semestre.id_semestre')
  ->where('semestre.estatus_semestre', '=', 'actual')
  ->take(1)
  ->first();
 $periodo_semestre= $periodo_semestre->id_semestre;

 $uno=1;
 $dos=2;

$result = DB::table('detalle_grupos')
 ->select('detalle_grupos.num_control')
 ->where([['detalle_grupos.nom_grupo','=',$grupo],['detalle_grupos.equipo','=',$uno]])
->take($cupo)
->get();

$control = DB::table('brigadas')
 ->select('brigadas.control_brigada')
->where('brigadas.id_brigada',$data)
->take(1)
->first();





   foreach ($result as $c =>$valor  ) {

    $thearray = (array) $valor;
    $n=$valor->num_control;
     
  $inscripcion = new Detalle_brigada;
  $inscripcion->num_control= $n;
  $inscripcion->id_brigada= $data;
  $inscripcion->cargo= 'miembro';
  $inscripcion->id_semestre= $periodo_semestre;
  $inscripcion->estado= 'brigada';

  $inscripcion->save();

/*  DB::table('estudiantes')
              ->where('estudiantes.num_control',$n )
              ->update(['id_brigada' => $data]);*/

              DB::table('detalle_grupos')
              ->where('detalle_grupos.num_control',$n )
              ->update(['equipo' => $dos]);
      
}



 $reducir=($control->control_brigada)-$cupo;
          DB::table('brigadas')
              ->where('brigadas.id_brigada',$data )
              ->update(['control_brigada' => $reducir]);


      Session::flash('message','Inscripción realizada correctamente');
      return redirect()->back();
    }

     Session::flash('mess','La brigada ya ha sido registrada');
      return redirect()->back();


  }

   public function inscritos_brigada($id_brigada)
{

      $data=$id_brigada;

      $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('brigadas')
      ->select('brigadas.id_brigada','brigadas.id_grupo','estudiantes.num_control', 'personas.nombre','personas.apellido_paterno','personas.apellido_materno','detalle_brigadas.cargo')

      ->join('grupos','grupos.id_grupo','=','brigadas.id_grupo')
      ->join('detalle_brigadas', 'detalle_brigadas.id_brigada', '=', 'brigadas.id_brigada')
      ->join('estudiantes', 'estudiantes.num_control', '=', 'detalle_brigadas.num_control')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')

      ->where([['brigadas.bandera', '=' , '1'] ,
       ['detalle_brigadas.id_brigada', $data], ['detalle_brigadas.estado','brigada'],    
       ['brigadas.id_semestre', $periodo_semestre->id_semestre]])
      ->orderBy('personas.nombre', 'asc')
      ->simplePaginate(10);

       $name = DB::table('brigadas')
      ->select('brigadas.nombre_brigada')
      ->where('brigadas.id_brigada', '=', $data)
      ->take(1)
      ->first();

      $grup=DB::table('brigadas')
      ->select('brigadas.id_grupo')
      ->where('brigadas.id_brigada','=',$data)
      ->take(1)
      ->first();

      $grup=$grup->id_grupo;

      $nameg=DB::table('grupos')
      ->select('grupos.grupo')
      ->where('grupos.id_grupo','=',$grup)
       ->take(1)
      ->first();

      $nameg=$nameg->grupo;


       $gid=DB::table('grupos')
      ->select('grupos.id_grupo')
      ->where('grupos.id_grupo','=',$grup)
       ->take(1)
      ->first();

      $gid=$gid->id_grupo;







  return view('docente.inscritos_brigada')->with('brig',$result)->with('nbrigada',$name)->with('ngrupo',$nameg)->with('idgrup',$gid);

}

public function brigada_completar($id_brigada){

$id=$id_brigada;

$brig=DB::table('brigadas')
->select('brigadas.nombre_brigada')
->where('brigadas.id_brigada',$id)
->take(1)
->first();

$brig=$brig->nombre_brigada;

$conta=DB::table('brigadas')
->select('brigadas.id_grupo')
->where('brigadas.id_brigada','=',$id)
->take(1)
->first();

$conta=$conta->id_grupo;


$con=DB::table('grupos')
->select('grupos.cupo')
->where('grupos.id_grupo','=',$conta)
->take(1)
->first();
$con=$con->cupo;

$contar=DB::table('detalle_grupos')
 ->select('detalle_grupos.num_control')
->where([['detalle_grupos.nom_grupo','=',$conta],['detalle_grupos.estado','=','cursando']])
->count();

if($contar<$con){

    Session::flash('mess','¡Aún no hay alumnos suficientes en el grupo para completarla!');
      return redirect()->back();


}

$completa=DB::table('detalle_grupos')
->select('detalle_grupos.num_control','estudiantes.num_control', 'personas.nombre','personas.apellido_paterno','personas.apellido_materno')
 ->join('estudiantes', 'estudiantes.num_control', '=', 'detalle_grupos.num_control')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
->where([['detalle_grupos.nom_grupo','=',$conta],['detalle_grupos.equipo','=','1'],
  ['detalle_grupos.estado','=','cursando']])
->get();




return view('docente.completar_brigada')->with('nom',$brig)->with('completar',$completa)->with('id',$id);


  }

  public function completar_estudiante_brigada(Request $request)
    { 
        $data = $request;

        $nc=$data['cambio'];
        $brig=$data['id_brigada'];

         $periodo_semestre = DB::table('semestre')
  ->select('semestre.id_semestre')
  ->where('semestre.estatus_semestre', '=', 'actual')
  ->take(1)
  ->first();
 $periodo_semestre= $periodo_semestre->id_semestre;

 $control = DB::table('brigadas')
 ->select('brigadas.control_brigada')
->where('brigadas.id_brigada',$brig)
->take(1)
->first();

 $cupo = DB::table('brigadas')
    ->select('brigadas.cupo_brigada')
    ->where('brigadas.id_brigada', '=', $brig)
    ->take(1)
    ->first();

    $cupo=$cupo->cupo_brigada;


  $inscripcion = new Detalle_brigada;
  $inscripcion->num_control= $nc;
  $inscripcion->id_brigada= $brig;
  $inscripcion->cargo= 'miembro';
  $inscripcion->id_semestre= $periodo_semestre;
  $inscripcion->estado= 'brigada';

  $inscripcion->save();

  $dos=2;

 DB::table('detalle_grupos')
              ->where('detalle_grupos.num_control',$nc )
              ->update(['equipo' => $dos]);

$reducir=($control->control_brigada)-$cupo;
          DB::table('brigadas')
              ->where('brigadas.id_brigada',$brig )
              ->update(['control_brigada' => $reducir]);

                Session::flash('message','Inscripción realizada correctamente');
      return redirect()->back();



      }



  public function nombrar_jefe($id_brigada,$num_control){

    $data=$id_brigada;
    $dato=$num_control;

    $car='jefe';

    $checa=DB::table('detalle_brigadas')
    ->select('detalle_brigadas.num_control')
    ->where([['detalle_brigadas.id_brigada','=',$data],['detalle_brigadas.cargo','=',$car]])
    ->take(1)
    ->first();



    if(empty($checa)){


    $jefe='jefe';

    DB::table('detalle_brigadas')
     ->where([['detalle_brigadas.num_control','=',$dato],['detalle_brigadas.id_brigada','=',$data]])
    ->update(['cargo' => $jefe]);

    Session::flash('message','¡Jefe de brigada registrado con éxito!');
    return redirect()->back();



    }

    $m='miembro';
    $j='jefe';
      $car2='jefe';

      $checa2=DB::table('detalle_brigadas')
    ->select('detalle_brigadas.cargo')
    ->where([['detalle_brigadas.id_brigada','=',$data],['detalle_brigadas.cargo','=',$car2]])
    ->take(1)
    ->first();



    $checa2=$checa2->cargo;

     $checa3=DB::table('detalle_brigadas')
    ->select('detalle_brigadas.num_control')
    ->where([['detalle_brigadas.id_brigada','=',$data],['detalle_brigadas.cargo','=',$car2]])
    ->take(1)
    ->first();



    $checa3=$checa3->num_control;


     DB::table('detalle_brigadas')
     ->where([['detalle_brigadas.num_control','=',$checa3],['detalle_brigadas.id_brigada','=',$data]])
    ->update(['cargo' => $m]);

     DB::table('detalle_brigadas')
     ->where([['detalle_brigadas.num_control','=',$dato],['detalle_brigadas.id_brigada','=',$data]])
    ->update(['cargo' => $car]);

    Session::flash('message','¡Jefe de brigada actualizado con éxito!');
    return redirect()->back();

}

   public function cambio_brigada($id_brigada,$num_control){

    $idb=$id_brigada;
    $numc=$num_control;

    $con=DB::table('brigadas')
->select('brigadas.id_grupo')
->where('brigadas.id_brigada','=',$idb)
->take(1)
->first();

$con=$con->id_grupo;

$name=DB::table('detalle_brigadas')
->select('detalle_brigadas.num_control','brigadas.nombre_brigada','estudiantes.num_control','personas.nombre','personas.apellido_paterno','personas.apellido_materno')
->join('brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
->join('estudiantes', 'estudiantes.num_control', '=', 'detalle_brigadas.num_control')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where('estudiantes.num_control','=',$numc)
      ->take(1)
      ->first();

 

$num=DB::table('detalle_brigadas')
->select('brigadas.nombre_brigada','detalle_brigadas.num_control','estudiantes.num_control', 'personas.nombre','personas.apellido_paterno','personas.apellido_materno')
->join('brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
->join('grupos','grupos.id_grupo','=','brigadas.id_grupo')
 ->join('estudiantes', 'estudiantes.num_control', '=', 'detalle_brigadas.num_control')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
->where([['grupos.id_grupo','=',$con],['detalle_brigadas.cargo','=','miembro'],['detalle_brigadas.num_control','!=',$numc],['detalle_brigadas.estado','=','brigada'],['detalle_brigadas.id_brigada','!=',$idb]])
 ->get();

return view('docente.cambio_brigada')->with('data',$num)->with('info',$name);

 }

   public function cambiar_estudiante_brigada(Request $request)
    { 
        $data = $request;

        $nc=$data['num_control'];
        $ncam=$data['cambio'];


        $cambio=DB::table('detalle_brigadas')
        ->select('detalle_brigadas.id_brigada')
        ->where('detalle_brigadas.num_control','=',$nc)
        ->take(1)
        ->first();

        $cambio=$cambio->id_brigada;



        $cambiar=DB::table('detalle_brigadas')
        ->select('detalle_brigadas.id_brigada')
        ->where('detalle_brigadas.num_control','=',$ncam)
        ->take(1)
        ->first();

        $cambiar=$cambiar->id_brigada;

      
     

        DB::table('detalle_brigadas')
    ->where('detalle_brigadas.num_control', $nc)
    ->update(['id_brigada' => $cambiar]);

           DB::table('detalle_brigadas')
    ->where('detalle_brigadas.num_control', $ncam)
    ->update(['id_brigada' => $cambio]);




      Session::flash('message','¡Cambio realizado!');
        return redirect()->route('inscritos_brigada',['id_brigada' => $cambiar]);

//  return redirect()->route('brigadas_grupos');

      }


    

    










}









