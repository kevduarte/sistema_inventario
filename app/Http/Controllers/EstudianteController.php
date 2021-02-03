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

use App\Area;
use App\Personal;
use App\Persona;
use App\User;
use App\Tipo;
use App\Material;
use App\Unidad;
use App\Semestre;
use App\Cuenta;
use App\Estudiante;
use App\Detalle_grupo;



class EstudianteController extends Controller
{
 

 //mostrar la pag. principal del personal
	public function home(){
    $usuario_actual=\Auth::user();
    if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect()->back();
   }

   $usuario_actual=auth()->user();
   $id=$usuario_actual->id_user;
   if($usuario_actual->tipo_usuario == 'estudiante'){
    if($usuario_actual->bandera == '1'){

     $id=$usuario_actual->id_user;

     $checar = DB::table('users')
     ->select('users.check_password')
     ->where('users.id_user', $id)
     ->take(1)
     ->first();
     $checar=$checar->check_password;

     if(empty($checar)){
       Session::flash('message','Para hacer uso del sistema es nescesario que actualize su contraseña');
       return redirect()->route('nueva_contraseña');

     }else{

       $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }

        $id=$usuario_actual->id_user;

     
        $periodo_semestre = DB::table('semestre')
        ->select('semestre.id_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();

        if(empty($periodo_semestre->id_semestre)){

         Session::flash('mess','No hay registros!');
          return redirect()->route('estudiante');
        }else {

          $sem = DB::table('semestre')
        ->select('semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first(); 

        $sem=$sem->nombre_semestre;



        $result = DB::table('detalle_grupos')
        ->select('detalle_grupos.estado','grupos.id_grupo', 'grupos.grupo', 'materias.materia',
        'grupos.hora_inicio', 'grupos.hora_fin', 'docentes.id_docente',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('grupos', 'grupos.id_grupo', '=', 'detalle_grupos.nom_grupo')
        ->join('docentes', 'grupos.id_docente', '=', 'docentes.id_docente')
        ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
            ->join('materias', 'grupos.id_materia', '=', 'materias.id_materia')

        ->where([['grupos.bandera','=', '1'], ['detalle_grupos.num_control','=', $id], ['detalle_grupos.estado', '=', 'cursando'],  ['detalle_grupos.semestre', $periodo_semestre->id_semestre]])
        ->simplePaginate(10);

      return view('estudiantes.home_estudiantes')->with('dato', $result)->with('sem', $sem);
    }

    }
  }
}

}

    public function nueva_contraseña()
     {
       return view('estudiantes.nueva_contraseña');
     }

     public function cambio(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
             
             Session::flash('message','Su contraseña actual no coincide con la contraseña que proporcionó. Inténtalo de nuevo.');
              return redirect()->back();
          }

          if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
              
            Session::flash('message','La nueva contraseña no puede ser la misma que su contraseña actual. Por favor, elija una contraseña diferente.');
              return redirect()->back();
          }

          $validatedData = $request->validate([
              'current-password' => 'required',
              'new-password' => 'required|string|min:5|confirmed',
          ]);

     

          //Change Password
          $user = Auth::user();
          $user->password = bcrypt($request->get('new-password'));
          $user->save();
           $id=$user->id_user;
           $check='1';

