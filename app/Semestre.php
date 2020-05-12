<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    Protected $table = 'semestre';
     protected $primaryKey = 'id_semestre'; 
    //public $incrementing = false;
     protected $fillable = ['id_semestre','inicio_semestre','nombre_semestre','final_semestre','estatus_semestre'];
}

