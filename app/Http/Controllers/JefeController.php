<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Area;
use App\Personal;
use App\Persona;
use App\User;
use App\Grupo;
use App\Tipo;
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

class JefeController extends Controller
{

	 //mostrar la pag. principal del jefe de lab
    public function home(){
    
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

      $mat = DB::table('materiales')
   ->select('materiales.id_material','materiales.nombre_material','materiales.marca','areas.area','tipos.tipo','materiales.modelo')
   ->where('materiales.bandera', '=', '1')
   ->join('areas','materiales.id_area','=','areas.id_area')
   ->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
   ->orderBy('materiales.created_at', 'DESC')
   ->paginate(7);

   $totalm=DB::table('materiales')
   ->count();

   $totalp=DB::table('personal')
   ->count();

   $totald=DB::table('docentes')
   ->count();

   $totale=DB::table('estudiantes')
   ->count();

return view('jefe.home_jefe')
->with('mate',$mat)
->with('mat',$totalm)
->with('per',$totalp)
->with('doc',$totald)
->with('est',$totale);
   	

	}




      //registro de tipos de materiales.
public function registro_tipo_jefe(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

  $tipo = DB::table('tipos')
  ->select('tipos.id_tipo','tipos.tipo')

  ->Paginate(8);

  return view('jefe.registro_tiposd')->with('tipos',$tipo);
}

public function registrar_tiposdpto(Request $request)
{ 
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
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
  return redirect()->route('registro_tipo_jefe');
}



    public function registrar_materiales(Request $request)
    { 
        $this->validate($request, [
            'id_material' => ['required', 'unique:materiales'],
            
       ]);

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

   return redirect()->route('jefe');
    
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
             return redirect()->route('ver_unidades_jefe', ['id_material' => $checa]);

     //return redirect()->route('admin');
    
     } else {

      $suma=$data['total']+$contar;

      DB::table('unidades')
     ->where('id_material', $checa)
     ->update(['total' =>$suma]);
     Session::flash('message','¡Material agregado con éxito!');
             return redirect()->route('ver_unidades_jefe', ['id_material' => $checa]);

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
              'tipo' => ['required'],
              'num_serie' => ['required', 'unique:unidades'],
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
    $modelx->num_serie = $data['num_serie'];
    $modelx->descripcion = $data['descripcion'];

    $modelx->medida=$data['medida'];
    $modelx->save();

     DB::table('materiales')
     ->where('id_material', $valor_mate)
     ->update(['n_unidades' =>$i]);

     
}



    Session::flash('message','¡Material agregado con éxito!');
    return redirect()->route('jefe');
    
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
       $modelx->num_serie = $data['num_serie'];
    $modelx->descripcion = $data['descripcion'];
    $modelx->save();

     DB::table('materiales')
     ->where('id_material', $valor_mate)
     ->update(['n_unidades' =>$i]);
}
     }

     Session::flash('message','Unidades agregadas.');
            return redirect()->route('jefe');


       

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
    return redirect()->route('jefe');
    
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
       $modelx->num_serie = $data['num_serie'];
    $modelx->descripcion = $data['descripcion'];
    $modelx->save();

     DB::table('materiales')
     ->where('id_material', $checa)
     ->update(['n_unidades' =>$i]);
}
     }
     Session::flash('message','Nuevas unidades agregadas con éxito');
                  return redirect()->route('ver_unidades_jefe', ['id_material' => $checa]);

           // return redirect()->route('admin');


       
}




