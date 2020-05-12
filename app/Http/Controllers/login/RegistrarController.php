<?php

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Departamento;
use App\Carrera;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Storage;

class RegistrarController extends Controller
{
    public function registro_estudiante_datos(){
    	$carrera = DB::table('carreras')
	->select('carreras.id_carrera', 'carreras.nombre')
	->get();
      return view ('registrar_estudiante')->with('car',$carrera);
    }

     public function registro_docente_datos(){

  
     		$dpto = DB::table('departamentos')
	->select('departamentos.id_dpto', 'departamentos.departamento')
	->get();
      return view ('registrar_docente')->with('dep',$dpto);
    }
}
