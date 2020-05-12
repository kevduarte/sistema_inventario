<?php

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;



use Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;

class LoginUsuariosController extends Controller
{
    public function postLogin(Request $request)
        {
            
            Session::flash('message','Bienvenido Admin/ENCARGADO');
        	return redirect()->route('admin');
       
  }
}
