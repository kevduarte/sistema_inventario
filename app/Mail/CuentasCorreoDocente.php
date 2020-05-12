<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CuentasCorreoDocente extends Mailable
{
    use Queueable, SerializesModels;

    public $datos_correo;
    public $data;
    public $datos_cuenta;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos_correo, $data, $datos_cuenta)
   {
       $this->datos_correo = $datos_correo;
       $this->data= $data;
       $this->datos_cuenta = $datos_cuenta;
       
   }
    public function build()
    {
        return $this->view('mails.mensaje_aprobacion');
    }
}
