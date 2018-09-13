<?php

namespace App\Admin\Controllers;

use App\Models\Course;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CourseController extends Controller
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
        return Admin::grid(Course::class, function (Grid $grid) {



            $grid->id('ID')->sortable();
            $grid->name('name');
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
        return Admin::form(Course::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '课程名');
            $form->ckeditor('description','描述');
            $form->select('is_enable', '是否可用')->options([0 => '失效', 1 => '有效']);
            $form->image('image',"图片")->uniqueName()->move('images/course');
            $form->hasMany('chapter', function (Form\NestedForm $form) {
              $form->text('name',"章节");
              $form->file('voice_path',"mp3音频文件")->uniqueName()->move('voice/course');
            });

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
