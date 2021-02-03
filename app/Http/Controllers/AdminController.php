<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Area;
use App\Personal;
use App\Persona;
use App\User;
use App\Grupo;
use App\Tipo;
use App\Materia;

use App\Material;
use App\Unidad;
use App\Semestre;
use App\Docente;
use App\Cuenta;
use App\Departamento;
use App\Tipo_user;
use App\Texto;
use App\Mail\CuentasCorreoDocente;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Storage;
use DataTables;
use App\Http\Controllers\Controller;
use PDF;
use Dompdf\Dompdf;

class AdminController extends Controller
{

//mostrar la pag. principal del admin
  public function home(Request $request){
   $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='admin'){
     return redirect()->back();
   }
       

   $totalm=DB::table('materiales')
   ->count();

   $totalp=DB::table('personal')
   ->count();

   $totald=DB::table('docentes')
   ->count();

   $totale=DB::table('estudiantes')
   ->count();

return view('admin.home_admin')
->with('mat',$totalm)
->with('per',$totalp)
->with('doc',$totald)
->with('est',$totale);
	}



    //actualizar materiales con unidades
	public function agregar_unidad($id_material){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

		$data = $id_material;
		$mater = DB::table('materiales')
		->select('materiales.nombre_material','materiales.id_material')
		->where('materiales.id_material', '=', $data)
		->take(1)
		->first();
   return view("admin.registro_unidades")->with('material', $mater); //no  te carga porque no le esas diciendo que cargar
}







/*
		public function eliminar_unidad($codigo_unidad,$id_material)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='admin'){
     return redirect()->back();
    }
       $id_extra= $codigo_unidad;
       $id_m=$id_material;

       $nomat= DB::table('materiales')
       ->select('materiales.nombre','mat')


	  DB::table('unidades')
         ->where('codigo_unidad', $id_extra)
          ->take(1)
         ->delete();
		 Session::flash('mess','¡Unidad fuera de inventario!');
            
 return redirect()->back();
}


*/




/*
public function material_activo(){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
	 $est = DB::table('materiales')
      ->select('materiales.id_material', 'materiales.nombre_material', 'materiales.num_serie', 'materiales.marca','materiales.updated_at', 'areas.area', 'tipos.tipo')
        ->join('areas', 'materiales.id_area', '=', 'areas.id_area')
        ->join('tipos', 'materiales.id_tipo', '=', 'tipos.id_tipo')
        ->where('materiales.bandera', '=', '1')

         ->orderBy('materiales.updated_at', 'DESC')
        ->simplePaginate(5);


	return view('admin.material_activo')->with('activo', $est);
}
*/



      //registro de tipos de materiales.
public function registro_tipo(){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

	$tipo = DB::table('tipos')
	->select('tipos.id_tipo','tipos.tipo')

	->Paginate(8);

	return view('admin.registro_tipos')->with('tipos',$tipo);
}
public function registrar_tipos(Request $request)
{ 
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

	$this->validate($request, 
		['tipo' => ['required', 'string', 'max:80', 'unique:tipos']]);
	$data = $request;
	$id_rand= random_int(100, 999);


	$nuevo = new Tipo();
	$nuevo->id_tipo=$id_rand;
	$nuevo->tipo = $data['tipo'];
	$nuevo->save();

	Session::flash('message','Tipo de material agregado');
	return redirect()->route('registro_tipo');
}


//registro de areas.
public function registro_materias(){
  $usuario_actual=\Auth::user();
  if($usuario_actual->tipo_usuario!='admin'){
   return redirect()->back();
 }

 $materias = DB::table('materias')
 ->select('materias.id_materia','materias.materia','materias.bandera')
 ->where('materias.bandera', '=', '1')
 ->orderBy('materias.updated_at','desc')
 ->paginate(5);
 return view('admin.registro_materias')->with('materias',$materias);
}


public function registrar_materias(Request $request){ 
 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
  $this->validate($request, 
    ['materia' => ['required', 'string', 'max:80', 'unique:materias']]);


  $data = $request;


  $nueva_area = new Materia();
  
  $nueva_area->materia = $data['materia'];
  $nueva_area->save();

  Session::flash('message','¡Nueva materia registrada con éxito!');
  return redirect()->route('registro_materias');
}


