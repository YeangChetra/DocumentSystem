<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    //
    public function toogle(Request $require)
    {
      $toogle = $require->input('toogle');
      //dd($toogle);
      if (Session::has('toogled')) {
        Session::remove('toogled');
      } else {
        Session::put('toogled', $toogle);
      }
    }
}
