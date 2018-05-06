<?php

namespace App\Admin\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Rootcixing;
use App\Models\WordSpeech;

use App\Models\Root;
use App\Models\Word;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RootcixingController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Rootcixing::class, function (Grid $grid) {

          $grid->filter(function($filter){

              // 去掉默认的id过滤器
              $filter->disableIdFilter();

              $filter->where(function ($query) {

                  $query->where('root_id', function ($query) {
                    //dd($query);
                      $query->from("roots")->select("id")->where('name',"{$this->input}");
                  });

              }, '查询的词根词缀');

              // 在这里添加字段过滤器
            //  $filter->like('word');
            //  $filter->equal('word_id')->placeholder('请输入查询单词');

          });



            $grid->id('ID')->sortable();

            $grid->root('词根')->display(function ($root) {
          //  dd($root);
            return "<div>{$root['name']}</div>";
            });

            $grid->word_speech('词性')->display(function ($wordspeech) {
          //  dd($wordspeech);
          return "<div>{$wordspeech['cixing']}</div>";
            });

            $grid->description('描述');

/*
            $grid->words()->display(function ($words) {

            $words = array_map(function ($words) {
                return "<span class='label label-success'>{$words['word']}</span>";
            }, $words);

            return join('&nbsp;', $words);
        });
*/


            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Rootcixing::class, function (Form $form) {
          $form->saving(function (Form $form) {
            //...
            //dd($form->rootcixing_word);
          });

          //  $form->display('id', 'ID');
          /*
            $form->display('word_speech_id','词缀词性')->with(function ($id) {
              if($id){
                $wordspeech = WordSpeech::find($id);
                return $wordspeech->cixing;
              }
          });
              */




              //$form->text('id',"词性");
              $form->select('root_id',"词根")->options(function ($id) {

                if($id){
                  $root =  Root::select('roots.id',  DB::raw('roots.name as  text'))
                  ->join('rootcixings', function($leftJoin)
                  {
                      $leftJoin->on('roots.id', '=', 'rootcixings.root_id');
                  })->join('word_speeches', function($leftJoin)
                  {
                      $leftJoin->on('word_speeches.id', '=', 'rootcixings.word_speech_id');
                  })->where('rootcixings.root_id', '=', "$id")->first();
                }else{
                  $root = Root::find($id);
                }

                  if ($root) {

                  //  dd($root->text);
                      return [$root->id => $root->text];
                  }
          })->ajax('/admin/rootqueryapi');

            $form->select('word_speech_id',"词性")->options(WordSpeech::all()->pluck('cixing', 'id'));

            $form->text('description','描述');


              $form->hasMany('rootcixing_word', function (Form\NestedForm $form) {
              //$form->text('id',"词性");
              $form->select('word_id',"单词")->options(function ($id) {

              $word = Word::find($id);

              if ($word) {
                  return [$word->id => $word->word];
              }
          })->ajax('/admin/wordqueryapi');

              $form->text('root_alias',"词根别名")->rules('nullable');

              $form->text('detail',"描叙  ");

              $form->text('explain',"中文解释 ");
              //$form->select('word_speech_id',"词性")->options(WordSpeech::all()->pluck('cixing', 'id'));
              });


          //  $form->display('created_at', 'Created At');
          //  $form->display('updated_at', 'Updated At');
        });
    }

public function rootqueryapi(Request $request){

  $id = $request->get('id');
  $q= $request->get('q');

  if($id){
    return Root::where('id', '=', "$id")->get(['id', 'name as text']);
  }

  if($q){
        //return Word::where('word', '=', "$q")->get(['id', 'word as text']);
        //die("test");

        return Root::select('rootcixings.id',  DB::raw('CONCAT(cixing, name) as  text'))
        ->join('rootcixings', function($leftJoin)
        {
            $leftJoin->on('roots.id', '=', 'rootcixings.root_id');
        })->join('word_speeches', function($leftJoin)
        {
            $leftJoin->on('word_speeches.id', '=', 'rootcixings.word_speech_id');
        })->where('roots.name', 'like', "%$q%")->paginate(null, ['rootcixings.id', 'roots.name as text']);

        //return Root::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);

  }

  return Root::select('roots.id', 'roots.name')
  ->join('rootcixings', function($leftJoin)
  {
      $leftJoin->on('roots.id', '=', 'rootcixings.id');
  })->where('roots.name', 'like', "%$q%")->paginate(null, ['rootcixings.id', 'name as text']);

//  return Root::where('name', 'like', "%$q%")->join('rootcixings', 'rootcixings.root_id', '=', 'id')->paginate(null, ['rootcixings.id', 'name as text']);

//  return Root::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);

}

    public function wordqueryapi(Request $request)
      {

          $id = $request->get('id');
          $q= $request->get('q');

          if($id){
            return Word::where('id', '=', "$id")->get(['id', 'word as text']);
          }

          if($q){
                //return Word::where('word', '=', "$q")->get(['id', 'word as text']);
                return Word::where('Word', 'like', "$q")->paginate(null, ['id', 'word as text']);
          }

          return Word::where('Word', 'like', "%$q%")->paginate(null, ['id', 'word as text']);

        //  return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
          //return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
      }

}