protected function desactivar_materia($id_materia){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
    $desactivado=$id_materia;
    DB::table('materias')
    ->where('materias.id_materia', $desactivado)
    ->update(
      ['bandera' => '0']);
    Session::flash('mess','¡Materia desactivada!');
    return redirect()->back();
  }

  protected function activar_materia($id_materia){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
    $activado=$id_materia;
    DB::table('materias')
    ->where('materias.id_materia', $activado)
    ->update(
      ['bandera' => '1']);
    Session::flash('message','!Materia disponible disponible!');
    return redirect()->back();
  }


//registro de areas.
public function registro_area(){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
	$area = DB::table('areas')
	->select('areas.id_area','areas.area','areas.bandera')
  ->orderBy('areas.updated_at','desc')
	->paginate(5);
	return view('admin.registro_areas')->with('areas',$area);
}

public function registrar_areas(Request $request){ 
 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
	$this->validate($request, 
		['area' => ['required', 'string', 'max:80', 'unique:areas']]);


	$data = $request;
	$id_rand= random_int(10, 99);


	$nueva_area = new Area();
	$nueva_area->id_area=$id_rand;
	$nueva_area->area = $data['area'];
	$nueva_area->save();

	Session::flash('message','¡Nueva área registrada con éxito!');
	return redirect()->route('registro_area');
}

protected function desactivar_area($id_area){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
		$desactivado=$id_area;
		DB::table('areas')
		->where('areas.id_area', $desactivado)
		->update(
			['bandera' => '0']);
		Session::flash('mess','¡Área no disponible!');
		return redirect()->back();
	}

	protected function activar_area($id_area){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
		$activado=$id_area;
		DB::table('areas')
		->where('areas.id_area', $activado)
		->update(
			['bandera' => '1']);
		Session::flash('message','¡Área disponible!');
		return redirect()->back();
	}



//registrar persona con areas
public function registro_personal(){
 $usuario_actual=\Auth::user();
 if($usuario_actual->tipo_usuario!='admin'){
   return redirect()->back();
 }
	return view('admin.registro_personal');
}



public function registrar_personal(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

	$this->validate($request, [
		'nombre' => ['required', 'string', 'max:100'],
		'apellido_paterno' => ['required', 'string', 'max:100'],
    'apellido_materno' => ['required', 'string', 'max:100'],
	  'rfc' => ['required', 'unique:personas'],
	]);

  $data=$request;
  $telefono=$data['telefono'];

  if(empty($telefono)){

    $telefono='s/n';

  }

  $email=$data['email'];

  if(empty($email)){

    $email='s/c';

  }

	$semestre = DB::table('semestre')
	->select('semestre.id_semestre')
	->where('semestre.estatus_semestre', '=', 'actual')
	->take(1)
	->first();
	$semestre= $semestre->id_semestre;

	$id_rand= random_int(10000, 99999);
  $nivel=1;
  
  $persona=new Persona;
	$persona->id_persona=$id_rand;
	$persona->nombre=$data['nombre'];
	$persona->apellido_paterno=$data['apellido_paterno'];
	$persona->apellido_materno=$data['apellido_materno'];
	$persona->rfc=$data['rfc'];
	$persona->telefono=$telefono;
  $persona->email=$email;
  $persona->id_semestre=$semestre;
  $persona->nivel=$nivel;
	$persona->save();

    Session::flash('message','¡Personal del dpto. registrado con éxito!');
    return redirect()->route('personal_registrado');

	}

  //personal
public function personal_registrado(){
 $usuario_actual=\Auth::user();
 if($usuario_actual->tipo_usuario!='admin'){
   return redirect()->back();
 }
 $personal=DB::table('personas')
 ->select('personas.id_persona','personas.nombre','personas.apellido_paterno','personas.apellido_materno','personas.rfc','personas.email','personas.telefono')
 ->where([['personas.bandera','=','1'],['personas.nivel','=','1']])
 ->paginate(10);
  return view('admin.personal_registrado')->with('personal',$personal);
}

