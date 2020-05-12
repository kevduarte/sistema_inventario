<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
     Protected $table = 'estudiantes';
     protected $primaryKey = 'num_control'; 
    public $incrementing = false;
     protected $fillable = ['num_control','semestre_cursando','cargo','id_persona','id_semestre','id_persona'];
}