//registro de materiales nuevos.
public function registro_material(){
 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

    $i=330;
    $b=55;
      
  $id_de_areas = DB::table('areas')
  ->select('areas.id_area', 'areas.area')
  ->where('areas.id_area','!=',$b)
  ->get();

    $id_de_tipos = DB::table('tipos')
  ->select('tipos.id_tipo', 'tipos.tipo')
  ->where('tipos.id_tipo','!=',$i)
  ->get();

  return view('jefe.registro_material')
  ->with('areas_disponibles', $id_de_areas)->with('tipos_disponibles',$id_de_tipos);

}



 //home del admin con la busqueda.
	public function buscar_material_home(Request $request){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
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

		$bus = $request->get('buscador');

		if($bus != null){
			$mats = Material::where( 'materiales.nombre_material', 'LIKE', '%' . $bus . '%')
			->where('materiales.bandera', '=', '1')
			->join('areas','materiales.id_area','=','areas.id_area')
			->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
			->paginate(7);

			if (count ($mats) > 0 ) {
          
				return view ( 'jefe.home_jefe' )
				->withInfo ($mats)
        ->withQuery ($bus)
        ->with('mat',$totalm)
				->with('per',$totalp)
				->with('doc',$totald)
				->with('est',$totale);

			}else{
				Session::flash('mess','No hay materiales registrados que coincidan con la búsqueda');
				return redirect()->route('jefe')->with('mat',$totalm)
        ->with('per',$totalp)
        ->with('doc',$totald)
        ->with('est',$totale);
			}
		}else{
			Session::flash('mess','Material no encontrado');
			return redirect()->route('jefe') ->with('mat',$totalm)
        ->with('per',$totalp)
        ->with('doc',$totald)
        ->with('est',$totale);
			//return redirect()->route('busqueda_material');
		}
	}


	    //actualizar materiales
	public function actualiza_material($id_material){
		
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
		$data = $id_material;

		 $insumo=DB::table('materiales')
      ->select('materiales.id_tipo')
      ->where('materiales.id_material','=',$data)
      ->take(1)
      ->first();
      $insumo=$insumo->id_tipo;
      
      $check=330;
        if($insumo==$check){

        	$mater = DB::table('materiales')
		->select('materiales.id_material','materiales.nombre_material','materiales.modelo','tipos.tipo','materiales.marca','areas.area')
		->join('areas','areas.id_area','=','materiales.id_area')
		->join('tipos','tipos.id_tipo','=','materiales.id_tipo')
		->where('materiales.id_material', '=', $data)
		->take(1)
		->first();

		$unidades=DB::table('unidades')
		->select('unidades.total')
		->where([['unidades.id_material','=',$data],['unidades.estado','!=','eliminado']])
		->take(1)
		->first();

		$medida=DB::table('unidades')
		->select('unidades.medida')
		->where([['unidades.id_material','=',$data],['unidades.estado','!=','eliminado']])
		->take(1)
		->first();

		return view("jefe.actualizar_insumo")->with('material', $mater)->with('uni', $unidades)->with('med', $medida);

        }


		$mater = DB::table('materiales')
		->select('materiales.id_material','materiales.nombre_material','materiales.modelo','tipos.tipo','materiales.marca','areas.area')
		->join('areas','areas.id_area','=','materiales.id_area')
		->join('tipos','tipos.id_tipo','=','materiales.id_tipo')
		->where('materiales.id_material', '=', $data)
		->take(1)
		->first();

		$unidades=DB::table('unidades')
		->select('unidades.id_unidad')
		->where([['unidades.id_material','=',$data],['unidades.estado','!=','eliminado']])
		->count();

		return view("jefe.actualizar_material")->with('material', $mater)->with('uni', $unidades); 
	}




  // ver unidades
	public function ver_unidad($id_material){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

      $data = $id_material;

      $insumo=DB::table('materiales')
      ->select('materiales.id_tipo')
      ->where('materiales.id_material','=',$data)
      ->take(1)
      ->first();
      $insumo=$insumo->id_tipo;
      
      $check=330;

      if($insumo==$check){

      	$mater = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida','unidades.total')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		->where('materiales.id_material', '=', $data)
		->simplePaginate(6);

      	$name = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		->where('materiales.id_material', '=', $data)
		->take(1)
		->first();
         $name=$name->nombre_material;

          $contar=DB::table('unidades')
         ->select('unidades.total')
         ->where('unidades.id_material','=',$data)
         ->take(1)
         ->first();

           $conta=DB::table('unidades')
         ->select('unidades.medida')
         ->where('unidades.id_material','=',$data)
         ->take(1)
         ->first();

            $cont=DB::table('unidades')
         ->select('unidades.id_material')
         ->where([['unidades.id_material','=',$data],['unidades.bandera','=','0']])
         ->count();

        


      	


		return view("jefe.ver_insumos")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont);

      }

    

		
		$mater = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','unidades.num_serie','unidades.descripcion','materiales.nombre_material','materiales.id_material','unidades.medida')
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




		 return view("jefe.ver_unidades")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont);
}



