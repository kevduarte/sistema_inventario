<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_user extends Model
{
     Protected $table = 'tipo_user';
     protected $primaryKey = 'id'; 
     //public $incrementing = false;
     protected $fillable = ['id','tipo'];
}
