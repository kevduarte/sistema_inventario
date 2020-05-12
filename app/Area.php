<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
     Protected $table = 'areas';
     protected $primaryKey = 'id_area'; 
     public $incrementing = false;
     protected $fillable = ['id_area','area'];
}
