<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
     protected $table = 'notificaciones';

       protected $fillable = ['email','asunto', 'mensaje','estatus'];
}