protected function desactivar_unidad($codigo_unidad){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
		$data = $codigo_unidad;
		$unid = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.bandera','unidades.estado','materiales.nombre_material','materiales.id_material')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		->where('unidades.codigo_unidad', '=', $data)
		->take(1)
		->first();

		return view("jefe.desactivar_unidad")->with('unidad', $unid); 
	}


 protected function activar_unidad($codigo_unidad){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
    $data = $codigo_unidad;

    $contar=DB::table('unidades')
      ->select('unidades.id_material')
      ->where('unidades.codigo_unidad','=',$data)
      ->take(1)
      ->first();
      $contar=$contar->id_material;

    $conta=DB::table('materiales')
      ->select('materiales.n_unidades')
      ->where('materiales.id_material','=',$contar)
      ->take(1)
      ->first();
      $conta=$conta->n_unidades;
      $mas=$conta+1;

       DB::table('materiales')
     ->where('id_material', $contar)
     ->update(['n_unidades' =>$mas]);

    DB::table('unidades')
     ->where('codigo_unidad', $data)
     ->update(['observaciones' =>'s/n','bandera'=>'1','estado'=>'disponible']);
     Session::flash('message','Unidad activada con éxito ');
    return redirect()->back(); 
  }

  protected function baja_unidad_def($codigo_unidad){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
    $data = $codigo_unidad;
    $unid = DB::table('unidades')
    ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.bandera','unidades.estado','materiales.nombre_material','materiales.id_material')
    ->join('materiales','materiales.id_material','=','unidades.id_material')
    
    ->where('unidades.codigo_unidad', '=', $data)
    ->take(1)
    ->first();

    return view("jefe.baja_unidad_definitiva")->with('unidad', $unid); 
  }



  public function baja_definitiva_unidad(Request $request){
        $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
     $data = $request;

    $id_material=$data['id_material'];

    $conta=DB::table('materiales')
      ->select('materiales.n_unidades')
      ->where('materiales.id_material','=',$id_material)
      ->take(1)
      ->first();
      $conta=$conta->n_unidades;
      $menos=$conta-1;

       DB::table('materiales')
     ->where('id_material', $id_material)
     ->update(['n_unidades' =>$menos]);

     DB::table('unidades')
     ->where('codigo_unidad', $data['codigo_unidad'])
     ->update(['observaciones' =>$data['observaciones'],'bandera'=>'1','estado'=>'eliminado']);
     
 
     
     Session::flash('mess','Unidad eliminada del inventario');
     //return view("admin.ver_unidades")->with('veruni', $mater)->with('ver', $id_material);
      //return redirect()->route('reporte_eliminados');
      return redirect()->route('ver_eliminados_jefe', ['id_material' => $id_material]);
 }


 public function ver_eliminados($id_material){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

      $data = $id_material;
    
    $mater = DB::table('unidades')
    ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida','unidades.updated_at')
    ->join('materiales','materiales.id_material','=','unidades.id_material')
    ->where([['materiales.id_material', '=', $data],['unidades.estado','=','eliminado']])
      ->orderBy('unidades.updated_at','DESC')
    ->simplePaginate(6);

    $name = DB::table('unidades')
    ->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida')
    ->join('materiales','materiales.id_material','=','unidades.id_material')
    ->where('materiales.id_material', '=', $data)
    ->take(1)
    ->first();
         $name=$name->nombre_material;

         $contar=DB::table('materiales')
         ->select('materiales.id_area','areas.area')
         ->join('areas','areas.id_area','=','materiales.id_area')
         ->where('materiales.id_material','=',$data)
         ->take(1)
         ->first();

          $conta=DB::table('materiales')
         ->select('materiales.id_tipo','tipos.tipo')
         ->join('tipos','tipos.id_tipo','=','materiales.id_tipo')
         ->where('materiales.id_material','=',$data)
         ->take(1)
         ->first();

          $cont=DB::table('unidades')
         ->select('unidades.id_material','unidades.estado')
         ->where([['unidades.id_material','=',$data],['unidades.estado','=','eliminado']])
         ->count();




     return view("jefe/reportes.ver_eliminados")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
     ->with('disponible',$conta)->with('no',$cont);
}




    public function reporte_eliminar(){
    
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }


      $material=DB::table('materiales')
      ->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.clave','materiales.modelo')
      ->join('unidades','unidades.id_material','=','materiales.id_material')
      ->where([['unidades.estado', '=', 'eliminado'],['materiales.bandera','=','1']])
      ->orderBy('materiales.updated_at', 'DESC')
      ->distinct()
    ->simplePaginate(6);

      return view('jefe/reportes.reporte_eliminados')->with('activo', $material);

    }








    public function baja_unidad(Request $request){
    	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
     $data = $request;

      $id_material=$data['id_material'];

      $conta=DB::table('materiales')
      ->select('materiales.n_unidades')
      ->where('materiales.id_material','=',$id_material)
      ->take(1)
      ->first();
      $conta=$conta->n_unidades;
      $menos=$conta-1;

       DB::table('materiales')
     ->where('id_material', $id_material)
     ->update(['n_unidades' =>$menos]);

     DB::table('unidades')
     ->where('codigo_unidad', $data['codigo_unidad'])
     ->update(['observaciones' =>$data['observaciones'],'bandera'=>'0','estado'=>'no disponible']);
     Session::flash('mess','La unidad fue dada de baja de manera temporal');

       //return view("admin.ver_unidades")->with('veruni', $mater)->with('ver', $id_material);
    return redirect()->route('ver_temporales_jefe', ['id_material' => $id_material]);
 }


     public function ver_temporales($id_material){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

      $data = $id_material;
		
		$mater = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida','unidades.updated_at')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		->where([['materiales.id_material', '=', $data],['unidades.bandera','=','0']])
		->orderBy('unidades.updated_at','DESC')
		->simplePaginate(6);

		$name = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		->where('materiales.id_material', '=', $data)
		->take(1)
		->first();
         $name=$name->nombre_material;

         $contar=DB::table('materiales')
         ->select('materiales.id_area','areas.area')
         ->join('areas','areas.id_area','=','materiales.id_area')
         ->where('materiales.id_material','=',$data)
         ->take(1)
         ->first();

          $conta=DB::table('materiales')
         ->select('materiales.id_tipo','tipos.tipo')
         ->join('tipos','tipos.id_tipo','=','materiales.id_tipo')
         ->where('materiales.id_material','=',$data)
         ->take(1)
         ->first();

          $cont=DB::table('unidades')
         ->select('unidades.id_material','unidades.estado')
         ->where([['unidades.id_material','=',$data],['unidades.bandera','=','0']])
         ->count();




		 return view("jefe/reportes.ver_temporales")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont);
}




