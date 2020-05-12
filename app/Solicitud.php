<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    Protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud'; 
    public $incrementing = false;
    protected $fillable = ['id_solicitud','fecha_solicitud','id_docente','fecha_prestamo','hora_inicio_sol','hora_fin_sol','id_grupo','id_prestamo','numeral','id_semestre','id_area','estado','bandera'];
}
