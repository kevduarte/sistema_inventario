<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona'; 
    public $incrementing = false;
    protected $fillable = ['nombre','apellido_paterno','apellido_materno','rfc','telefono','email','nivel'];
}
