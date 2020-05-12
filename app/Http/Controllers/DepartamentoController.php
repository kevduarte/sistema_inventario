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

class DepartamentoController extends Controller
{
    //mostrar la pag. principal del admin
  public function home(Request $request){
   $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='uno'){
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

return view('dpto.home_dpto')
->with('mate',$mat)
->with('mat',$totalm)
->with('per',$totalp)
->with('doc',$totald)
->with('est',$totale);
	}


 //home del admin con la busqueda.
	public function buscar_material_home(Request $request){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
          
				return view ( 'dpto.home_dpto' )
				->withInfo ($mats)
        ->withQuery ($bus)
        ->with('mat',$totalm)
				->with('per',$totalp)
				->with('doc',$totald)
				->with('est',$totale);

			}else{
				Session::flash('mess','No hay materiales registrados que coincidan con la búsqueda');
				return redirect()->route('departamento')->with('mat',$totalm)
        ->with('per',$totalp)
        ->with('doc',$totald)
        ->with('est',$totale);
			}
		}else{
			Session::flash('mess','Material no encontrado');
			return redirect()->route('departamento') ->with('mat',$totalm)
        ->with('per',$totalp)
        ->with('doc',$totald)
        ->with('est',$totale);
			//return redirect()->route('busqueda_material');
		}
	}




      //registro de tipos de materiales.
public function registro_tipo_dpto(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }

  $tipo = DB::table('tipos')
  ->select('tipos.id_tipo','tipos.tipo')

  ->Paginate(8);

  return view('dpto.registro_tiposd')->with('tipos',$tipo);
}

public function registrar_tiposdpto(Request $request)
{ 
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
  return redirect()->route('registro_tipo_dpto');
}


	    //actualizar materiales
	public function actualiza_material($id_material){
		
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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

		return view("dpto.actualizar_insumo")->with('material', $mater)->with('uni', $unidades)->with('med', $medida);

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

		return view("dpto.actualizar_material")->with('material', $mater)->with('uni', $unidades); 
	}





//registro de materiales nuevos.
public function registro_material(){
 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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

	return view('dpto.registro_material')
	->with('areas_disponibles', $id_de_areas)->with('tipos_disponibles',$id_de_tipos);

}


  // ver unidades
	public function ver_unidad($id_material){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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

        


      	


		return view("dpto.ver_insumos")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont);

      }

    

		
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




		 return view("dpto.ver_unidades")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont);
}

protected function desactivar_unidad($codigo_unidad){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }
		$data = $codigo_unidad;
		$unid = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.num_serie','unidades.bandera','unidades.estado','materiales.nombre_material','materiales.id_material')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		->where('unidades.codigo_unidad', '=', $data)
		->take(1)
		->first();

		return view("dpto.desactivar_unidad")->with('unidad', $unid); 
	}



    public function baja_unidad(Request $request){
    	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
    return redirect()->route('ver_temporales', ['id_material' => $id_material]);
 }



     public function ver_temporales($id_material){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }

      $data = $id_material;
		
		$mater = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.estado','unidades.num_serie','materiales.nombre_material','materiales.id_material','unidades.medida','unidades.updated_at')
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




		 return view("dpto/reportes.ver_temporales")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont);
}



    public function ver_eliminados($id_material){
		 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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




		 return view("dpto/reportes.ver_eliminados")->with('veruni', $mater)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont);
}




    public function reporte_eliminar(){
    
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }


      $material=DB::table('materiales')
      ->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.clave','materiales.modelo')
      ->join('unidades','unidades.id_material','=','materiales.id_material')
      ->where([['unidades.estado', '=', 'eliminado'],['materiales.bandera','=','1']])
      ->orderBy('materiales.updated_at', 'DESC')
      ->distinct()
	  ->simplePaginate(6);

      return view('dpto/reportes.reporte_eliminados')->with('activo', $material);

    }




