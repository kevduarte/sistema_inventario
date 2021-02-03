<?php

namespace App\Http\Controllers\login;
use Illuminate\Http\Request;
use App\Cuenta;
use App\Estudiante;
use App\Semestre;
use App\Persona;
use App\User;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Storage;



use App\Http\Controllers\Controller;

class CuentaController extends Controller
{
    
public function solicitar_cuenta_docente(Request $request)
{ 

	$this->validate($request, [
		'nombre' => ['required', 'string', 'max:25'],
		'apellido_paterno' => ['required', 'string', 'max:25'],
		'email' => ['required', 'unique:cuentas'],
		'curp' => ['required', 'unique:cuentas'],
		
	]);

	$data = $request;
	$estado= 'pendiente';



	$nuevo =new Cuenta;
	$nuevo->nombre=$data['nombre'];
	$nuevo->apellido_paterno=$data['apellido_paterno'];
	$nuevo->apellido_materno=$data['apellido_materno'];
	$nuevo->curp=$data['curp'];
	$nuevo->email=$data['email'];
	$nuevo->estado=$estado;
	
	$nuevo->departamento=$data['departamento'];

	$nuevo->save();

	Session::flash('mess','La solicitud de su cuenta fue enviada correctamente.');
	return redirect()->route('welcome');

}

public function registro_cuenta_estudiante(Request $request)
{ 
    $this->validate($request, [
		'nombre' => ['required', 'string', 'max:80'],
		'apellido_paterno' => ['required', 'string', 'max:80'],
		'num_control' => ['required', 'unique:estudiantes'],
        'email' => ['required', 'unique:personas'],

   
	]);

	$data = $request;

	$periodo_semestre = DB::table('semestre')
  ->select('semestre.id_semestre')
  ->where('semestre.estatus_semestre', '=', 'actual')
  ->take(1)
  ->first();
  $periodo_semestre= $periodo_semestre->id_semestre;

  $email=$data['email'];
  $sem=$data['semestre'];

  if(empty($email)){

$email='s/c';

  }
	

if($data['semestre'] <18){

  $id_est= $data['num_control'];
  $tipo_usuario= 'estudiante';
  $nivel=2;

  $persona=new Persona;
  $persona->id_persona=$id_est;
  $persona->nombre=$data['nombre'];
  $persona->apellido_paterno=$data['apellido_paterno'];
  $persona->apellido_materno=$data['apellido_materno'];
  $persona->email=$email;
  $persona->rfc='no disponible';
  $persona->telefono='no disponible';
  $persona->nivel=$nivel;
  $persona->id_semestre=$periodo_semestre;
  $persona->save();
  
  if($persona->save()){
    $estudiante=new Estudiante;

    $estudiante->num_control=$id_est;
     $estudiante->semestre_cursando=$data['semestre'];
     $estudiante->carrera=$data['carrera'];
     $estudiante->id_persona=$id_est;

  
    $estudiante->id_semestre=$periodo_semestre;
    $estudiante->save();


    if($estudiante->save()){

      $user=new User;
      $user->id_user=$id_est;
      $user->username=$id_est;
      $user->password = Hash::make($data['num_control']);
      $user->tipo_usuario=$tipo_usuario;
      $user->id_persona=$id_est;
      $user->id_semestre=$periodo_semestre;
      $user->save();
      if($user->save()){

        Session::flash('message','Estudiante registrado con éxito');
       return redirect()->route('welcome');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->back();
      }
    }}

	   

	 }
              else{
                Session::flash('mess','El semestre debe ser menor a 18');
                 return redirect()->back();
              }






}


}