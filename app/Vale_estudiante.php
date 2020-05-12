<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vale_estudiante extends Model
{

	 protected $table = 'vale_estudiante';
     //protected $primaryKey = 'id_vale'; // or null
    //public $incrementing = false;
    protected $fillable = [
        'num_control','id_vale','estado_ve','observaciones'];
    //
}
