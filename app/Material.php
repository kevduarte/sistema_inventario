<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
	Protected $table = 'materiales';
	protected $primaryKey = 'id_material'; 
	public $incrementing = false;
	protected $fillable = ['id_material','nombre_material','clave','modelo','marca','descripcion','id_area','id_tipo','id_semestre','bandera','n_unidades'];
}