          if($user->save()){
            DB::table('users')
               ->where('users.id_user',$id)
               ->update(['check_password' => $check]);
                Session::flash('message','Contraseña Actualizada Correctamente, Bienvenido');
            return redirect()->route('estudiante');
          }


   
 }

	 public function grupos_disponibles(){

      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
        return redirect()->back();
        }
	
       $id=$usuario_actual->id_user;
		
        $id_persona = DB::table('personas')
        ->select('personas.id_persona')
        ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->where('estudiantes.num_control', $id)
        ->take(1)
        ->first();

        $periodo_semestre = DB::table('semestre')
        ->select('semestre.id_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();
        $periodo_semestre= $periodo_semestre->id_semestre;

           $sem = DB::table('semestre')
        ->select('semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first(); 

        $sem=$sem->nombre_semestre;

   
    $result = DB::table('grupos')
    ->select('grupos.id_grupo',  'grupos.grupo', 'grupos.control_cupo', 'materias.materia', 'grupos.hora_inicio','grupos.hora_fin', 'docentes.id_docente','personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
    ->join('docentes', 'grupos.id_docente', '=', 'docentes.id_docente')
    ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
    ->join('materias', 'grupos.id_materia', '=', 'materias.id_materia')
    ->where([['grupos.control_cupo', '>', '0'], ['grupos.bandera', '=', '1'],['grupos.id_semestre','=',$periodo_semestre]])
    ->orderBy('personas.apellido_paterno', 'asc')
    ->paginate(10);

return view("estudiantes.catalogo_grupos")->with('dato', $result)->with('sem',$sem);
  }

 public function inscripcion($id_grupo){

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='estudiante'){
       return redirect()->back();
      }
    $data = $id_grupo;
    $mater = DB::table('grupos')
    ->select('grupos.id_grupo',  'grupos.grupo', 'materias.materia','grupos.control_cupo')
 ->join('materias','grupos.id_materia','=','materias.id_materia')
    ->where('grupos.id_grupo', '=', $data)
    ->take(1)
    ->first();
    return view("estudiantes.inscripcion_nueva")->with('clave', $mater); 


     
  }

  public function nueva_inscripcion(Request $request){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='estudiante'){
       return redirect()->back();
      }

      $data=$request;
      $idgrupo=$data['id_grupo'];
      $clave=$data['clave'];

      $usuario_actual=auth()->user();
      $id=$usuario_actual->id_user;


  $id_persona = DB::table('estudiantes')
  ->select('estudiantes.id_persona','estudiantes.num_control')
  ->join('personas', 'personas.id_persona', '=' ,'estudiantes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
   $id_p=$id_persona->num_control;

      $aa = DB::table('detalle_grupos')
      ->select('detalle_grupos.nom_grupo')
      ->join('estudiantes', 'estudiantes.num_control', '=', 'detalle_grupos.num_control')
        ->where([['estudiantes.num_control',$id], ['detalle_grupos.nom_grupo', $idgrupo]])
      ->take(1)
      ->first();

      $cc = DB::table('grupos')
      ->select('grupos.clave')
      ->where('grupos.id_grupo',$idgrupo)
      ->take(1)
      ->first();

      $cc=$cc->clave;

      if($clave!=$cc){

          Session::flash('mess','La contraseña del grupo no es correcta');

         return redirect()->back();
      }else{


      

if(empty($aa)){
  $periodo_semestre = DB::table('semestre')
  ->select('semestre.id_semestre')
  ->where('semestre.estatus_semestre', '=', 'actual')
  ->take(1)
  ->first();
 $periodo_semestre= $periodo_semestre->id_semestre;

 $result = DB::table('grupos')
 ->select('grupos.control_cupo')
->where('grupos.id_grupo',$idgrupo)
->take(1)
->first();

  $inscripcion = new Detalle_grupo;
  $inscripcion->num_control= $id_p;
  $inscripcion->nom_grupo= $idgrupo;
  $inscripcion->estado= 'cursando';
  $inscripcion->semestre= $periodo_semestre;
  $inscripcion->save();

       $reducir=($result->control_cupo)-1;
          DB::table('grupos')
              ->where('grupos.id_grupo',$idgrupo )
              ->update(['control_cupo' => $reducir]);

               Session::flash('message','Inscripción realizada correctamente');
      return redirect()->route('mis_cursos');
    }
    else {
       Session::flash('mess','Ya estás inscrito en este grupo!');
        return redirect()->route('grupos_disponibles');
    }
  }
     
     
    
    

 }

 public function cursos(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }

        $id=$usuario_actual->id_user;

     
        $periodo_semestre = DB::table('semestre')
        ->select('semestre.id_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();

        if(empty($periodo_semestre->id_semestre)){

         Session::flash('mess','No hay registros!');
          return redirect()->route('estudiante');
        }else {

          $sem = DB::table('semestre')
        ->select('semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first(); 

        $sem=$sem->nombre_semestre;



        $result = DB::table('detalle_grupos')
        ->select('detalle_grupos.estado','grupos.id_grupo', 'grupos.grupo', 'materias.materia',
        'grupos.hora_inicio', 'grupos.hora_fin', 'docentes.id_docente',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno','grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco','areas.area')

        ->join('grupos', 'grupos.id_grupo', '=', 'detalle_grupos.nom_grupo')
        ->join('areas','areas.id_area','=','grupos.id_area')
        ->join('docentes', 'grupos.id_docente', '=', 'docentes.id_docente')
        ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
            ->join('materias', 'grupos.id_materia', '=', 'materias.id_materia')

        ->where([['grupos.bandera','=', '1'], ['detalle_grupos.num_control','=', $id], ['detalle_grupos.estado', '=', 'cursando'],  ['detalle_grupos.semestre', $periodo_semestre->id_semestre]])
        ->simplePaginate(10);
      return  view ('estudiantes.misgrupos')->with('dato', $result)->with('sem', $sem);
    }
  }


  public function mis_brigadas(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }

        $id=$usuario_actual->id_user;

     
        $periodo_semestre = DB::table('semestre')
        ->select('semestre.id_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();

        if(empty($periodo_semestre->id_semestre)){

         Session::flash('mess','No hay registros!');
          return redirect()->route('estudiante');
        }else {

          $sem = DB::table('semestre')
        ->select('semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first(); 

        $sem=$sem->nombre_semestre;



        $result = DB::table('detalle_brigadas')
        ->select('detalle_brigadas.cargo','brigadas.id_brigada','grupos.grupo','materias.materia','brigadas.nombre_brigada',
        'grupos.hora_inicio', 'grupos.hora_fin',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno','grupos.dia_uno','grupos.dia_dos','grupos.dia_tres','grupos.dia_cuatro','grupos.dia_cinco','areas.area')

        ->join('brigadas', 'brigadas.id_brigada', '=', 'detalle_brigadas.id_brigada')
        ->join('grupos','grupos.id_grupo','=','brigadas.id_grupo')
        ->join('areas','areas.id_area','=','grupos.id_area')
        ->join('docentes', 'grupos.id_docente', '=', 'docentes.id_docente')
        ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
        ->join('materias', 'grupos.id_materia', '=', 'materias.id_materia')

        ->where([['grupos.bandera','=', '1'], ['detalle_brigadas.num_control','=', $id], ['detalle_brigadas.estado', '=', 'brigada'],  ['detalle_brigadas.id_semestre', $periodo_semestre->id_semestre]])
        ->paginate(10);
      return  view ('estudiantes.misbrigadas')->with('dato', $result)->with('sem', $sem);
    }
  }


   public function ver_miembros($id_brigada){

   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='estudiante'){
       return redirect()->back();
      }
    $data = $id_brigada;
    $num_control=$usuario_actual->id_user;

    $detalle=DB::table('brigadas')
      ->select('brigadas.nombre_brigada','brigadas.cupo_brigada','brigadas.control_brigada','personas.nombre','personas.apellido_paterno','personas.apellido_materno','estudiantes.num_control','detalle_brigadas.cargo')
      ->join('detalle_brigadas','brigadas.id_brigada','=','detalle_brigadas.id_brigada')
      ->join('estudiantes','detalle_brigadas.num_control','=','estudiantes.num_control')
      ->join('personas','estudiantes.id_persona','=','personas.id_persona')
     ->where([['brigadas.id_brigada','=',$data],['detalle_brigadas.num_control','!=',$num_control]])
     ->orderBy('personas.apellido_paterno','asc')
     ->paginate(10);

    return view("estudiantes.miembros_brigada")->with('detalle', $detalle); 


     
  }


public function practicas_estudiante(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }

        $id=$usuario_actual->id_user;

     
        $sem= DB::table('semestre')
        ->select('semestre.id_semestre','semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();

        $sem=$sem->id_semestre;

        $sem2= DB::table('semestre')
        ->select('semestre.id_semestre','semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();

        
        $sem2=$sem2->nombre_semestre;


        $vales=DB::table('vales')
        ->select('vales.id_vale','solicitudes.id_solicitud','grupos.grupo','solicitudes.fecha_prestamo','solicitudes.hora_inicio_sol','solicitudes.hora_fin_sol','vales.estado_vale','areas.area')
        
        ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
        ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
        ->join('areas','vales.id_area','=','areas.id_area')
        ->join('vale_estudiante','vales.id_vale','=','vale_estudiante.id_vale')
        ->join('estudiantes','vale_estudiante.num_control','=','estudiantes.num_control')
        ->where([['estudiantes.num_control','=',$id],['solicitudes.estado','=','aprobada'],['vales.estado_vale','=','pendiente'],['solicitudes.id_semestre','=',$sem]])
        ->paginate(5);

        

      
      return  view ('estudiantes.mis_practicas')->with('dato', $vales)->with('sem2', $sem2);
    }




public function practicas_estudiante_curso(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }

        $id=$usuario_actual->id_user;

     
        $sem= DB::table('semestre')
        ->select('semestre.id_semestre','semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();

        $sem=$sem->id_semestre;

        $sem2= DB::table('semestre')
        ->select('semestre.id_semestre','semestre.nombre_semestre')
        ->where('semestre.estatus_semestre', '=', 'actual')
        ->take(1)
        ->first();

        
        $sem2=$sem2->nombre_semestre;


        $vales=DB::table('vales')
        ->select('vales.id_vale','solicitudes.id_solicitud','grupos.grupo','solicitudes.fecha_prestamo','solicitudes.hora_inicio_sol','solicitudes.hora_fin_sol','vales.estado_vale','areas.area')
        
        ->join('solicitudes','vales.id_solicitud','=','solicitudes.id_solicitud')
        ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
        ->join('areas','vales.id_area','=','areas.id_area')
        ->join('vale_estudiante','vales.id_vale','=','vale_estudiante.id_vale')
        ->join('estudiantes','vale_estudiante.num_control','=','estudiantes.num_control')
        ->where([['estudiantes.num_control','=',$id],['solicitudes.estado','=','aprobada'],['vales.estado_vale','=','en curso'],['solicitudes.id_semestre','=',$sem]])
        ->paginate(5);

        

      
      return  view ('estudiantes.mis_practicas_curso')->with('dato', $vales)->with('sem2', $sem2);
    }
  









  }






