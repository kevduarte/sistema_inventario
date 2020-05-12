<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Personal;
use App\Persona;
use App\User;
use App\Tipo;
use App\Material;
use App\Unidad;
use App\Semestre;
use App\Docente;
use App\Cuenta;
use App\Notificacion;

use App\Mail\CuentasCorreoDocente;
use App\Mail\RechazoDeSolicitudDeCuenta;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Storage;


use App\Http\Controllers\Controller;

use PDF;
use Dompdf\Dompdf;

class NotificacionController extends Controller
{

	  public function envio_notificacion(Request $request){

      $this->validate($request, [
    'nombre' => ['required'],
    'apellido_paterno' => ['required'],
    'email' => ['required', 'unique:users'],
    'rfc' => ['required', 'unique:personas'],
  ]);
     
  $data = $request;
  $id=$data['id_cuenta'];
 

 $datos_correo= DB::table('cuentas')
 ->select('cuentas.email', 'cuentas.id_cuenta', 'cuentas.nombre', 'cuentas.apellido_paterno', 'cuentas.apellido_materno')
  ->where('cuentas.id_cuenta','=', $id)
  ->take(1)
  ->first();
$act_dato= $datos_correo->email;
  

   $datos_cuenta= DB::table('cuentas')
   ->select('cuentas.email', 'cuentas.id_cuenta', 'cuentas.nombre', 'cuentas.apellido_paterno', 'cuentas.apellido_materno','cuentas.username','cuentas.password')
  ->where('cuentas.id_cuenta','=', $id)
        ->take(1)
        ->first();

   try {
            Mail::to($datos_correo->email)
            ->send(new CuentasCorreoDocente($datos_correo, $data,  $datos_cuenta));
          } catch (Exception $e) {
              report($e);
                 redirect()->back()->with('error', 'no se envio');
          }
    
    $semestre = DB::table('semestre')
	->select('semestre.id_semestre')
	->where('semestre.estatus_semestre', '=', 'actual')
	->take(1)
	->first();
	$semestre= $semestre->id_semestre;

	$id_rand= random_int(10000, 99999);
	$tipo_usuario= 'docente';
	$password= 'docente2020';



	$persona=new Persona;
	$persona->id_persona=$id_rand;

	$persona->nombre=$data['nombre'];
	$persona->apellido_paterno=$data['apellido_paterno'];
	$persona->apellido_materno=$data['apellido_materno'];
	$persona->curp=$data['curp'];
	
	$persona->save();


	if($persona->save()){
		$docente=new Docente;

		$docente->departamento=$data['departamento'];
		$docente->id_persona=$id_rand;
		$docente->id_semestre=$semestre;
		$docente->save();


		if($docente->save()){

			$user=new User;
			$user->id_user=$id_rand;
			$user->username=$data['email'];
			$user->email=$data['email'];
			$user->password = Hash::make($password);
			$user->tipo_usuario=$tipo_usuario;
			$user->id_persona=$id_rand;
			$user->id_semestre=$semestre;
			$user->save();
			if($user->save()){
                
                 DB::table('cuentas')
     ->where('cuentas.email', $act_dato)
     ->update(['estado' => 'aprobado']);

 $id=$id_rand;

      $id_persona = DB::table('docentes')
  ->select('docentes.id_persona','docentes.id_docente')
  ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();
   $id_p=$id_persona->id_docente;


    $notificacion = new Notificacion;
    $notificacion->email= $data['email'];
     $notificacion->id_docente= $id_p;
    $notificacion->asunto= $data['asunto'];
    $notificacion->mensaje= $data['contenido'];
    $notificacion->estatus='enviado';
    $notificacion->save();

     

				Session::flash('message','Usuario docente registrado');
				return redirect()->route('docente_activo');

			}else{
				Session::flash('message',' no encontrado');
				return redirect()->route('registro_docente');
			}
		}}
 }

    public function notifaciones(){

      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='admin'){
         return redirect()->back();
        }

        $result = DB::table('notificaciones')
      ->select('notificaciones.asunto','notificaciones.email','notificaciones.id_docente','notificaciones.estatus', 'notificaciones.mensaje', 'notificaciones.created_at','personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.email')
      
       ->join('docentes', 'docentes.id_docente', '=', 'notificaciones.id_docente')
      ->join('personas', 'personas.id_persona', '=', 'docentes.id_persona')
	  ->join('users', 'users.id_persona', '=' , 'personas.id_persona')
     ->where('notificaciones.estatus', '=', 'enviado')
      ->orderBy('notificaciones.created_at', 'desc')
        ->simplePaginate(3);

  $res = DB::table('notificaciones')
      ->select('notificaciones.asunto','notificaciones.email','notificaciones.id_docente','notificaciones.estatus', 'notificaciones.mensaje', 'notificaciones.created_at','notificaciones.nombre')
      
      
     ->where('notificaciones.estatus', '=', 'enviado y rechazado')
      ->orderBy('notificaciones.created_at', 'desc')
        ->simplePaginate(10);

       
    return view('admin.notificaciones')->with('data', $result)->with('datos',$res);

    }

    public function cuenta_rechazar($id_cuenta){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
      $cuenta= $id_cuenta;

      $datos_cuenta= DB::table('cuentas')
       ->select('cuentas.id_cuenta','cuentas.departamento','cuentas.nombre','cuentas.apellido_paterno','cuentas.apellido_materno','cuentas.curp','cuentas.email','cuentas.username','cuentas.password')
       
       ->where([['cuentas.id_cuenta', $cuenta], ['cuentas.estado', '=', 'pendiente']])
       ->take(1)
       ->first();


      return view('mails.rechazo_notificacion')
      ->with('datos', $datos_cuenta)
      ->with('cuenta', $cuenta);
      
    }

      public function envio_rechazo(Request $request){
     $data = $request;
  $id=$data['id_cuenta'];
 

 $datos_correo= DB::table('cuentas')
 ->select('cuentas.email', 'cuentas.id_cuenta', 'cuentas.nombre', 'cuentas.apellido_paterno', 'cuentas.apellido_materno')
  ->where('cuentas.id_cuenta','=', $id)
  ->take(1)
  ->first();
$act_dato= $datos_correo->email;
  

   $datos_cuenta= DB::table('cuentas')
   ->select('cuentas.email', 'cuentas.id_cuenta', 'cuentas.nombre', 'cuentas.apellido_paterno', 'cuentas.apellido_materno','cuentas.username','cuentas.password')
  ->where('cuentas.id_cuenta','=', $id)
        ->take(1)
        ->first();

        

              try {
      Mail::to($datos_correo->email)
      ->send(new RechazoDeSolicitudDeCuenta($datos_correo, $data, $datos_cuenta));

    } catch (Exception $e) {
        report($e);
           redirect()->back()->with('error', 'Hubo un error al tratar de enviar el correo!');
        //return false;
    }

    DB::table('cuentas')
        ->where([['cuentas.estado', '=', 'pendiente']])
        //->where('solicitud_talleres.matricula', $data['matricula'])
        ->update(
          ['estado' => 'rechazado', 'bandera' => '0']);

     $notificacion = new Notificacion;
    $notificacion->email= $data['email'];
    $notificacion->nombre=$data['nombre'].$data['apellido_paterno'].$data['apellido_materno'];
    $notificacion->asunto= $data['asunto'];
    $notificacion->mensaje= $data['contenido'];
    $notificacion->estatus= 'enviado y rechazado';
    $notificacion->save();

  Session::flash('mess','Cuenta no aprobada');
          return redirect()->route('notificaciones');
    }


   
}
