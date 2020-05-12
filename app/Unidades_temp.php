<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidades_temp extends Model
{
     Protected $table = 'unidades_temp';
     protected $primaryKey = 'id_unidad'; 
    public $incrementing = false;
     protected $fillable = ['id_unidad','id_material'];

 }
