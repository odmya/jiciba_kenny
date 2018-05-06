<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WordTip;

class WordTipController extends Controller
{
    //
    public function praise(Request $request){

$id = $request->id;
      $wordtip = WordTip::find($id);
      $wordtip->praise +=1;
      $wordtip->save();

    return response()->success(array('success' => true,'praise'=>$wordtip->praise));
    }
}