protected function actualizar_personas($id_persona){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
    $datos=$id_persona;

    $per=DB::table('personas')
    ->select('personas.id_persona','personas.nombre','personas.apellido_paterno','personas.apellido_materno','personas.rfc','personas.telefono','personas.email')
    ->where('personas.id_persona',$datos)
    ->take(1)
    ->first();
    
    return view('admin.actualizar_datos')->with('datos',$per);
  }

  public function actualizar_personas_datos(Request $request){
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

  $data=$request;

  $id_p=$data['id_persona'];

  $dato=DB::table('personas')
  ->select('personas.telefono','personas.email')
  ->where('personas.id_persona',$id_p)
  ->take(1)
  ->first();

  $uno=$dato->telefono;
  $dos=$dato->email;

  $tel=$data['telefono'];
  $email=$data['email'];

  if($uno==$tel && $dos==$email){
return redirect()->route('personal_registrado');

  }

  if(empty($tel)){

    $tel='s/n';

  }

  if(empty($email)){

    $email='s/c';

  }
  DB::table('personas')
    ->where('personas.id_persona', $id_p)
    ->update(['telefono' => $tel, 
            'email' => $email]);
Session::flash('message','¡Datos actualizados con éxito!');
return redirect()->route('personal_registrado');

}




 public function alta_personal(){
   $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='admin'){
     return redirect()->back();
   }

      $result = DB::table('personas')
      ->select('personas.id_persona', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->where([['personas.bandera','=','1'],['personas.nivel','=','1']])
       ->orderBy('personas.nombre', 'asc')
      ->get();

      $cargo=DB::table('tipo_user')
      ->select('tipo_user.id','tipo_user.tipo')
      ->get();

      $area=DB::table('areas')
      ->select('areas.id_area','areas.area')
      ->where('areas.area','!=','LABORATORIO')
      ->get();

    
    return view('admin.alta_personal')->with('alta', $result)->with('tipo', $cargo)->with('area', $area);
    }



