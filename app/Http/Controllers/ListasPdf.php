<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Area;
use App\Personal;
use App\Persona;

use App\Tipo;
use App\Texto;
use App\Material;
use App\Unidad;
use App\Semestre;
use App\Cuenta;
use App\Brigada;
use App\Detalle_grupo;

use App\Detalle_brigada;

use App\Grupo;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response as FacadeResponse;




class ListasPdf extends Controller
{
    protected function generar_vale_adeudo($id_vales){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='area'){
      return redirect()->back();
    }

 $id=$usuario_actual->id_user;

 $id_doce = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente','personas.nombre')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_p=$id_doce->nombre;

  $id_doce = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente','personas.apellido_paterno')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_pat=$id_doce->apellido_paterno;

  $id_doce = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente','personas.apellido_materno')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_mat=$id_doce->apellido_materno;

$nombre_doc=$id_p." ".$id_pat." ".$id_mat;




      $id_d=$id_docente;
      $id_g= $id_grupo;
     	  
	     $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre','semestre.nombre_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('grupos')
      ->select('estudiantes.num_control','grupos.grupo', 'personas.nombre',
               'personas.apellido_paterno', 'personas.apellido_materno','detalle_grupos.estado')

      ->join('detalle_grupos', 'detalle_grupos.nom_grupo', '=', 'grupos.id_grupo')
      ->join('estudiantes', 'estudiantes.num_control', '=', 'detalle_grupos.num_control')
    
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')

      ->where([['grupos.bandera', '=' , '1'], ['grupos.id_docente', $id_d], 
	  ['detalle_grupos.nom_grupo', $id_g],
	  ['detalle_grupos.semestre', $periodo_semestre->id_semestre]])
      ->orderBy('personas.apellido_paterno', 'asc')
      ->get();

