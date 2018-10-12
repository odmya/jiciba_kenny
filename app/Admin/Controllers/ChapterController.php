<?php

namespace App\Admin\Controllers;

use App\Models\Chapter;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ChapterController extends Controller
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
        return Admin::grid(Chapter::class, function (Grid $grid) {

          $grid->filter(function($filter){

              // 去掉默认的id过滤器
              $filter->disableIdFilter();

              $filter->where(function ($query) {

                  $query->where('course_id', function ($query) {
                    //dd($query);
                      $query->from("courses")->select("id")->where('name',"{$this->input}");
                  });

              }, '查询课程');

              // 在这里添加字段过滤器
            //  $filter->like('word');
            //  $filter->equal('word_id')->placeholder('请输入查询单词');

          });


            $grid->id('ID')->sortable();
            $grid->name('name');
            $grid->course()->display(function ($course) {
          //  dd($root);
            return "<div>{$course['name']}</div>";
            });

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
        return Admin::form(Chapter::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name', '章节名');
            $form->file('voice_path',"mp3音频文件")->uniqueName()->move('voice/course');

            $form->textarea('lrc', 'MP3字幕');
            $form->select('is_explain', '是否讲解')->options([0 => '非讲解', 1 => '讲解']);

            $form->hasMany('chapter_entry', function (Form\NestedForm $form) {
              $form->text('english',"英文");
              $form->text('chinese',"中文");
              $form->text('startTime',"起始时间");
              $form->text('endTime',"结束时间");
              $form->file('machine_slow', '机器发音慢速')->uniqueName()->move('voice/machine');
              $form->file('machine_normal', '机器发音正常语速')->uniqueName()->move('voice/machine');
              $form->select('enable_read', '是否可跟读')->options([0 => '不可以', 1 => '可以']);
            });



            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
