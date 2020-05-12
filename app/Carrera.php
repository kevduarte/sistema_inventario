<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
     Protected $table = 'carreras';
     protected $primaryKey = 'id_carrera'; 
    // public $incrementing = false;
     protected $fillable = ['id_carrera','nombre'];
}
