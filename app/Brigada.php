<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brigada extends Model
{
      Protected $table = 'brigadas';
     protected $primaryKey = 'id_brigada'; 
     //public $incrementing = false;
     protected $fillable = ['id_brigada','nombre_brigada','cupo_brigada'];
}
