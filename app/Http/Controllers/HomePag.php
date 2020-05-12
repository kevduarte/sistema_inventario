<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePag extends Controller
{

	public function homepage(){
      return view ('welcome');
    }
}