public function reporte_temporales(){
    
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }
      	


      $material=DB::table('materiales')
      ->select('materiales.id_material','materiales.nombre_material','materiales.marca','materiales.clave','materiales.modelo')
      ->join('unidades','unidades.id_material','=','materiales.id_material')
       ->where([['unidades.bandera', '=', '0'],['materiales.bandera','=','1']])
      ->orderBy('materiales.updated_at', 'DESC')
      ->distinct()
	  ->simplePaginate(6);

      return view('dpto/reportes.reporte_temporal')->with('activo', $material);

    }



 protected function activar_unidad($codigo_unidad){
 	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }
		$data = $codigo_unidad;
		$unid = DB::table('unidades')
		->select('unidades.id_unidad','unidades.codigo_unidad','unidades.bandera','unidades.estado','materiales.nombre_material','materiales.id_material')
		->join('materiales','materiales.id_material','=','unidades.id_material')
		
		->where('unidades.codigo_unidad', '=', $data)
		->take(1)
		->first();

		return view("dpto.baja_unidad_definitiva")->with('unidad', $unid); 
	}




	public function baja_definitiva_unidad(Request $request){
    	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
      return redirect()->route('ver_eliminados', ['id_material' => $id_material]);
 }



//busqueda por nombre
public function buscar_materiales(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
        	return view ( 'dpto.busqueda_material' )->withDetails ($mats )->withQuery ($bus);
        }else{
        	Session::flash('mess','No hay materiales relacionados con la búsqueda');
        	return redirect()->route('materiales_activos');
        }

    } 
    else{
    	Session::flash('mess','No hay materiales relacionados con la búsqueda');
    	return redirect()->route('materiales_activos');
    }

}



	//vista para buscar los materiales activos
public function busqueda_material(){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }
      $est = DB::table('materiales')
      ->select('materiales.id_material', 'materiales.nombre_material','materiales.clave','materiales.modelo','materiales.marca','materiales.updated_at', 'areas.area', 'tipos.tipo')
      ->join('areas', 'materiales.id_area', '=', 'areas.id_area')
      ->join('tipos', 'materiales.id_tipo', '=', 'tipos.id_tipo')
      ->where('materiales.bandera', '=', '1')
      ->orderBy('materiales.updated_at', 'DESC')
      ->simplePaginate(10);



      return view('dpto.busqueda_material')->with('activo', $est);

      //return view('admin.busqueda_material');
}



    //busqueda por area
public function buscar_materialest(Request $request){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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

			return view ( 'dpto.busqueda_material' )->withDetail ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('materiales_activos');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('materiales_activos');
	}

}



 //busqueda por area
public function buscar_materialesa(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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

			return view ( 'dpto.busqueda_material' )->withDetaila ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('materiales_activos');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('materiales_activos');
	}

}

  //detalles material
	public function detalles_material($id_material){
		  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
         $name=$name->nombre_material;

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


		return view("dpto.detalles_insumo")->with('nombre', $nombre)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
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


		return view("dpto.detalles_material")->with('nombre', $nombre)->with('ver', $data)->with('nombre', $name)->with('num',$contar)
		 ->with('disponible',$conta)->with('no',$cont)->with('area',$area)->with('tipo',$tipo); 
	}


	protected function desactivar_material($id_material){
	$usuario_actual=\Auth::user();
	if($usuario_actual->tipo_usuario!='uno'){
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
		return redirect()->route('material_inactivo');
	}

	Session::flash('mess','¡El material no se puede desactivar hay unidades en uso!');
	return redirect()->back();
}



	protected function activar_material($id_material){
		 $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='uno'){
       return redirect()->back();
      }
		$activado=$id_material;
		DB::table('materiales')
		->where('materiales.id_material', $activado)
		->update(
			['bandera' => '1']);
		Session::flash('message','¡Material Activado!');
		return redirect()->route('materiales_activos');
	}



public function material_inactivo(){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }

	 $est = DB::table('materiales')
     ->select('materiales.id_material', 'materiales.nombre_material','materiales.clave','materiales.modelo', 'materiales.marca','materiales.updated_at', 'areas.area', 'tipos.tipo')
        ->join('areas', 'materiales.id_area', '=', 'areas.id_area')
        ->join('tipos', 'materiales.id_tipo', '=', 'tipos.id_tipo')
        ->where('materiales.bandera', '=', '0')

         ->orderBy('materiales.updated_at', 'DESC')
        ->simplePaginate(10);



        return view('dpto.material_inactivo')->with('inactivo', $est);


	
}



//busqueda por nombre
public function buscar_materiales_inac(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
        	return view ( 'dpto.material_inactivo' )->withDetails ($mats )->withQuery ($bus);
        }else{
        	Session::flash('mess','No hay materiales relacionados con la búsqueda');
        	return redirect()->route('material_inactivo');
        }

    } 
    else{
    	Session::flash('mess','No hay materiales relacionados con la búsqueda');
    	return redirect()->route('material_inactivo');
    }

}




 //busqueda por area
