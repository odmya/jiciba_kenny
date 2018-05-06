<?php

namespace App\Admin\Controllers;

use App\Models\WordSpeech;

use Illuminate\Http\Request;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WordSpeechController extends Controller
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
        return Admin::grid(WordSpeech::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->cixing('词性');
            //$grid->created_at();
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
        return Admin::form(WordSpeech::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('cixing', '词性');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
// 定义返回词性API， 返回例表

    public function cixinglist(Request $request)
      {

          $q = $request->get('q');
          return WordSpeech::where('cixing', 'like', "%$q%")->get(['id', 'cixing as text']);
        //  return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
          //return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
      }

}
