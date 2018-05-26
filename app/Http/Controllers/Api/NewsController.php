<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Http\Request;
use App\Transformers\NewsTransformer;

class NewsController extends Controller
{
    //
    
    public function show($news)
    {
      $news = News::where('id',$news)->first();
      //  return $this->response->item($root_obj->rootcixing()->get(), new RootCiXingTransformer())->setStatusCode(201);
      return $this->response->item($news, new NewsTransformer())
          ->setStatusCode(201);

    }


    public function list(){
      $news = News::where('is_enable',1)->Recent()->paginate(5);

      return $this->response->paginator($news, new NewsTransformer());
    }

}
