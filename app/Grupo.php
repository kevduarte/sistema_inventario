<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
     Protected $table = 'grupos';
     protected $primaryKey = 'id_grupo'; 
    // public $incrementing = false;
     protected $fillable = ['grupo','cupo','id_materia','hora_inicio','hora_fin','clave','dia_uno','dia_dos','dia_tres','dia_cuatro','dia_cinco'];
}
