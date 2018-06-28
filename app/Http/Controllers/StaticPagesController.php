<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelBase;

class StaticPagesController extends Controller
{
    //
    public function home()
      {

        $level_bases = LevelBase::get();

        return view('static_pages/home',compact('level_bases'));
      }

    public function help()
      {
          return view('static_pages/help');
      }

    public function about()
      {
          return view('static_pages/about');
      }

}