public function buscar_materialest_inac(Request $request){
	  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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

			return view ( 'dpto.material_inactivo' )->withDetail ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('material_inactivo');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('material_inactivo');
	}

}



//busqueda por area
public function buscar_materialesa_inac(Request $request){
	 $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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

			return view ( 'dpto.material_inactivo' )->withDetaila ($mats )->withQuery ($bus);
		}else{
			Session::flash('mess','No hay materiales relacionados con la búsqueda');
			return redirect()->route('material_inactivo');
		}
	} else{
		Session::flash('mess','No hay materiales relacionados con la búsqueda');
		return redirect()->route('material_inactivo');
	}

}


    //semestre
  public function nuevo_semestre(){
  $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }

    $semestre = DB::table('semestre')
    ->select('semestre.nombre_semestre','semestre.inicio_semestre', 'semestre.final_semestre', 'semestre.estatus_semestre')
    //->where('semestre.estatus_semestre','=','actual')
    ->orderBy('semestre.estatus_semestre', 'asc')
    ->simplePaginate(5);
    return view('dpto.nuevo_semestre')->with('lista', $semestre);
  }


    public function agregar_semestre(Request $request){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }
    $data = $request;
    $semestre = DB::table('semestre')
    ->select('semestre.id_semestre', 'semestre.final_semestre')
    ->where('semestre.estatus_semestre', '=',  'actual')
    ->take(1)
    ->first();


    if(empty($semestre->id_semestre)){
      $semestre=new Semestre;
      $semestre->inicio_semestre=$data['inicio'];
      $semestre->final_semestre=$data['final'];
      $semestre->estatus_semestre='actual';
      $semestre->nombre_semestre=$data['nombre'];
      $semestre->save();

      Session::flash('message','¡Nuevo semestre registrado!');
      return redirect()->route('nuevo_semestre');
    }
    else{
      $buscar_semestre = DB::table('semestre')
      ->select('semestre.id_semestre', 'semestre.final_semestre')
      ->where('semestre.estatus_semestre', '=',  'actual')
      ->take(1)
      ->first();
      DB::table('semestre')
      ->where('semestre.id_semestre', $buscar_semestre->id_semestre)
      ->update(['estatus_semestre' => 'anterior']);

      $semestre=new Semestre;
      $semestre->inicio_semestre=$data['inicio'];
      $semestre->final_semestre=$data['final'];
      $semestre->estatus_semestre='actual';
      $semestre->nombre_semestre=$data['nombre'];
      $semestre->save();

      Session::flash('message','Nuevo semestre registrado');
      return redirect()->route('nuevo_semestre');
    }

  }



//registrar persona con areas
public function registro_personal(){
 $usuario_actual=\Auth::user();
 if($usuario_actual->tipo_usuario!='uno'){
   return redirect()->back();
 }
  return view('dpto.registro_personal');
}

public function registrar_personal(Request $request){
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
    return redirect()->route('personal_registrado_dpto');

  }

    //personal
public function personal_registrado(){
 $usuario_actual=\Auth::user();
 if($usuario_actual->tipo_usuario!='uno'){
   return redirect()->back();
 }
 $personal=DB::table('personas')
 ->select('personas.id_persona','personas.nombre','personas.apellido_paterno','personas.apellido_materno','personas.rfc','personas.email','personas.telefono')
 ->where([['personas.bandera','=','1'],['personas.nivel','=','1']])
 
 ->orderBy('personas.updated_at', 'DESC')
 ->paginate(10);
  return view('dpto.personal_registrado')->with('personal',$personal);
}