public function alta_personal_nueva(Request $request){
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

    $this->validate($request, [
    'username' => ['required', 'string', 'max:100','unique:users'],
    'nombre' => ['required']
  ]);

  $data = $request;
  $contra= "laboratorio2020";
  $user_password= Hash::make($contra);

  $semestre = DB::table('semestre')
  ->select('semestre.id_semestre')
  ->where('semestre.estatus_semestre', '=', 'actual')
  ->take(1)
  ->first();
  $semestre= $semestre->id_semestre;

  $id_persona=$data['nombre'];
  $cargo=$data['personal'];
  $area=$data['area'];


  $id_p=DB::table('personas')
  ->select('personas.id_persona')
  ->where('personas.id_persona','=',$id_persona)
  ->take(1)
  ->first();
  $id_p=$id_p->id_persona;

  $cargop=DB::table('tipo_user')
  ->select('tipo_user.tipo')
  ->where('tipo_user.id','=',$cargo)
  ->take(1)
  ->first();
   $cargop=$cargop->tipo;


//cargo 1 de docente 
  if($cargo==1){

    $checa=DB::table('docentes')
    ->select('docentes.id_docente')
    ->where('docentes.id_persona',$id_p)
    ->count();
     
if(!empty($checa)){
    Session::flash('mess','¡El personal ya fué registrado como docente!');
    return redirect()->back();
}
    $tipo_usuario='docente';

    $docente=new Docente;
    $docente->id_persona=$id_p;
    $docente->id_semestre=$semestre;
    $docente->save();

    if($docente->save()){

       $id_per=DB::table('docentes')
      ->select('docentes.id_docente')
      ->where('docentes.id_persona',$id_p)
      ->take(1)
      ->first();

      $id_per=$id_per->id_docente;

     $id_rand= random_int(10000, 99999);

      $user=new User;
      $user->id_user=$id_rand;
      $user->username=$data['username'];
      $user->password =$user_password;
      $user->tipo_usuario=$tipo_usuario;
      $user->id_persona=$id_p;
      $user->id_docente=$id_per;
      $user->id_semestre=$semestre;
      $user->save();
      if($user->save()){

        Session::flash('message','!Docente registrado con éxito¡ La contraseña asignada es: laboratorio2020');
        return redirect()->route('docente_activo');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->route('docente_activo');
      }
    }
  }

//encargados de´area nivel 3 en la tabla personal
  if($cargo==2){

    $tipo_usuario='area';
    $nivel=3;
    $est='actual';

     $checa=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.id_persona',$id_p],['personal.nivel','=',$nivel],['personal.id_area','=',$area]])
    ->count();
     
if(!empty($checa)){
    Session::flash('mess','¡El personal ya fué registrado como encargado del área seleccionada!');
    return redirect()->back();
}
    
    $actual=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.estado','=','actual'],['personal.id_area','=',$area],['personal.nivel','=',$nivel]])
    ->count();

    if(!empty($actual)){
    Session::flash('mess','¡El área seleccionada actualmente tiene un encargado asignado!');
    return redirect()->back();
}

    $personal=new Personal;
    $personal->cargo=$cargop;
    $personal->estado=$est;
    $personal->nivel=$nivel;
    $personal->id_persona=$id_p;
    $personal->id_area=$area;
    $personal->save();

     if($personal->save()){

      $id_per=DB::table('personal')
      ->select('personal.id_personal')
      ->where([['personal.id_persona',$id_p],['personal.nivel','=',$nivel],['personal.id_area','=',$area]])
      ->take(1)
      ->first();

      $id_per=$id_per->id_personal;

     $id_rand= random_int(10000, 99999);

      $user=new User;
      $user->id_user=$id_rand;
      $user->username=$data['username'];
      $user->password =$user_password;
      $user->tipo_usuario=$tipo_usuario;
      $user->id_persona=$id_p;
      $user->id_personal=$id_per;
      $user->id_semestre=$semestre;
      $user->save();
      if($user->save()){

        Session::flash('message','!Encargado de área registrado con éxito¡ la contraseña asignada es: laboratorio2020');
        return redirect()->route('encargado_activo');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->route('encargado_activo');
      }
    }

  }

//nivel 2 jefe lab numero 3 en tipu_user
  if($cargo==3){

    $tipo_usuario='jefe';
    $nivel=2;
    $est='actual';

      $checa=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.id_persona',$id_p],['personal.nivel','=',$nivel]])
    ->count();

    if(!empty($checa)){
    Session::flash('mess','¡El personal ya fué registrado como jefe de laboratorio!');
    return redirect()->back();
}

    $verificar=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.nivel','=',$nivel],['personal.estado','=','actual']])
    ->count();


    if(!empty($verificar)){

       Session::flash('mess','¡Actualmente hay un jefe de laboratorio registrado!');
    return redirect()->back();

    }

     

    $personal=new Personal;
    $personal->cargo=$cargop;
    $personal->nivel=$nivel;
    $personal->estado=$est;
    $personal->id_persona=$id_p;
    $personal->save();

     if($personal->save()){

        $id_per=DB::table('personal')
      ->select('personal.id_personal')
      ->where([['personal.id_persona',$id_p],['personal.nivel','=',$nivel]])
      ->take(1)
      ->first();

      $id_per=$id_per->id_personal;

        $id_rand= random_int(10000, 99999);

      $user=new User;
      $user->id_user=$id_rand;
      $user->username=$data['username'];
      $user->password =$user_password;
      $user->tipo_usuario=$tipo_usuario;
      $user->id_persona=$id_p;
      $user->id_personal=$id_per;
      $user->id_semestre=$semestre;
      $user->save();
      if($user->save()){

        Session::flash('message','!Jefe de laboratorio registrado con éxito¡ la contraseña es: laboratorio2020');
        return redirect()->route('jefe_lab');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->route('jefe_lab');
      }
    }






  }
     //jefe de dpto
   if($cargo==4){

    $tipo_usuario='uno';
    $nivel=1;
    $estado='actual';

      $checa=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.id_persona',$id_p],['personal.nivel','=',$nivel]])
    ->count();

       if(!empty($checa)){
    Session::flash('mess','¡El personal ya fué registrado como jefe de departamento!');
    return redirect()->back();
}

    $verificar=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.nivel','=',$nivel],['personal.estado','=','actual']])
    ->count();


    if(!empty($verificar)){

       Session::flash('mess','¡Actualmente hay un jefe de departamento registrado!');
    return redirect()->back();

    }
    

    $personal=new Personal;
    $personal->cargo=$cargop;
    $personal->nivel=$nivel;
    $personal->estado=$estado;
    $personal->id_persona=$id_p;
    $personal->save();

     if($personal->save()){

        $id_per=DB::table('personal')
      ->select('personal.id_personal')
      ->where([['personal.id_persona',$id_p],['personal.nivel','=',$nivel]])
      ->take(1)
      ->first();

      $id_per=$id_per->id_personal;


         $id_rand= random_int(10000, 99999);

      $user=new User;
       $user->id_user=$id_rand;
      $user->username=$data['username'];
      $user->password =$user_password;
      $user->tipo_usuario=$tipo_usuario;
      $user->id_persona=$id_p;
      $user->id_personal=$id_per;
      $user->id_semestre=$semestre;
      $user->save();
      if($user->save()){

        Session::flash('message','!Jefe de departamento registrado con éxito¡ la contraseña es: laboratorio2020');
        return redirect()->route('jefe_departamento');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->route('');
      }
    }

  }


  }




    //persdonal del lab activo e inactivo del laboratorio
  public function jefe_departamento(){
    $usuario_actual=\Auth::user();
    if($usuario_actual->tipo_usuario!='admin'){
     return redirect()->back();
   }

    $activo = DB::table('users')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user','users.username','personal.estado')
   ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
   ->join('personal', 'users.id_personal', '=', 'personal.id_personal')
   ->where('users.tipo_usuario', '=', 'uno')
   ->orderBy('personal.estado', 'asc')
   ->paginate(8);

   return view('admin.jefe_departamento')->with('personal', $activo);
  }




  protected function desactivar_jefedpto($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
    $desactivado=$id_user;
    $per=DB::table('users')
    ->select('users.id_personal')
    ->where('users.id_user','=',$desactivado)
    ->take(1)
    ->first();
    
    $per=$per->id_personal;
    $dos=1;

     DB::table('personal')
    ->where([['personal.id_personal', $per],['personal.nivel','=',$dos],['personal.estado','=','actual']])
    ->update(
      ['estado' => 'anterior']);

    DB::table('users')
    ->where('users.id_user', $desactivado)
    ->update(
      ['bandera' => '0']);
    Session::flash('mess','Jefe de departamento desactivado!');
    return redirect()->route('jefe_departamento');
  }



  protected function activar_jefedpto($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
    $desactivado=$id_user;

    $per=DB::table('users')
    ->select('users.id_personal')
    ->where('users.id_user','=',$desactivado)
    ->take(1)
    ->first();
    
    $per=$per->id_personal;
    $dos=1;

    $ver=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.estado','=','actual'],['personal.nivel','=',$dos]])
    ->count();

    if(!empty($ver)){
  Session::flash('mess','!No se puede activar, actualmente hay un jefe de departamento registrado!');
        return redirect()->back();

    }

     DB::table('personal')
    ->where([['personal.id_personal', $per],['personal.nivel','=',$dos]])
    ->update(
      ['estado' => 'actual']);

    DB::table('users')
    ->where('users.id_user', $desactivado)
    ->update(
      ['bandera' => '1']);
    Session::flash('message','Jefe de departamento activado!');
    return redirect()->route('jefe_departamento');
  }







    //persdonal del lab activo e inactivo del laboratorio
  public function jefe_lab(){
    $usuario_actual=\Auth::user();
    if($usuario_actual->tipo_usuario!='admin'){
     return redirect()->back();
   }

     $activo = DB::table('users')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user','users.username','personal.estado')
   ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
   ->join('personal', 'users.id_personal', '=', 'personal.id_personal')
   ->where('users.tipo_usuario', '=', 'jefe')
   ->orderBy('personal.estado', 'asc')
   ->paginate(8);


   return view('admin.jefe_laboratorio')->with('personal', $activo);
  }




  protected function desactivar_jefelab($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
    $desactivado=$id_user;
    $per=DB::table('users')
    ->select('users.id_personal')
    ->where('users.id_user','=',$desactivado)
    ->take(1)
    ->first();
    
    $per=$per->id_personal;
    $dos=2;

     DB::table('personal')
    ->where([['personal.id_personal', $per],['personal.nivel','=',$dos],['personal.estado','=','actual']])
    ->update(
      ['estado' => 'anterior']);

    DB::table('users')
    ->where('users.id_user', $desactivado)
    ->update(
      ['bandera' => '0']);
    Session::flash('mess','Jefe de laboratorio desactivado!');
    return redirect()->route('jefe_lab');
  }




  protected function activar_jefelab($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
    $desactivado=$id_user;

    $per=DB::table('users')
    ->select('users.id_personal')
    ->where('users.id_user','=',$desactivado)
    ->take(1)
    ->first();
    
    $per=$per->id_personal;
    $dos=2;

    $ver=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.estado','=','actual'],['personal.nivel','=',$dos]])
    ->count();

    if(!empty($ver)){
  Session::flash('mess','!No se puede activar, actualmente hay un jefe de laboratorio registrado!');
        return redirect()->back();

    }

     DB::table('personal')
    ->where([['personal.id_personal', $per],['personal.nivel','=',$dos]])
    ->update(
      ['estado' => 'actual']);

    DB::table('users')
    ->where('users.id_user', $desactivado)
    ->update(
      ['bandera' => '1']);
    Session::flash('message','Jefe de laboratorio activado!');
    return redirect()->route('jefe_lab');
  }





    //persdonal del lab activo e inactivo del laboratorio
	public function encargado_activo(){
    $usuario_actual=\Auth::user();
    if($usuario_actual->tipo_usuario!='admin'){
     return redirect()->back();
   }

   $activo = DB::table('users')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user','users.username','areas.area','personal.estado')
   ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
   ->join('personal', 'users.id_personal', '=', 'personal.id_personal')
   ->join('areas', 'personal.id_area', '=', 'areas.id_area')
   ->where([['users.bandera', '=', '1'],['users.tipo_usuario', '=', 'area']])

   ->orderBy('personas.nombre', 'asc')
   ->paginate(8);

   return view('admin.encargado_activo')->with('personal', $activo);
	}


  protected function desactivar_encargado($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

    $desactivado=$id_user;
    
     $personal=DB::table('users')
    ->select('users.id_personal')
    ->where('users.id_user',$desactivado)
    ->take(1)
    ->first();

    $personal=$personal->id_personal;


    DB::table('personal')
    ->where('personal.id_personal', $personal)
    ->update(
      ['estado' => 'anterior']);

    DB::table('users')
    ->where('users.id_user', $desactivado)
    ->update(
      ['bandera' => '0']);
    Session::flash('message','Encargado de área desactivado!');
    return redirect()->route('encargado_inactivo');
  }

    public function encargado_inactivo(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

    $inactivo = DB::table('users')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user','users.username','areas.area','personal.estado')
   ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
   ->join('personal', 'users.id_personal', '=', 'personal.id_personal')
   ->join('areas', 'personal.id_area', '=', 'areas.id_area')
   ->where([['users.bandera', '=', '0'],['users.tipo_usuario', '=', 'area']])

   ->orderBy('personas.nombre', 'asc')
   ->paginate(8);


    return view('admin.encargado_inactivo')->with('personal', $inactivo);
  }



	 protected function restablecimiento_pass($id_user){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

  $id= $id_user;
  $nueva_con= "laboratorio2020";
    $user_password= Hash::make($nueva_con);
    DB::table('users')
      ->where('users.id_user', $id)
      ->update(
          ['password' => $user_password]);
      Session::flash('message','Nueva Contraseña asignada: laboratorio2020');
      return redirect()->back();
}


	protected function activar_encargado($id_user){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

   $contra= "laboratorio2020";
  $user_password= Hash::make($contra);

		$activado=$id_user;


      $personal=DB::table('users')
    ->select('users.id_personal')
    ->where('users.id_user',$activado)
    ->take(1)
    ->first();

    $personal=$personal->id_personal;

    $areac=DB::table('personal')
    ->select('personal.id_area')
    ->where('personal.id_personal',$personal)
    ->take(1)
    ->first();

    $areac=$areac->id_area;

    $ver=DB::table('personal')
    ->select('personal.id_personal')
    ->where([['personal.id_area','=',$areac],['personal.estado','=','actual']])
    ->count();


    if(!empty($ver)){

       Session::flash('message','Actualmente hay un encargado registrado para el área');
      return redirect()->back();

    }

      $personal=DB::table('users')
    ->select('users.id_personal')
    ->where('users.id_user',$activado)
    ->take(1)
    ->first();

    $personal=$personal->id_personal;

    DB::table('personal')
    ->where('personal.id_personal', $personal)
    ->update(
      ['estado' => 'actual']);

		DB::table('users')
		->where('users.id_user', $activado)
		->update(
			['bandera' => '1','password' => $user_password]);
		Session::flash('message','¡Encargado de área activado! Contraseña asignada: laboratorio2020');
		return redirect()->route('encargado_activo');
	}



