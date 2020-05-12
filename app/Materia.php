<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{

	Protected $table = 'materias';
     protected $primaryKey = 'id_materia'; 
     //public $incrementing = false;
     protected $fillable = ['id_materia','materia'];
    //
}
