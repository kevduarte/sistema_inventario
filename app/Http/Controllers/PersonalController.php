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



class PersonalController extends Controller
{

	//mostrar la pag. principal del personal
	public function home(){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

  $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personal.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;


  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;

   $nombre=DB::table('areas')
   ->select('areas.area')
   ->where('areas.id_area',$a)
    ->take(1)
  ->first();

$materiales=DB::table('materiales')
->select('materiales.id_material','materiales.marca','materiales.modelo','materiales.nombre_material','areas.area','tipos.tipo')

->join('areas','materiales.id_area','=','areas.id_area')
->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
 ->where([['materiales.bandera', '=', '1'], ['areas.id_area', '=', $a]])
  ->simplePaginate(10);

		return view('personal.home_personal')->with('mate',$materiales)->with('arean',$nombre);
	}

  // ver unidades
  public function ver_unidad_area($id_material){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

    $data = $id_material;


    
    $mater = DB::table('unidades')
    ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','unidades.num_serie','materiales.nombre_material','materiales.id_material','unidades.medida','unidades.descripcion')
    ->join('materiales','materiales.id_material','=','unidades.id_material')
        ->where([['unidades.id_material','=',$data],['unidades.estado','!=','eliminado']])
    ->simplePaginate(6);

    $name = DB::table('unidades')
    ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida')
    ->join('materiales','materiales.id_material','=','unidades.id_material')
    ->where('materiales.id_material', '=', $data)
    ->take(1)
    ->first();
         $name=$name->nombre_material;

         $contar=DB::table('unidades')
         ->select('unidades.id_material')
         ->where([['unidades.id_material','=',$data],['unidades.estado','!=','eliminado']])
         ->count();

          $conta=DB::table('unidades')
         ->select('unidades.id_material')
         ->where([['unidades.id_material','=',$data],['unidades.estado','=','disponible']])
         ->count();

          $cont=DB::table('unidades')
         ->select('unidades.id_material')
         ->where([['unidades.id_material','=',$data],['unidades.bandera','=','0']])
         ->count();

    
   return view("personal.ver_unidades_area")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
     ->with('disponible',$conta)->with('no',$cont);
      //no  te carga porque no le esas diciendo que cargar
}



 //home del admin con la busqueda.
  public function buscar_material_home(Request $request){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

       $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personal.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;


  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;

   $nombre=DB::table('areas')
   ->select('areas.area')
   ->where('areas.id_area',$a)
    ->take(1)
  ->first();


   


    $bus = $request->get('buscador');

    if($bus != null){
      $mats = Material::where( 'materiales.nombre_material', 'LIKE', '%' . $bus . '%')
      ->where([['materiales.bandera', '=', '1'], ['areas.id_area', '=', $a]])
      ->join('areas','materiales.id_area','=','areas.id_area')
      ->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
      ->paginate(7);

      if (count ($mats) > 0 ) {
          
        return view ( 'personal.home_personal' )
        ->withInfo ($mats)
        ->withQuery ($bus)->with('arean',$nombre);
   

      }else{
        Session::flash('mess','No hay materiales registrados que coincidan con la búsqueda');
        return redirect()->route('personal')->with('arean',$nombre);
      }
    }else{
      Session::flash('mess','Material no encontrado');
      return redirect()->route('personal')->with('arean',$nombre);
      //return redirect()->route('busqueda_material');
    }
  }