//docente del lab activo e inactivo
	public function docente_activo(){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

      $activo = DB::table('users')
		->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.username')
		->join('personas', 'users.id_persona', '=', 'personas.id_persona')
		->join('docentes', 'users.id_docente', '=', 'docentes.id_docente')
		->where([['users.bandera', '=', '1'],['users.tipo_usuario','=','docente']])
		->orderBy('personas.updated_at', 'DESC')
		->simplePaginate(8);

		return view('admin.docente_activo')->with('docente',$activo);
	}

	public function docente_inactivo(){
		  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
        $inactivo = DB::table('users')
    ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.username')
    ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
    ->join('docentes', 'users.id_docente', '=', 'docentes.id_docente')
    ->where([['users.bandera', '=', '0'],['users.tipo_usuario','=','docente']])
    ->orderBy('personas.nombre', 'asc')
    ->simplePaginate(8);


		return view('admin.docente_inactivo')->with('docente',$inactivo);

	}

	protected function desactivar_docente($id_user){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

      $desactivado=$id_user;

      $periodo_semestre = DB::table('semestre')
      ->select('semestre.id_semestre')
      ->where('semestre.estatus_semestre', '=', 'actual')
      ->take(1)
      ->first();
      $periodo_semestre= $periodo_semestre->id_semestre;

      $id_persona = DB::table('docentes')
      ->select('docentes.id_persona','docentes.id_docente')
      ->join('personas', 'personas.id_persona', '=' ,'docentes.id_persona')
      ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
      ->where('users.id_user', $desactivado)
      ->take(1)
      ->first();
      $id_d=$id_persona->id_docente;

      $grupos= DB::table('grupos')
      ->select('id_grupo')
      ->join('docentes','docentes.id_docente','=','grupos.id_docente')
      ->join('semestre','semestre.id_semestre','=','grupos.id_semestre')
      ->where([['grupos.id_docente', '=', $id_d],['grupos.id_semestre','=',$periodo_semestre]])
      ->count();

      if(empty($grupos)){
       DB::table('users')
       ->where('users.id_user', $desactivado)
       ->update(
         ['bandera' => '0']);
       Session::flash('message','¡Cuenta de docente desactivada!');
       return redirect()->route('docente_inactivo');


     }else
     {
       Session::flash('mess','ERROR,¡El docente tiene grupos asignados durante este semestre!');
       return redirect()->back();

     }
   }

	protected function activar_docente($id_user){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

       $contra= "laboratorio2020";
  $user_password= Hash::make($contra);

		$activado=$id_user;
		DB::table('users')
		->where('users.id_user', $activado)
		->update(['bandera' => '1','password' => $user_password]);
		Session::flash('message','¡Docente Activado con éxito, la contraseña asignada es: laboratorio2020!');
		return redirect()->route('docente_activo');
	}