      $datos_extra = DB::table('grupos')
      ->select('grupos.grupo', 'grupos.hora_inicio',
                'grupos.hora_fin','materias.materia', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('docentes', 'docentes.id_docente', '=', 'grupos.id_docente')
      ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
      ->join('materias', 'materias.id_materia', '=', 'grupos.id_materia')
      ->where([['grupos.bandera', '=' , '1'], ['grupos.id_docente', $id_d], ['grupos.id_grupo', $id_g], ['grupos.id_semestre', $periodo_semestre->id_semestre]])
      ->take(1)
      ->first();

      $tex=DB::table('textos')
    ->select('textos.frase_cabecera','textos.lema_uno','textos.lema_dos','textos.telefono','textos.pagina')
    ->where('textos.id_texto','=','1')
    ->take(1)
    ->first();

      $frase1=$tex->frase_cabecera;
     $frase2=$tex->lema_uno;
     $frase3=$tex->lema_dos;
     $frase4=$tex->telefono;
     $frase5=$tex->pagina;



      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('docente.listadeasistencia', ['dato' =>  $result, 
   'datos_extra' => $datos_extra , 'semestre' => $periodo_semestre,'nom' => $nombre_doc,'cabecera' => $frase1,'ate1' => $frase2,'ate2' => $frase3,'telef' => $frase4,'pagina' => $frase5])

  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('lista_asistencia.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }


   protected function baja_reporte($codigo_unidad,$id_material){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
      return redirect()->back();
    }
  $id=$usuario_actual->id_user;

  $id_personal = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_personal=$id_personal->nombre;
 
  

  $ap = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$ap=$ap->apellido_paterno;


$am = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$am=$am->apellido_materno;

$nombre=$id_personal." ".$ap." ".$am;



      $id=$codigo_unidad;
      $id_m= $id_material;
        
       $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre','semestre.nombre_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();

      $periodo_semestre=$periodo_semestre->nombre_semestre;

         //dd($periodo_semestre);

      $result = DB::table('unidades')
      ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.observaciones','unidades.estado','materiales.nombre_material', 'materiales.id_material',
               'areas.area', 'tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')

      ->where([['unidades.bandera', '=' , '0'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
       ->orderBy('materiales.nombre_material', 'asc')
      ->get();

      $oficio = DB::table('unidades')
      ->select('unidades.codigo_unidad')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->where([['unidades.bandera', '=' , '0'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
->take(1)
->first();

$oficio=$oficio->codigo_unidad;
$num_oficio='LAB/'.$oficio;




      $datos = DB::table('unidades')
      ->select('unidades.observaciones', 'unidades.estado','unidades.num_serie','materiales.id_material','materiales.nombre_material','materiales.id_semestre','areas.area','tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
//      ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
       ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')
      ->where([['unidades.bandera', '=' , '0'], ['unidades.id_material', $id_m], ['unidades.codigo_unidad', $id]])
      ->take(1)
      ->first();

      $tex=DB::table('textos')
    ->select('textos.frase_cabecera','textos.lema_uno','textos.lema_dos','textos.telefono','textos.pagina')
    ->where('textos.id_texto','=','1')
    ->take(1)
    ->first();

      $frase1=$tex->frase_cabecera;
     $frase2=$tex->lema_uno;
     $frase3=$tex->lema_dos;
     $frase4=$tex->telefono;
     $frase5=$tex->pagina;




      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('dpto.reportebaja', ['dato' =>  $result, 
   'datos' => $datos , 'semestre' => $periodo_semestre,'ofi' => $num_oficio,'nom' => $nombre,'cabecera' => $frase1,'ate1' => $frase2,'ate2' => $frase3,'telef' => $frase4,'pagina' => $frase5])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('baja_reporte.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }

  protected function baja_reporte_definitiva($codigo_unidad,$id_material){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
      return redirect()->back();
    }
       $id=$usuario_actual->id_user;

  $id_personal = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_personal=$id_personal->nombre;
 
  

  $ap = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$ap=$ap->apellido_paterno;


$am = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$am=$am->apellido_materno;

$nombre=$id_personal." ".$ap." ".$am;



      $id=$codigo_unidad;
      $id_m= $id_material;
        
       $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('unidades')
      ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.observaciones','unidades.estado','materiales.nombre_material', 'materiales.id_material',
               'areas.area', 'tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')

      ->where([['unidades.bandera', '=' , '1'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
       ->orderBy('materiales.nombre_material', 'asc')
      ->get();

      $oficio = DB::table('unidades')
      ->select('unidades.codigo_unidad')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->where([['unidades.bandera', '=' , '1'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
->take(1)
->first();

$oficio=$oficio->codigo_unidad;
$num_oficio='LAB/'.$oficio;




      $datos = DB::table('unidades')
      ->select('unidades.observaciones', 'unidades.estado','materiales.id_material','unidades.num_serie','materiales.nombre_material','materiales.id_semestre','areas.area','tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
//      ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
       ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')
      ->where([['unidades.bandera', '=' , '1'], ['unidades.id_material', $id_m], ['unidades.codigo_unidad', $id]/*, ['materiales.id_semestre', $periodo_semestre->id_semestre]*/])
      ->take(1)
      ->first();


      $tex=DB::table('textos')
    ->select('textos.frase_cabecera','textos.lema_uno','textos.lema_dos','textos.telefono','textos.pagina')
    ->where('textos.id_texto','=','1')
    ->take(1)
    ->first();

      $frase1=$tex->frase_cabecera;
     $frase2=$tex->lema_uno;
     $frase3=$tex->lema_dos;
     $frase4=$tex->telefono;
     $frase5=$tex->pagina;


      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('dpto.reportebajadefinitiva', ['dato' =>  $result, 
   'datos' => $datos , 'semestre' => $periodo_semestre,'ofi' => $num_oficio,'nom' => $nombre,'cabecera' => $frase1,'ate1' => $frase2,'ate2' => $frase3,'telef' => $frase4,'pagina' => $frase5])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('baja_definitiva.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }





   protected function baja_reporte_jefe($codigo_unidad,$id_material){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
      return redirect()->back();
    }
  $id=$usuario_actual->id_user;

  $id_personal = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_personal=$id_personal->nombre;
 
  

  $ap = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$ap=$ap->apellido_paterno;


$am = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$am=$am->apellido_materno;

$nombre=$id_personal." ".$ap." ".$am;



      $id=$codigo_unidad;
      $id_m= $id_material;
        
       $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre','semestre.nombre_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();

      $periodo_semestre=$periodo_semestre->nombre_semestre;

         //dd($periodo_semestre);

      $result = DB::table('unidades')
      ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.observaciones','unidades.estado','materiales.nombre_material', 'materiales.id_material',
               'areas.area', 'tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')

      ->where([['unidades.bandera', '=' , '0'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
       ->orderBy('materiales.nombre_material', 'asc')
      ->get();

      $oficio = DB::table('unidades')
      ->select('unidades.codigo_unidad')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->where([['unidades.bandera', '=' , '0'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
->take(1)
->first();

$oficio=$oficio->codigo_unidad;
$num_oficio='LAB/'.$oficio;




      $datos = DB::table('unidades')
      ->select('unidades.observaciones', 'unidades.estado','materiales.id_material','unidades.num_serie','materiales.nombre_material','materiales.id_semestre','areas.area','tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
//      ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
       ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')
      ->where([['unidades.bandera', '=' , '0'], ['unidades.id_material', $id_m], ['unidades.codigo_unidad', $id]])
      ->take(1)
      ->first();

      $tex=DB::table('textos')
    ->select('textos.frase_cabecera','textos.lema_uno','textos.lema_dos','textos.telefono','textos.pagina')
    ->where('textos.id_texto','=','1')
    ->take(1)
    ->first();

      $frase1=$tex->frase_cabecera;
     $frase2=$tex->lema_uno;
     $frase3=$tex->lema_dos;
     $frase4=$tex->telefono;
     $frase5=$tex->pagina;




      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('jefe.reportebaja', ['dato' =>  $result, 
   'datos' => $datos , 'semestre' => $periodo_semestre,'ofi' => $num_oficio,'nom' => $nombre,'cabecera' => $frase1,'ate1' => $frase2,'ate2' => $frase3,'telef' => $frase4,'pagina' => $frase5])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('baja_reporte.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }


  protected function baja_reporte_definitiva_jefe($codigo_unidad,$id_material){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
      return redirect()->back();
    }
       $id=$usuario_actual->id_user;

  $id_personal = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $id_personal=$id_personal->nombre;
 
  

  $ap = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$ap=$ap->apellido_paterno;


$am = DB::table('personas')
  ->select('personas.nombre','personas.apellido_paterno','personas.apellido_materno')
  
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
$am=$am->apellido_materno;

$nombre=$id_personal." ".$ap." ".$am;



      $id=$codigo_unidad;
      $id_m= $id_material;
        
       $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.inicio_semestre', 'semestre.final_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('unidades')
      ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.observaciones','unidades.estado','materiales.nombre_material', 'materiales.id_material',
               'areas.area', 'tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')

      ->where([['unidades.bandera', '=' , '1'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
       ->orderBy('materiales.nombre_material', 'asc')
      ->get();

      $oficio = DB::table('unidades')
      ->select('unidades.codigo_unidad')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
      ->where([['unidades.bandera', '=' , '1'], ['unidades.id_material', $id_m], 
    ['unidades.codigo_unidad', $id]])
->take(1)
->first();

$oficio=$oficio->codigo_unidad;
$num_oficio='LAB/'.$oficio;




      $datos = DB::table('unidades')
      ->select('unidades.observaciones', 'unidades.estado','unidades.num_serie','materiales.id_material','materiales.nombre_material','materiales.id_semestre','areas.area','tipos.tipo')
      ->join('materiales', 'materiales.id_material', '=', 'unidades.id_material')
//      ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
       ->join('areas', 'areas.id_area', '=', 'materiales.id_area')
      ->join('tipos', 'tipos.id_tipo', '=', 'materiales.id_tipo')
      ->where([['unidades.bandera', '=' , '1'], ['unidades.id_material', $id_m], ['unidades.codigo_unidad', $id]/*, ['materiales.id_semestre', $periodo_semestre->id_semestre]*/])
      ->take(1)
      ->first();


      $tex=DB::table('textos')
    ->select('textos.frase_cabecera','textos.lema_uno','textos.lema_dos','textos.telefono','textos.pagina')
    ->where('textos.id_texto','=','1')
    ->take(1)
    ->first();

      $frase1=$tex->frase_cabecera;
     $frase2=$tex->lema_uno;
     $frase3=$tex->lema_dos;
     $frase4=$tex->telefono;
     $frase5=$tex->pagina;


      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('jefe.reportebajadefinitiva', ['dato' =>  $result, 
   'datos' => $datos , 'semestre' => $periodo_semestre,'ofi' => $num_oficio,'nom' => $nombre,'cabecera' => $frase1,'ate1' => $frase2,'ate2' => $frase3,'telef' => $frase4,'pagina' => $frase5])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('baja_definitiva.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }





}
