<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_grupo extends Model
{
    protected $table = 'detalle_grupos';
 // protected $primaryKey = 'id_detalle_grupo'; // or null
 //public $incrementing = false;
 protected $fillable = [
      'num_control','nom_grupo','estado', 'semestre'
 ];
}
