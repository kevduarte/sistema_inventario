<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matcarro extends Model
{
    Protected $table = 'matcarro';
	//protected $primaryKey = 'id_material'; 
	//public $incrementing = false;
	protected $fillable = ['id_matcarro','id_material','nombre_material','clave','modelo','marca','descripcion','area','tipo','id_semestre','bandera','n_unidades'];

}
