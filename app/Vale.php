<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vale extends Model
{
     protected $table = 'vales';
     protected $primaryKey = 'id_vale'; // or null
    //public $incrementing = false;
    protected $fillable = [
        'id_vale','id_solicitud','id_personal','id_brigada','id_area', 'fecha_prestamo_vale','hora_inicio_vale','hora_fin_vale','estado_vale', 'observaciones'
    ];
}
