<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Texto extends Model
{
     Protected $table = 'textos';
     protected $primaryKey = 'id_texto'; 
     protected $fillable = ['id_texto','frase_cabecera','lema_uno','lema_dos','telefono','pagina'];
}