protected function actualizar_personas($id_persona){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }
    $datos=$id_persona;

    $per=DB::table('personas')
    ->select('personas.id_persona','personas.nombre','personas.apellido_paterno','personas.apellido_materno','personas.rfc','personas.telefono','personas.email')
    ->where('personas.id_persona',$datos)
    ->take(1)
    ->first();
    
    return view('dpto.actualizar_datos')->with('datos',$per);
  }


  public function actualizar_personas_datos(Request $request){
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
return redirect()->route('personal_registrado_dpto');

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
return redirect()->route('personal_registrado_dpto');

}




 public function alta_personal(){
   $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='uno'){
     return redirect()->back();
   }

      $id=$usuario_actual->id_persona;

      $result = DB::table('personas')
      ->select('personas.id_persona', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->where([['personas.bandera','=','1'],['personas.nivel','=','1'],['personas.id_persona','!=',$id]])
       ->orderBy('personas.nombre', 'asc')
      ->get();

      $cuatro=4;

      $cargo=DB::table('tipo_user')
      ->select('tipo_user.id','tipo_user.tipo')
      ->where('tipo_user.id','!=',$cuatro)
      ->get();

      $area=DB::table('areas')
      ->select('areas.id_area','areas.area')
      ->where('areas.area','!=','laboratorio')
      ->get();

    
    return view('dpto.alta_personal')->with('alta', $result)->with('tipo', $cargo)->with('area', $area);
    }



public function alta_personal_nueva(Request $request){
   $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
        return redirect()->route('docente_activo_dpto');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->route('docente_activo_dpto');
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
        return redirect()->route('encargado_activo_dpto');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->route('encargado_activo_dpto');
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
        return redirect()->route('jefe_lab_dpto');

      }else{
        Session::flash('message',' no encontrado');
        return redirect()->route('jefe_lab_dpto');
      }
    }






  }
    


  }





    //persdonal del lab activo e inactivo del laboratorio
  public function jefe_lab(){
    $usuario_actual=\Auth::user();
    if($usuario_actual->tipo_usuario!='uno'){
     return redirect()->back();
   }

     $activo = DB::table('users')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user','users.username','personal.estado')
   ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
   ->join('personal', 'users.id_personal', '=', 'personal.id_personal')
   ->where('users.tipo_usuario', '=', 'jefe')
   ->orderBy('personal.estado', 'asc')
   ->paginate(8);


   return view('dpto.jefe_laboratorio')->with('personal', $activo);
  }


  protected function desactivar_jefelab($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
    return redirect()->route('jefe_lab_dpto');
  }



  protected function activar_jefelab($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
    return redirect()->route('jefe_lab_dpto');
  }




   protected function restablecimiento_pass($id_user){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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












//docente del lab activo e inactivo
  public function docente_activo(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }

      $activo = DB::table('users')
    ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.username')
    ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
    ->join('docentes', 'users.id_docente', '=', 'docentes.id_docente')
    ->where([['users.bandera', '=', '1'],['users.tipo_usuario','=','docente']])
    ->orderBy('personas.nombre', 'asc')
    ->simplePaginate(8);

    return view('dpto.docente_activo')->with('docente',$activo);
  }

  protected function desactivar_docente($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
       return redirect()->route('docente_inactivo_dpto');


     }else
     {
       Session::flash('mess','ERROR,¡El docente tiene grupos asignados durante este semestre!');
       return redirect()->back();

     }
   }

   public function docente_inactivo(){
      $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }
        $inactivo = DB::table('users')
    ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.username')
    ->join('personas', 'users.id_persona', '=', 'personas.id_persona')
    ->join('docentes', 'users.id_docente', '=', 'docentes.id_docente')
    ->where([['users.bandera', '=', '0'],['users.tipo_usuario','=','docente']])
    ->orderBy('personas.nombre', 'asc')
    ->simplePaginate(8);


    return view('dpto.docente_inactivo')->with('docente',$inactivo);

  }

protected function activar_docente($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
       return redirect()->back();
      }

       $contra= "laboratorio2020";
  $user_password= Hash::make($contra);

    $activado=$id_user;
    DB::table('users')
    ->where('users.id_user', $activado)
    ->update(['bandera' => '1','password' => $user_password]);
    Session::flash('message','¡Docente Activado con éxito, la contraseña asignada es: laboratorio2020!');
    return redirect()->route('docente_activo_dpto');
  }



    //persdonal del lab activo e inactivo del laboratorio
  public function encargado_activo(){
    $usuario_actual=\Auth::user();
    if($usuario_actual->tipo_usuario!='uno'){
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

   return view('dpto.encargado_activo')->with('personal', $activo);
  }

protected function desactivar_encargado($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
    return redirect()->route('encargado_inactivo_dpto');
  }

  public function encargado_inactivo(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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


    return view('dpto.encargado_inactivo')->with('personal', $inactivo);
  }

    protected function activar_encargado($id_user){
     $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='uno'){
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
    return redirect()->route('encargado_activo_dpto');
  }









}
