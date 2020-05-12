<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_brigada extends Model
{
     protected $table = 'detalle_brigadas';
 // protected $primaryKey = 'id_detalle_grupo'; // or null
 //public $incrementing = false;
 protected $fillable = [
      'num_control','id_brigada','cargo', 'id_semestre'
 ];
}
