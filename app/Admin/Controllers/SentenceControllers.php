<?php

namespace App\Admin\Controllers;
use Illuminate\Http\Request;
use App\Models\Sentence;
use App\Models\Word;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SentenceControllers extends Controller
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
        return Admin::grid(Sentence::class, function (Grid $grid) {


          $grid->filter(function($filter){

              // 去掉默认的id过滤器
              $filter->disableIdFilter();

              // 在这里添加字段过滤器
            //  $filter->like('word');
              $filter->like('english')->placeholder('请输入查询的例句');

          });

            $grid->id('ID')->sortable();
            $grid->english('english');
            $grid->chinese('chinese');
            $grid->voice_path('voice_path');
            $grid->quote('quote');

            $grid->words()->display(function ($words) {

             $words = array_map(function ($word) {
                 return "<span class='label label-success'>{$word['word']}</span>";
             }, $words);

             return join('&nbsp;', $words);
         });


          //  $grid->created_at();
          //  $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Sentence::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('english');
            $form->text('chinese');
            $form->file('voice_path')->uniqueName()->move('voice/sentence');
            $form->text('quote');

            //多对多选择
            $form->multipleSelect('words')->options(function ($ids) {
              if(count($ids)){
                $word = Word::whereIn('id',$ids);

               return $word->pluck('word', 'id');
              }

        })->ajax('/admin/wordqueryapi');



            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function sentencequeryapi(Request $request)
      {

          $id = $request->get('id');
          $q= $request->get('q');

          if($id){
            return Sentence::where('id', '=', "$id")->get(['id', 'english as text']);
          }

          if($q){
                //return Word::where('word', '=', "$q")->get(['id', 'word as text']);
                return Sentence::where('english', 'like', "%$q%")->paginate(null, ['id', 'english as text']);
          }

          return Sentence::where('english', 'like', "%$q%")->paginate(null, ['id', 'english as text']);

        //  return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
          //return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
      }
}
