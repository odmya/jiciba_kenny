<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Record;
use App\Models\Userrecord;
use Redirect;
use Auth;


class RecordController extends Controller
{
    //

    public function __construct()
      {
          $this->middleware('auth');

      }

      public function index()
      {
        if(Auth::user()->is_admin){
          $records = Userrecord::orderBy('created_at', 'desc')
                             ->paginate(30);
          return view('record.index', compact('records'));
        }else{
          return redirect('login');
        }


      }

}