public function reporte_temporales(){
    
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
      	


      $material=DB::table('materiales')
      ->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.clave','materiales.modelo')
      ->join('unidades','unidades.id_material','=','materiales.id_material')
       ->where([['unidades.bandera', '=', '0'],['materiales.bandera','=','1']])
      ->orderBy('materiales.updated_at', 'DESC')
      ->distinct()
	  ->simplePaginate(6);

      return view('jefe/reportes.reporte_temporal')->with('activo', $material);

    }



//busqueda por nombre
public function buscar_materiales(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
	$bus = $request->get('buscador');

	if($bus != null){
		$mats = Material::where( 'materiales.nombre_material', 'LIKE', '%' . $bus . '%')
        ->where('materiales.bandera', '=', '1')//mis materiales activos solamnete
        ->join('areas','materiales.id_area','=','areas.id_area')
        ->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
        ->simplePaginate(10);

        if (count ($mats) > 0 ) {
        	return view ( 'jefe.busqueda_material' )->withDetails ($mats )->withQuery ($bus);
        }else{
        	Session::flash('mess','No hay materiales relacionados con la búsqueda');
        	return redirect()->route('materiales_activos_jefe');
        }

    } 
    else{
    	Session::flash('mess','No hay materiales relacionados con la búsqueda');
    	return redirect()->route('materiales_activos_jefe');
    }

}


	//vista para buscar los materiales activos