	 public function busqueda_material_per()
    {
       $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='personal'){
       return redirect()->back();
      }
  
  
         return view('personal.busqueda_material_per');
    }

    //busqueda por n_serie y área
 public function buscar_materiales_per(Request $request){

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='personal'){
       return redirect()->back();
      }

      $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_persona')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_persona;

  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_persona',$id_p)
 ->take(1)
  ->first();

  //dd($area);
  $a=$area->id_area;
 // $a= json_decode( json_encode($a), true);
   $nombre=DB::table('areas')
   ->select('areas.area')
   ->where('areas.id_area',$a)
    ->take(1)
  ->first();
  $bus = $request->get('buscador');

  if($bus != null){
    $mats = Material::where( 'materiales.nombre_material', 'LIKE', '%' . $bus . '%')
        ->where([['materiales.bandera', '=', '1'], ['areas.id_area', '=', $a]])
        ->join('areas','materiales.id_area','=','areas.id_area')
        ->join('tipos','materiales.id_tipo','=','tipos.id_tipo')

        ->Paginate(5);

        if (count ($mats) > 0 ) {

          return view ( 'personal.busqueda_material_per' )->withDetails ($mats )->withQuery ($bus);
        }else{
          Session::flash('message','Material no encontrado');
          return redirect()->route('busqueda_material_per');
        }
    } else{
      Session::flash('message','Material encontrado');
      return redirect()->route('busqueda_material_per');
    }
       


    }


    public function material_activo_personal(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

   $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;

  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  //dd($area);
  $a=$area->id_area;
 // $a= json_decode( json_encode($a), true);
   $nombre=DB::table('areas')
   ->select('areas.area')
   ->where('areas.id_area',$a)
    ->take(1)
  ->first();

  $nombre=$nombre->area;

       
       $est = DB::table('materiales')
      ->select('materiales.id_material', 'materiales.nombre_material','materiales.modelo', 'materiales.marca','materiales.updated_at', 'areas.area', 'tipos.tipo')
        ->join('areas', 'materiales.id_area', '=', 'areas.id_area')
        
        ->join('tipos', 'materiales.id_tipo', '=', 'tipos.id_tipo')
        ->where([['materiales.bandera', '=', '1'], ['areas.id_area', '=', $a]])

         ->orderBy('materiales.updated_at', 'DESC')
        ->simplePaginate(5);




  return view('personal.material_activo_area')->with('activo', $est)->with('area',$nombre);
}

  public function material_inactivo_personal(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

      $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;

  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  //dd($area);
  $a=$area->id_area;
 // $a= json_decode( json_encode($a), true);
   $nombre=DB::table('areas')
   ->select('areas.area')
   ->where('areas.id_area',$a)
    ->take(1)
  ->first();

  $nombre=$nombre->area;

       
       $est = DB::table('materiales')
      ->select('materiales.id_material', 'materiales.nombre_material','materiales.modelo', 'materiales.marca','materiales.updated_at', 'areas.area', 'tipos.tipo')
        ->join('areas', 'materiales.id_area', '=', 'areas.id_area')
        
        ->join('tipos', 'materiales.id_tipo', '=', 'tipos.id_tipo')
        ->where([['materiales.bandera', '=', '0'], ['areas.id_area', '=', $a]])

         ->orderBy('materiales.updated_at', 'DESC')
        ->simplePaginate(5);


        return view('personal.material_inactivo_area')->with('inactivo', $est)->with('area',$nombre);

}

    //detalles material
  public function detalles_material_per($id_material){
      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='personal'){
       return redirect()->back();
      }

    $data = $id_material;
    $mater = DB::table('unidades')
    ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','materiales.num_serie','unidades.observaciones')
    ->join('materiales','materiales.id_material','=','unidades.id_material')
    ->where('materiales.id_material', '=', $data)
    ->simplePaginate(6);

    return view("personal.detalles_material_per")->with('material', $data)->with('unidades',$mater); 
  }

  protected function desactivar_unidad_area($codigo_unidad){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='personal'){
       return redirect()->back();
      }
    $data = $codigo_unidad;
    $unid = DB::table('unidades')
    ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.bandera','unidades.estado','materiales.nombre_material','materiales.id_material')
    ->join('materiales','materiales.id_material','=','unidades.id_material')
    
    ->where('unidades.codigo_unidad', '=', $data)
    ->take(1)
    ->first();

    return view("personal.desactivar_unidad_area")->with('unidad', $unid); 
  }

   public function baja_unidad(Request $request){
        $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='personal'){
       return redirect()->back();
      }
     $data = $request;
     DB::table('unidades')
     ->where('codigo_unidad', $data['codigo_unidad'])
     ->update(['observaciones' =>$data['observaciones'],'bandera'=>'0','estado'=>'no disponible']);
     
 
     
     Session::flash('message','Unidad desactivada con éxito ');
    return redirect()->back();
 }




     public function solicitudes_area()
    {
        $usuario_actual=\Auth::user();
      if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

       $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;

   $semestre = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre=$semestre->id_semestre;

    $semestre1 = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre1=$semestre1->nombre_semestre;


  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;

  $name= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $name=$name->area;

      
  $aprobadas=DB::table('solicitudes')
  ->select('solicitudes.id_solicitud','solicitudes.fecha_solicitud','solicitudes.fecha_prestamo','solicitudes.estado','grupos.grupo','grupos.hora_inicio','grupos.hora_fin','personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
  ->join('areas','solicitudes.id_area','=','areas.id_area')
  ->join('docentes','solicitudes.id_docente','=','docentes.id_docente')
  ->join('personas','docentes.id_persona','=','personas.id_persona')
  ->where([['solicitudes.id_semestre', '=', $semestre],['solicitudes.estado','=','aprobada'],['solicitudes.id_area','=',$a]])
  ->orderBy('solicitudes.updated_at','DESC')
  ->paginate(8);
      
    return view('personal.prestamos.solicitudes')->with('solicitudes',$aprobadas)->with('semestre',$semestre1)->with('nombrearea',$name);
    }

    public function detalles_solicitud($id_solicitud)
{
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

      $solicitud=$id_solicitud;

      $id=$usuario_actual->id_user;

      $id_personal = DB::table('personal')
      ->select('personal.id_personal')
      ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
      ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
      ->where('users.id_user', $id)
      ->take(1)
      ->first();
      $id_p=$id_personal->id_personal;



  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;
    

     $grupo=DB::table('solicitudes')
     ->select('grupos.grupo')
     ->join('grupos','solicitudes.id_grupo','grupos.id_grupo')
     ->where('solicitudes.id_solicitud',$solicitud)
     ->take(1)
     ->first();

     $grupo=$grupo->grupo;

     $detalles2=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','brigadas.nombre_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
     ->where('vales.id_solicitud','=',$solicitud)
   ->take(1)
     ->first();

     $detalles2=$detalles2->fecha_prestamo_vale;

      $detalles3=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','brigadas.nombre_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
     ->where('vales.id_solicitud','=',$solicitud)
   ->take(1)
     ->first();

     $detalles3=$detalles3->hora_inicio_vale;

      $detalles4=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','brigadas.nombre_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
     ->where('vales.id_solicitud','=',$solicitud)
   ->take(1)
     ->first();

     $detalles4=$detalles4->hora_fin_vale;


         $detalles=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','vales.estado_vale','brigadas.nombre_brigada','areas.area','brigadas.cupo_brigada','brigadas.control_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
      ->join('areas','vales.id_area','=','areas.id_area')
     ->where([['vales.id_solicitud','=',$solicitud],['vales.id_area','=',$a]])
     ->paginate(10);

	return view('personal/prestamos.detalle_solicitud')->with('detalle',$detalles)->with('grupo',$grupo)
  ->with('fecha_practica',$detalles2)
    ->with('inicio',$detalles3)
      ->with('final',$detalles4);
}





 public function detalles_vale($id_vale)
{

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }


      $vale=$id_vale;
      $id=$usuario_actual->id_user;

      $id_personal = DB::table('personal')
      ->select('personal.id_personal')
      ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
      ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
      ->where('users.id_user', $id)
      ->take(1)
      ->first();
      $id_p=$id_personal->id_personal;

      $area= DB::table('areas')
      ->select('areas.id_area','areas.area')
      ->join('personal','personal.id_area','=','areas.id_area')
      ->where('personal.id_personal',$id_p)
      ->take(1)
      ->first();

      $a=$area->id_area;

        $detalle=DB::table('vales')
      ->select('vales.id_vale','brigadas.nombre_brigada','brigadas.cupo_brigada','brigadas.control_brigada','personas.nombre','personas.apellido_paterno','personas.apellido_materno','estudiantes.num_control','detalle_brigadas.cargo')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
      ->join('detalle_brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
      ->join('estudiantes','detalle_brigadas.num_control','=','estudiantes.num_control')
      ->join('personas','estudiantes.id_persona','=','personas.id_persona')
     ->where([['vales.id_vale','=',$vale],['vales.id_area','=',$a]])
     ->paginate(10);


     $name=DB::table('vales')
     ->select('vales.id_vale','brigadas.nombre_brigada')
     ->join('brigadas','vales.id_brigada','brigadas.id_brigada')
     ->where('vales.id_vale',$vale)
     ->take(1)
     ->first();

     $name=$name->nombre_brigada;

       $detmate=DB::table('vales')
      ->select('vales.id_vale','materiales.nombre_material','unidades.num_serie')
      ->join('vale_material','vales.id_vale','=','vale_material.id_vale')
      ->join('materiales','vale_material.id_material','=','materiales.id_material') 
      ->join('unidades','vale_material.id_unidad','=','unidades.id_unidad')      
     
     ->where([['vales.id_vale','=',$vale],['vales.id_area','=',$a]])
     ->paginate(10);





  return view('personal/prestamos.detalle_vale')->with('detalle',$detalle)->with('detallemate',$detmate)->with('nombreb',$name);



  }





 public function entregar_vale($id_vale)
{

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

      $vale=$id_vale;

 DB::table('vales')
                ->where('id_vale', $vale)
                ->update(['estado_vale' => 'en curso']);


     Session::flash('message','Material entregado a la brigada ');
    return redirect()->back();


}





 public function liberar_vale($id_vale)
{

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

      $vale=$id_vale;

 DB::table('vales')
                ->where('id_vale', $vale)
                ->update(['estado_vale' => 'finalizado']);


                $fin=DB::table('vales')
                ->select('vales.id_solicitud')
                ->where('vales.id_vale',$vale)
                ->take(1)
                ->first();

                $fin=$fin->id_solicitud;

                  $finconta=DB::table('vales')
                ->select('vales.id_vale')
                ->where('vales.id_solicitud',$fin)
                ->count();

                     $final=DB::table('vales')
                ->select('vales.id_vale')
                ->where([['vales.id_solicitud',$fin],['vales.estado_vale','=','finalizado']])
                ->count();

                 $contar=DB::table('vales')
     ->select('vales.id_vale')
     ->where('vales.id_solicitud',$fin)
     ->count();

       $contar2=DB::table('vales')
     ->select('vales.id_vale')
     ->where([['vales.id_solicitud','=',$fin],['vales.estado_vale','=','retenido']])
     ->count();

      $contar3=DB::table('vales')
     ->select('vales.id_vale')
     ->where([['vales.id_solicitud','=',$fin],['vales.estado_vale','=','finalizado']])
     ->count();


     $contar4=$contar2+$contar3;

     if($contar4==$contar){

       DB::table('solicitudes')
                ->where('id_solicitud', $fin)
                ->update(['estado' => 'retenido']);

                  return redirect()->route('adeudos_material');




     }


                if($finconta==$final){

                  DB::table('solicitudes')
                ->where('id_solicitud', $fin)
                ->update(['estado' => 'finalizado']);

                      return redirect()->route('solicitudes_area_fin');


                }






     Session::flash('message','Vale liberado ');
    return redirect()->back();


}



 public function retener_vale($id_vale)
{

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

      $vale=$id_vale;

      DB::table('vales')
                ->where('id_vale', $vale)
                ->update(['estado_vale' => 'retenido','bandera' => '0']);

      $sol=DB::table('vales')
      ->select('vales.id_solicitud')
      ->where('vales.id_vale',$vale)
      ->take(1)
      ->first();

      $sol=$sol->id_solicitud;


       DB::table('solicitudes')
                ->where('id_solicitud', $sol)
                ->update(['bandera' => '0']);


    
       $todas=DB::table('vales')
      ->select('vales.id_solicitud')
      ->where('vales.id_solicitud',$sol)
      ->count();


       $todas2=DB::table('vales')
      ->select('vales.id_solicitud')
      ->where('vales.estado_vale','=','retenido')
      ->count();


      if($todas==$todas2){

         DB::table('solicitudes')
                ->where('id_solicitud', $sol)
                ->update(['estado' => 'retenido']);


                 return redirect()->route('adeudos_material');



      }








     Session::flash('mess','El vale ha sido retenido ');
    return redirect()->back();


}



     public function adeudos_material()
    {
        $usuario_actual=\Auth::user();
      if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

       $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;

   $semestre = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre=$semestre->id_semestre;

    $semestre1 = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre1=$semestre1->nombre_semestre;


  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;

  $name= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $name=$name->area;

      
  $adeudos=DB::table('solicitudes')
  ->select('solicitudes.id_solicitud','solicitudes.fecha_solicitud','solicitudes.fecha_prestamo','solicitudes.estado','grupos.grupo','grupos.hora_inicio','grupos.hora_fin','personas.nombre','personas.apellido_paterno','personas.apellido_materno','semestre.nombre_semestre')
  ->join('semestre','solicitudes.id_semestre','=','solicitudes.id_semestre')
  ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
  ->join('areas','solicitudes.id_area','=','areas.id_area')
  ->join('docentes','solicitudes.id_docente','=','docentes.id_docente')
  ->join('personas','docentes.id_persona','=','personas.id_persona')
  ->where([['solicitudes.estado','=','retenido'],['solicitudes.id_area','=',$a],['solicitudes.bandera','=','0']])
  ->orderBy('solicitudes.updated_at','DESC')
  ->paginate(8);
      
    return view('personal.adeudos.solicitudes_adeudos')->with('solicitudes',$adeudos)->with('semestre',$semestre1)->with('nombrearea',$name);
    }


     public function adeudo_solicitud($id_solicitud)
{
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

      $solicitud=$id_solicitud;

      $id=$usuario_actual->id_user;

      $id_personal = DB::table('personal')
      ->select('personal.id_personal')
      ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
      ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
      ->where('users.id_user', $id)
      ->take(1)
      ->first();
      $id_p=$id_personal->id_personal;



  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;
    

     $grupo=DB::table('solicitudes')
     ->select('grupos.grupo')
     ->join('grupos','solicitudes.id_grupo','grupos.id_grupo')
     ->where('solicitudes.id_solicitud',$solicitud)
     ->take(1)
     ->first();

     $grupo=$grupo->grupo;

     $detalles2=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','brigadas.nombre_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
     ->where([['vales.id_solicitud','=',$solicitud],['vales.estado_vale','=','retenido']])
   ->take(1)
     ->first();

     $detalles2=$detalles2->fecha_prestamo_vale;

      $detalles3=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','brigadas.nombre_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
     ->where([['vales.id_solicitud','=',$solicitud],['vales.estado_vale','=','retenido']])
   ->take(1)
     ->first();

     $detalles3=$detalles3->hora_inicio_vale;

      $detalles4=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','brigadas.nombre_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
     ->where([['vales.id_solicitud','=',$solicitud],['vales.estado_vale','=','retenido']])
   ->take(1)
     ->first();

     $detalles4=$detalles4->hora_fin_vale;


         $detalles=DB::table('vales')
      ->select('vales.id_vale','vales.fecha_prestamo_vale','vales.hora_inicio_vale','vales.hora_fin_vale','vales.estado_vale','brigadas.nombre_brigada','areas.area','brigadas.cupo_brigada','brigadas.control_brigada')
      ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
      ->join('areas','vales.id_area','=','areas.id_area')
     ->where([['vales.id_solicitud','=',$solicitud],['vales.id_area','=',$a],['vales.estado_vale','=','retenido']])
     ->paginate(10);

  return view('personal/adeudos.solicitud_adeudo_detalle')->with('detalle',$detalles)->with('grupo',$grupo)
  ->with('fecha_practica',$detalles2)
    ->with('inicio',$detalles3)
      ->with('final',$detalles4);
}




 public function detalles_vale_adeudo($id_vale)
{

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }


      $vale=$id_vale;
      $id=$usuario_actual->id_user;

      $id_personal = DB::table('personal')
      ->select('personal.id_personal')
      ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
      ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
      ->where('users.id_user', $id)
      ->take(1)
      ->first();
      $id_p=$id_personal->id_personal;

      $area= DB::table('areas')
      ->select('areas.id_area','areas.area')
      ->join('personal','personal.id_area','=','areas.id_area')
      ->where('personal.id_personal',$id_p)
      ->take(1)
      ->first();

      $a=$area->id_area;

        $detalle=DB::table('vales')
      ->select('vales.id_vale','brigadas.nombre_brigada','brigadas.cupo_brigada','brigadas.control_brigada','personas.nombre','personas.apellido_paterno','personas.apellido_materno','estudiantes.num_control','detalle_brigadas.cargo')
      ->join('brigadas','vales.id_brigada','=','brigadas.id_brigada')
      ->join('detalle_brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
      ->join('estudiantes','detalle_brigadas.num_control','=','estudiantes.num_control')
      ->join('personas','estudiantes.id_persona','=','personas.id_persona')
     ->where([['vales.id_vale','=',$vale],['vales.id_area','=',$a]])
     ->paginate(10);


     $name=DB::table('vales')
     ->select('vales.id_vale','brigadas.nombre_brigada')
     ->join('brigadas','vales.id_brigada','brigadas.id_brigada')
     ->where('vales.id_vale',$vale)
     ->take(1)
     ->first();

     $name=$name->nombre_brigada;

       $detmate=DB::table('vales')
      ->select('vales.id_vale','materiales.nombre_material','unidades.num_serie')
      ->join('vale_material','vales.id_vale','=','vale_material.id_vale')
      ->join('materiales','vale_material.id_material','=','materiales.id_material') 
      ->join('unidades','vale_material.id_unidad','=','unidades.id_unidad')      
     
     ->where([['vales.id_vale','=',$vale],['vales.id_area','=',$a]])
     ->paginate(10);





  return view('personal/adeudos.detalle_vale_adeudo')->with('detalle',$detalle)->with('detallemate',$detmate)->with('nombreb',$name);



  }



     public function solicitudes_area_fin()
    {
        $usuario_actual=\Auth::user();
      if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

       $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;

   $semestre = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre=$semestre->id_semestre;

    $semestre1 = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre1=$semestre1->nombre_semestre;


  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;

  $name= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $name=$name->area;

      
  $aprobadas=DB::table('solicitudes')
  ->select('solicitudes.id_solicitud','solicitudes.fecha_solicitud','solicitudes.fecha_prestamo','solicitudes.estado','grupos.grupo','grupos.hora_inicio','grupos.hora_fin','personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
  ->join('areas','solicitudes.id_area','=','areas.id_area')
  ->join('docentes','solicitudes.id_docente','=','docentes.id_docente')
  ->join('personas','docentes.id_persona','=','personas.id_persona')
  ->where([['solicitudes.id_semestre', '=', $semestre],['solicitudes.estado','=','finalizado'],['solicitudes.id_area','=',$a]])
  ->orderBy('solicitudes.updated_at','DESC')
  ->paginate(8);
      
    return view('personal.prestamos.solicitudes_fin')->with('solicitudes',$aprobadas)->with('semestre',$semestre1)->with('nombrearea',$name);
    }






 public function ver_practicas_grupos()
{

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
       return redirect()->back();
      }

   $id=$usuario_actual->id_user;

  $id_personal = DB::table('personal')
  ->select('personal.id_personal')
  ->join('personas', 'personas.id_persona', '=' ,'personal.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_personal->id_personal;

   $semestre = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre=$semestre->id_semestre;

    $semestre1 = DB::table('semestre')
   ->select('semestre.id_semestre','semestre.nombre_semestre')
   ->where('semestre.estatus_semestre', '=', 'actual')
   ->take(1)
   ->first();
   $semestre1=$semestre1->nombre_semestre;


  $area= DB::table('areas')
  ->select('areas.id_area','areas.area')
  ->join('personal','personal.id_area','=','areas.id_area')
  ->where('personal.id_personal',$id_p)
 ->take(1)
  ->first();

  $a=$area->id_area;

  $grupo=DB::table('grupos')
  ->select('grupos.grupo','materias.materia','grupos.hora_inicio','grupos.hora_fin','grupos.cupo','grupos.control_cupo','grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco')
  ->join('materias','materias.id_materia','=','grupos.id_materia')
  ->join('areas','areas.id_area','=','grupos.id_area')
  ->where([['grupos.id_area','=',$a],['grupos.id_semestre','=',$semestre]])
  ->paginate(5);
 
  return view('personal/practicas_grupo')->with('dato',$grupo)->with('name',$semestre1);
}


}
