<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Contracts\Support\MessageProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse as BaseRedirectResponse;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
   public function __construct(Guard $auth)
       {
           $this->auth = $auth;
           //$this->middleware('guest', ['except' => 'getLogout']);

       }
  
  public function username()
    {
        return 'username';
    }
  
  public function postLogin(Request $request)
     {
      $this->validate($request, [
          'username' => 'required',
          'password' => 'required',
      ]);
      $credentials = $request->only('username', 'password');
      if ($this->auth->attempt($credentials, $request->has('remember')))
 {;
   if(Auth::user()->tipo_usuario == 'admin' &&  Auth::user()->bandera == '1'){
     
  
   Session::flash('message','Bienvenido administrador');
       return redirect()->route('admin');
   }
    if(Auth::user()->tipo_usuario == 'uno' &&  Auth::user()->bandera == '1'){
     
   Session::flash('message','Bienvenido jefe de departamento de ciencias de la tierra');
       return redirect()->route('departamento');
   }
   if(Auth::user()->tipo_usuario == 'jefe' &&  Auth::user()->bandera == '1'){
     
  
   Session::flash('message','Bienvenido jefe de laboratorio de ing. civil');
       return redirect()->route('jefe');
   }
   if(Auth::user()->tipo_usuario == 'area' &&  Auth::user()->bandera == '1'){
     
   
   Session::flash('message','Inicio de sesión correctamente');
       return redirect()->route('personal');
   }
   if(Auth::user()->tipo_usuario == 'docente' &&  Auth::user()->bandera == '1'){
     
  
   Session::flash('message','Inicio de sesión correctamente');
       return redirect()->route('docente');
   }
   if(Auth::user()->tipo_usuario == 'estudiante' &&  Auth::user()->bandera == '1'){
     
   
   Session::flash('message','Inicio de sesión correctamente');
       return redirect()->route('estudiante');
   }
 }
   else {
     $this->guard()->logout();
    $request->session()->invalidate();
   //return $this->loggedOut($request) ?: redirect('estudiante')->with('error', 'Usuario Incorrecto, ¡Favor de Verificar Datos!');
Session::flash('messa','Usuario o contraseña invalido, verifique sus datos'); 
 return $this->loggedOut($request) ?:  redirect()->back();
 }
}

 public function getLogout(Request $request)
{
  Auth::logout();
//  $this->guard()->logout();
 $request->session()->invalidate();
Session::flash('message','Cierre de sesión correcto'); 
  //return redirect()->route('welcome');
 return $this->loggedOut($request) ?:  redirect()->back();
}

}