public function busqueda_material(){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
      $est = DB::table('materiales')
      ->select('materiales.id_material', 'materiales.nombre_material','materiales.clave','materiales.modelo','materiales.marca','materiales.updated_at', 'areas.area', 'tipos.tipo')
      ->join('areas', 'materiales.id_area', '=', 'areas.id_area')
      ->join('tipos', 'materiales.id_tipo', '=', 'tipos.id_tipo')
      ->where('materiales.bandera', '=', '1')
      ->orderBy('materiales.updated_at', 'DESC')
      ->simplePaginate(10);



      return view('jefe.busqueda_material')->with('activo', $est);

      //return view('admin.busqueda_material');
}


    //busqueda por area
public function buscar_materialest(Request $request){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

	$bus = $request->get('buscadortipo');
    if($bus != null){
		$mats = Tipo::where( 'tipos.tipo', 'LIKE', '%' . $bus . '%')
		 ->where('materiales.bandera', '=', '1')//mis materiales activos solkamnete
		->join('materiales','tipos.id_tipo','=','materiales.id_tipo')
		->join('areas','materiales.id_area','=','areas.id_area')
		->simplePaginate(10);

		if (count ($mats) > 0 ) {

			return view ( 'jefe.busqueda_material' )->withDetail ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('materiales_activos_jefe');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('materiales_activos_jefe');
	}

}


 //busqueda por area
public function buscar_materialesa(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

	$bus = $request->get('buscadorarea');

if($bus != null){
		$mats = Area::where( 'areas.area', 'LIKE', '%' . $bus . '%')
		 ->where('materiales.bandera', '=', '1')//mis materiales activos solkamnete
		->join('materiales','areas.id_area','=','materiales.id_area')
		->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
		->simplePaginate(10);

		if (count ($mats) > 0 ) {

			return view ( 'jefe.busqueda_material' )->withDetaila ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('materiales_activos_jefe');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('materiales_activos_jefe');
	}

}



  //detalles material
	public function detalles_material($id_material){
		  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      } 

 		$data = $id_material;

	  $insumo=DB::table('materiales')
      ->select('materiales.id_tipo')
      ->where('materiales.id_material','=',$data)
      ->take(1)
      ->first();
      $insumo=$insumo->id_tipo;
      
      $check=330;

       if($insumo==$check){
       	$nombre=DB::table('materiales')
		->select('materiales.nombre_material')
		->where('materiales.id_material','=',$data)
		->take(1)
		->first();

		$nombre=$nombre->nombre_material;





		$name = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','materiales.nombre_material','materiales.id_material','unidades.medida')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		->where('materiales.id_material', '=', $data)
		->take(1)
		->first();

    dd($name);
         $name=$name->nombre_material;

         dd($name);

         $contar=DB::table('unidades')
         ->select('unidades.total')
         ->where([['unidades.id_material','=',$data],['unidades.estado','!=','eliminado']])
         ->take(1)
         ->first();

          $conta=DB::table('unidades')
         ->select('unidades.medida')
         ->where([['unidades.id_material','=',$data],['unidades.estado','=','disponible']])
         ->take(1)
         ->first();

          $cont=DB::table('unidades')
         ->select('unidades.id_material')
         ->where([['unidades.id_material','=',$data],['unidades.bandera','=','0']])
         ->count();

         $area=DB::table('materiales')
         ->select('areas.area')
         ->join('areas','areas.id_area','=','materiales.id_area')
         ->where('materiales.id_material', '=', $data)
		->take(1)
		->first();

		$area=$area->area;

		 $tipo=DB::table('materiales')
         ->select('tipos.tipo')
         ->join('tipos','tipos.id_tipo','=','materiales.id_tipo')
         ->where('materiales.id_material', '=', $data)
		->take(1)
		->first();

		$tipo=$tipo->tipo;


		return view("jefe.detalles_insumo")->with('nombre', $nombre)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont)->with('area',$area)->with('tipo',$tipo); 
}


		$nombre=DB::table('materiales')
		->select('materiales.nombre_material')
		->where('materiales.id_material','=',$data)
		->take(1)
		->first();

		$nombre=$nombre->nombre_material;

		



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

         $area=DB::table('materiales')
         ->select('areas.area')
         ->join('areas','areas.id_area','=','materiales.id_area')
         ->where('materiales.id_material', '=', $data)
		->take(1)
		->first();

		$area=$area->area;

		 $tipo=DB::table('materiales')
         ->select('tipos.tipo')
         ->join('tipos','tipos.id_tipo','=','materiales.id_tipo')
         ->where('materiales.id_material', '=', $data)
		->take(1)
		->first();

		$tipo=$tipo->tipo;


		return view("jefe.detalles_material")->with('nombre', $nombre)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont)->with('area',$area)->with('tipo',$tipo); 
	}



	protected function desactivar_material($id_material){
	$usuario_actual=\Auth::user();
	if($usuario_actual->tipo_usuario!='jefe'){
		return redirect()->back();
	}
	$desactivado=$id_material;
	$elimina='eliminado';

	$checa= DB::table('unidades')
	->select('unidades.bandera')
	->join('materiales','materiales.id_material','=','unidades.id_material')
	->where([['unidades.id_material', '=', $desactivado],['unidades.estado','!=',$elimina]])
	->get();
	$suma=0;
	foreach ($checa as $c =>$valor ) {
		$thearray = (array) $valor;
		$n=$valor->bandera;
		$suma += $n;
	}

	$vale=$suma;
	
	$verifica= DB::table('unidades')
	->select('unidades.bandera','unidades.estado')
	->join('materiales','materiales.id_material','=','unidades.id_material')
	->where([['unidades.id_material', '=', $desactivado],['unidades.estado','!=',$elimina]])
	->count();

	if($vale==$verifica){
		DB::table('materiales')
		->where('materiales.id_material', $desactivado)
		->update(
			['bandera' => '0']);
		Session::flash('mess','¡Material desactivado del inventario!');
		return redirect()->route('material_inactivo_jefe');
	}

	Session::flash('mess','¡El material no se puede desactivar hay unidades en uso!');
	return redirect()->back();
}



	protected function activar_material($id_material){
		 $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='jefe'){
       return redirect()->back();
      }
		$activado=$id_material;
		DB::table('materiales')
		->where('materiales.id_material', $activado)
		->update(
			['bandera' => '1']);
		Session::flash('message','¡Material Activado!');
		return redirect()->route('materiales_activos_jefe');
	}



