<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Novel;
use App\Models\NovelChapter;


class NovelController extends Controller
{
    //
    public function list(Request $request, Novel $novel){
      $novels = $novel->paginate(20);
      return view('novel.list', compact('novels'));
    }

    public function show(Novel $novel)
    {
      // code...

      return view('novel.show', compact('novel'));

    }

    public  function chapter(Novel $novel)
    {
      // code...
      $chapters = $novel->novel_chapter()->paginate(1);
      return view('angular.novel.chapter', compact('chapters'));
    }
}
