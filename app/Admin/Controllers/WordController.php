<?php

namespace App\Admin\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Word;
use App\Models\Root;
use App\Models\LevelBase;
use App\Models\WordExplain;
use App\Models\WordSpeech;
use App\Models\WordVoice;
use App\Models\Sentence;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WordController extends Controller
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
        return Admin::grid(Word::class, function (Grid $grid) {

          $grid->actions(function ($actions) {
           $actions->disableDelete(); //禁止删除
           //$actions->disableEdit();
        });

          $grid->filter(function($filter){

              // 去掉默认的id过滤器
              $filter->disableIdFilter();

              // 在这里添加字段过滤器
            //  $filter->like('word');
              $filter->equal('word')->placeholder('请输入查询单词');

          });



            $grid->id('ID')->sortable();
            $grid->word('单词');
            $grid->word_voice('发音')->display(function ($voices) {
              $tmp_voice ="";
              if(count($voices)){
                foreach($voices as $voice){
                  $tmp_voice .=$voice['symbol'];
                }

              }
              return "<div>{$tmp_voice}</div>";
            });


            $grid->level_base()->display(function ($levels) {

             $levels = array_map(function ($level) {
                 return "<span class='label label-success'>{$level['level_bases']}</span>";
             }, $levels);

             return join('&nbsp;', $levels);
         });


            $grid->level_star('星级')->sortable();
            $grid->word_explain('解释')->display(function ($explains) {

              $explain_array = array();
              $tmp_array =array();
              if(count($explains)){
                foreach ($explains as $word_explain) {
                  if(WordSpeech::find($word_explain['word_speech_id'])){
                    $explain_array[] = WordSpeech::find($word_explain['word_speech_id'])->cixing.". ".$word_explain['explain'];
                  }else{
                    $explain_array[] = $word_explain['explain'];
                  }

                //  echo WordSpeech::find(10)->first()->cixing."<br/>";
                  //echo $word_explain->word_speech_id."<br/>";

              }

              if(count($explain_array)){
             $explain_tmp=implode(", ",$explain_array);

              //dd($explain_array);
              return "<span class='label label-warning' title='{$explain_tmp}'>解释</span>";
              }

            }else{
              return "<span class='label' >暂无</span>";
            }



    });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Word::class, function (Form $form) {

            //$form->display('id', 'ID');


            $form->tab('基本信息', function ($form) {

              //$form->text('word', '单词')->rules('unique:words');
              $form->text('word', '单词');
              $form->display('level_star', '星级');


            })->tab('解释', function ($form) {

              $form->hasMany('word_explain', function (Form\NestedForm $form) {
              $form->text('explain',"释义");

              //$form->select('word_speech_id')->options('/admin/cixinglist');

              //$form->radio('word_speech_id')->options('/admin/cixinglist');

              $form->select('word_speech_id',"词性")->options(WordSpeech::all()->pluck('cixing', 'id'));





              });

            })->tab('分级归类', function ($form) {

              $form->multipleSelect('level_base')->options(function ($ids) {
                if(count($ids)){
                  $word = LevelBase::whereIn('id',$ids);

                 return $word->pluck('level_bases', 'id');
                }

          })->ajax('/admin/levelbasesapi');


            })->tab('音标', function ($form) {

              $form->hasMany('word_voice', function (Form\NestedForm $form) {
              $form->text('symbol',"音标");

              $form->file('path',"mp3文件")->uniqueName()->move('voice/word');
              });


            })->tab('图片', function ($form) {

                $form->hasMany('word_image', function (Form\NestedForm $form) {
                $form->image('image',"图片")->uniqueName()->move('images/words');
                });


            })->tab('Tips', function ($form) {

                $form->hasMany('word_tip', function (Form\NestedForm $form) {
                $form->text('tip',"TIP");
                });
              })->tab('例句', function ($form) {

                        $form->multipleSelect('sentences','例句')->options(function ($ids) {
                          if(count($ids)){
                            $sentence = Sentence::whereIn('id',$ids);

                           return $sentence->pluck('english', 'id');
                         }
                    })->ajax('/admin/sentencequeryapi');

                })->tab('词缀', function ($form) {

                  $form->hasMany('rootcixing_word', function (Form\NestedForm $form) {
                      $form->text('detail',"词根说明");

                      $form->text('root_alias',"词根别名")->rules('nullable');
                      $form->text('explain',"中文解释 ")->rules('nullable');
                            $form->select('rootcixing_id',"词根")->options(function ($id) {

                          if($id){
                            $root =  Root::select('rootcixings.id',  DB::raw('CONCAT(cixing, name) as  text'))
                            ->join('rootcixings', function($leftJoin)
                            {
                                $leftJoin->on('roots.id', '=', 'rootcixings.root_id');
                            })->join('word_speeches', function($leftJoin)
                            {
                                $leftJoin->on('word_speeches.id', '=', 'rootcixings.word_speech_id');
                            })->where('rootcixings.id', '=', "$id")->first();
                          }else{
                            $root = Root::find($id);
                          }

                            if ($root) {

                            //  dd($root->text);
                                return [$root->id => $root->text];
                            }
                        })->ajax('/admin/rootqueryapi');

                  });
                });


              });
            //$form->text('word_explain.explain');


}
}