//registrar estudiantes que usen el lab
	public function registro_estudianteadmin(){
		  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }

		return view('admin.registro_estudiante');
	}
//estudiante del lab activo e inactivo
	public function estudiante_activo(){
		  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
		return view('admin.estudiante_activo');
	}

	public function estudiante_inactivo(){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }



		return view('admin.estudiante_inactivo');
	}






	public function cuenta_docente(){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      }
		$cuentas = DB::table('cuentas')
		->select('cuentas.id_cuenta','cuentas.nombre', 'cuentas.apellido_paterno', 'cuentas.apellido_materno','cuentas.estado','cuentas.created_at','cuentas.departamento','cuentas.email','cuentas.username','cuentas.curp')
		->where('cuentas.estado', '=', 'pendiente')
		->orderBy('cuentas.created_at','asc')
		->simplePaginate(8);


		return view('admin.cuenta_docente')->with('cuentasp',$cuentas);
	}

	public function cuenta_aprobar($id_cuenta){
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


      return view('mails.envio_notificacion')
      ->with('datos', $datos_cuenta)
      ->with('cuenta', $cuenta);
      
    }







    public function cuenta_admin(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='admin'){
         return redirect()->back();
        }
		
		  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	
	 $datos = DB::table('personas')
                  ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno','personas.telefono','personas.email')
                  ->join('users', 'personas.id_persona', '=', 'users.id_persona')
                  ->where('users.id_persona',$id)
                  ->take(1)
                  ->first();
	
	
    return view('admin.configuracion_admin')->with('datos_admin', $datos);
    }

     public function changePassword(Request $request){

          if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
              // The passwords matches
          	 Session::flash('message','Su contraseña actual no coincide con la contraseña que proporcionó. Inténtalo de nuevo.');
              return redirect()->back();
          }

          if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
              //Current password and new password are same
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

          if($user->save()){
          	Session::flash('mess','Contraseña Actualizada');
            return redirect()->route('cuenta_admin');
          }

      }

       public function changeuser(Request $request){
 $this->validate($request, [
      'username' => ['required', 'string', 'max:255', 'unique:users'],
          ]);

    $data = $request;
       
          //Change Password
          $user = Auth::user();
          $user->username = $data['username'];
          $user->save();

          if($user->save()){
          		Session::flash('mess','El nombre de usuario se ha actualizado correctamente');
            return redirect()->route('cuenta_admin');
          }

      }

