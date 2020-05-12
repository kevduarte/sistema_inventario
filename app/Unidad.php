<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
     Protected $table = 'unidades';
     protected $primaryKey = 'id_unidad'; 
    public $incrementing = false;
     protected $fillable = ['id_unidad','id_material','num_serie'];
}
