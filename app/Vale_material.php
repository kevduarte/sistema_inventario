<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vale_material extends Model
{
     protected $table = 'vale_material';
     //protected $primaryKey = 'id_vale'; // or null
    //public $incrementing = false;
    protected $fillable = [
        'id_material','id_vale','estado_vm','observaciones'];
}
