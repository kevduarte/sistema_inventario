<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    Protected $table = 'prestamos';
     protected $primaryKey = 'id_prestamo'; 
    //public $incrementing = false;
     protected $fillable = ['id_prestamo','tipo_prestamo'];
}