public function material_inactivo(){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

	 $est = DB::table('materiales')
     ->select('materiales.id_material', 'materiales.nombre_material','materiales.clave','materiales.modelo', 'materiales.marca','materiales.updated_at', 'areas.area', 'tipos.tipo')
        ->join('areas', 'materiales.id_area', '=', 'areas.id_area')
        ->join('tipos', 'materiales.id_tipo', '=', 'tipos.id_tipo')
        ->where('materiales.bandera', '=', '0')

         ->orderBy('materiales.updated_at', 'DESC')
        ->simplePaginate(10);



        return view('jefe.material_inactivo')->with('inactivo', $est);


	
}



//busqueda por nombre
public function buscar_materiales_inac(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }
	$bus = $request->get('buscador');

	if($bus != null){
		$mats = Material::where( 'materiales.nombre_material', 'LIKE', '%' . $bus . '%')
        ->where('materiales.bandera', '=', '0')//mis materiales inactivos solamnete
        ->join('areas','materiales.id_area','=','areas.id_area')
        ->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
        ->simplePaginate(10);

        if (count ($mats) > 0 ) {
        	return view ( 'jefe.material_inactivo' )->withDetails ($mats )->withQuery ($bus);
        }else{
        	Session::flash('mess','No hay materiales relacionados con la búsqueda');
        	return redirect()->route('material_inactivo_jefe');
        }

    } 
    else{
    	Session::flash('mess','No hay materiales relacionados con la búsqueda');
    	return redirect()->route('material_inactivo_jefe');
    }

}



 //busqueda por area
