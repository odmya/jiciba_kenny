<?php

namespace App\Admin\Controllers;

use App\Models\WordVoice;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WordVoiceController extends Controller
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
        return Admin::grid(WordVoice::class, function (Grid $grid) {


          $grid->filter(function($filter){

              // 去掉默认的id过滤器
              $filter->disableIdFilter();

              $filter->where(function ($query) {

                  $query->where('word_id', function ($query) {
                    //dd($query);
                      $query->from("words")->select("id")->where('word',"{$this->input}");
                  });

              }, '查询的单词');

              // 在这里添加字段过滤器
            //  $filter->like('word');
            //  $filter->equal('word_id')->placeholder('请输入查询单词');

          });




            $grid->id('ID')->sortable();
            $grid->word('单词')->display(function ($word) {


              return "<div>{$word['word']}</div>";
            });

            $grid->symbol('音标');
            $grid->path('MP3')->display(function ($title) {

                return "<audio controls='controls'>
            <source src='/voice/word/{$title}' type='audio/mpeg' />
          Your browser does not support the audio element.
          </audio>[{$title}]";

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
        return Admin::form(WordVoice::class, function (Form $form) {

            //$form->display('id', 'ID');
            $form->text('word.word', '单词');


            $form->text('symbol', '音标');

            $form->file("path","MP3");

            $form->saving(function (Form $form) {
              dump($form->symbol);
                //...
            });
          //  $form->text('path', 'MP3');

            //$form->display('created_at', 'Created At');
            //$form->display('updated_at', 'Updated At');
        });
    }
}
