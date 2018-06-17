<?php

namespace App\Admin\Controllers;

use App\Models\Root;
use App\Models\WordSpeech;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RootController extends Controller
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
        return Admin::grid(Root::class, function (Grid $grid) {

          $grid->filter(function($filter){

              // 去掉默认的id过滤器
              $filter->disableIdFilter();
              $filter->like('name')->placeholder('请输入查询词根');

              // 在这里添加字段过滤器
            //  $filter->like('word');
            //  $filter->equal('word_id')->placeholder('请输入查询单词');

          });

            $grid->id('ID')->sortable();
            $grid->name('词根');
            //$grid->types()->options()->select([0 => '前缀', 1 => '后缀', 2 => '词根']);
             $grid->types()->editable('select', [0 => '前缀', 1 => '后缀', 2 => '词根']); //可编辑
            $grid->description('描述');
            //$grid->created_at();
            //$grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Root::class, function (Form $form) {

            //$form->display('id', 'ID');
            $form->text('name','词根');
            $form->select('types')->options([0 => '前缀', 1 => '后缀', 2 => '词根']);
            $form->ckeditor('description','描述');

            $form->hasMany('rootcixing', function (Form\NestedForm $form) {
            //$form->text('rootcixing.description',"描叙");
            $form->select('word_speech_id',"词性")->options(WordSpeech::all()->pluck('cixing', 'id'));

            });


            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
