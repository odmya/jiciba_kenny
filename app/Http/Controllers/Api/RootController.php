<?php

namespace App\Http\Controllers\Api;

use App\Models\Word;
use App\Models\Root;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RootRequest;
use App\Transformers\RootCigenTransformer;
use App\Transformers\RootTransformer;

class RootController extends Controller
{
    //
    public function show($root)
    {

      $root_obj =Root::where('id',$root)->first();

    //  return $this->response->item($root_obj->rootcixing()->get(), new RootCiXingTransformer())->setStatusCode(201);
      return $this->response->item($root_obj, new RootCigenTransformer())
          ->setStatusCode(201);

    }


    public function list($roottype){
      $cigen = Root::where('types',$roottype)->get();
      
      return $this->response->item($cigen, new RootCigenTransformer())
          ->setStatusCode(201);
    }

}