/*
       public function changemail(Request $request){
 $this->validate($request, [
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          ]);

    $data = $request;
       
          //Change Password
          $user = Auth::user();
		   $user->email = $data['email'];
          $user->save();

          if($user->save()){
          	Session::flash('mess','El correo se ha actualizado correctamente');
            return redirect()->route('cuenta_admin');
          }

      }
*/

      public function datos_personales_admin(Request $request){
			   	  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	$data = $request;
   DB::table('personas')
      ->where('personas.id_persona', $id)
      ->update([ 'telefono' => $data['telefono'] ,'email' => $data['email']]);
          Session::flash('mess','Datos actualizados correctamente');
            return redirect()->route('cuenta_admin');
         
      }


 public function foto_ito(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='admin'){
         return redirect()->back();
        }
    return view('admin.foto_ito');
    }

 public function formatos(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='admin'){
         return redirect()->back();
        }

    $tex=DB::table('textos')
    ->select('textos.frase_cabecera','textos.lema_uno','textos.lema_dos','textos.telefono','textos.pagina')
    ->where('textos.id_texto','=','1')
    ->take(1)
    ->first();
    return view('admin.actualizar_formato')->with('textos',$tex);
    }

  public function nuevo_formato(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='admin'){
       return redirect()->back();
      } 
     $data = $request;

     $frase1=$data['frase_cabecera'];
     $frase2=$data['lema_uno'];
     $frase3=$data['lema_dos'];
     $frase4=$data['telefono'];
     $frase5=$data['pagina'];

     if(empty($frase1) || empty($frase2) || empty($frase3) || empty($frase4) || empty($frase5) )
     {

        Session::flash('mess','No deje campos vacios');


 return redirect()->back();

     }

     DB::table('textos')
     ->where('id_texto', '=','1')
     ->update(['frase_cabecera' =>$frase1,'lema_uno'=>$frase2,'lema_dos'=>$frase3,'telefono'=>$frase4,'pagina'=>$frase5]);
     Session::flash('message','Datos para formatos actualizados');


 return redirect()->route('admin');

   }
	  


   

  
}











