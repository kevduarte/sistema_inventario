<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    Protected $table = 'cuentas';
     protected $primaryKey = 'id_cuenta'; 
    //public $incrementing = false;
     protected $fillable = ['id_cuenta','departamento','nombre','apellido_paterno','apellido_materno','curp','email'];
}
