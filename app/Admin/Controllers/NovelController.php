<?php

namespace App\Admin\Controllers;

use App\Models\Novel;
use App\Models\NovelType;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NovelController extends Controller
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
        return Admin::grid(Novel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name("小说名称");
            $grid->novel_type()->name("类型名称");
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
        return Admin::form(Novel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '小说名称');
            $form->ckeditor('description','描述');
            $form->text('image', '图片');
            $form->text('author', '作者');
            $form->select('novel_type_id', '类型')->options(NovelType::all()->pluck('name', 'id'));

            $form->hasMany('novel_chapter', function (Form\NestedForm $form) {
              $form->text('name',"章节");
              $form->ckeditor('english');

              $form->ckeditor('chinese');
              $form->file('audio_path','audio_path')->uniqueName()->move('voice/novel');

            });

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
