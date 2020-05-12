<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
     Protected $table = 'docentes';
     protected $primaryKey = 'id_docente'; 
    //public $incrementing = false;
     protected $fillable = ['id_docente','id_persona'];
}
