<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
     Protected $table = 'tipos';
     protected $primaryKey = 'id_tipo'; 
     public $incrementing = false;
     protected $fillable = ['id_tipo','tipo'];
}
