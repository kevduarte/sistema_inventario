<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
     Protected $table = 'personal';
     protected $primaryKey = 'id_personal'; 
    //public $incrementing = false;
     protected $fillable = ['id_personal','cargo','nivel','estado','id_persona','id_area'];
}