public function buscar_materialest_inac(Request $request){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

	$bus = $request->get('buscadortipo');
    if($bus != null){
		$mats = Tipo::where( 'tipos.tipo', 'LIKE', '%' . $bus . '%')
		 ->where('materiales.bandera', '=', '0')//mis materiales activos solkamnete
		->join('materiales','tipos.id_tipo','=','materiales.id_tipo')
		->join('areas','materiales.id_area','=','areas.id_area')
		->simplePaginate(10);

		if (count ($mats) > 0 ) {

			return view ( 'jefe.material_inactivo' )->withDetail ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('material_inactivo_jefe');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('material_inactivo_jefe');
	}

}




//busqueda por area
public function buscar_materialesa_inac(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
       return redirect()->back();
      }

	$bus = $request->get('buscadorarea');

if($bus != null){
		$mats = Area::where( 'areas.area', 'LIKE', '%' . $bus . '%')
		 ->where('materiales.bandera', '=', '0')//mis materiales activos solkamnete
		->join('materiales','areas.id_area','=','materiales.id_area')
		->join('tipos','materiales.id_tipo','=','tipos.id_tipo')
		->simplePaginate(10);

		if (count ($mats) > 0 ) {

			return view ( 'jefe.material_inactivo' )->withDetaila ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('material_inactivo_jefe');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('material_inactivo_jefe');
	}

}



     public function adeudos_material_jefe()
    {
        $usuario_actual=\Auth::user();
      if($usuario_actual->tipo_usuario!='jefe'){
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




      
  $adeudos=DB::table('solicitudes')
  ->select('solicitudes.id_solicitud','solicitudes.fecha_solicitud','solicitudes.fecha_prestamo','solicitudes.estado','grupos.grupo','grupos.hora_inicio','grupos.hora_fin','personas.nombre','personas.apellido_paterno','personas.apellido_materno','semestre.nombre_semestre')
  ->join('semestre','solicitudes.id_semestre','=','solicitudes.id_semestre')
  ->join('grupos','solicitudes.id_grupo','=','grupos.id_grupo')
  ->join('areas','solicitudes.id_area','=','areas.id_area')
  ->join('docentes','solicitudes.id_docente','=','docentes.id_docente')
  ->join('personas','docentes.id_persona','=','personas.id_persona')
  ->where([['solicitudes.estado','=','retenido'],['solicitudes.bandera','=','0']])
  ->orderBy('solicitudes.updated_at','DESC')
  ->paginate(8);
      
    return view('jefe.reportes.solicitudes_adeudos_jefe')->with('solicitudes',$adeudos)->with('semestre',$semestre1);
    }



     public function adeudo_solicitud_jefe($id_solicitud)
{
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='jefe'){
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
     ->where([['vales.id_solicitud','=',$solicitud],['vales.estado_vale','=','retenido']])
     ->paginate(10);

  return view('jefe/reportes.solicitud_adeudo_detjefe')->with('detalle',$detalles)->with('grupo',$grupo)
  ->with('fecha_practica',$detalles2)
    ->with('inicio',$detalles3)
      ->with('final',$detalles4);
}











   
}
