<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
   Protected $table = 'departamentos';
     protected $primaryKey = 'id_dpto'; 
    // public $incrementing = false;
     protected $fillable = ['id_dpto','departamento'];
}
