<?php

namespace App\Admin\Controllers;

use App\Models\LevelBase;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class LevelBaseController extends Controller
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
        return Admin::grid(LevelBase::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('level_bases');
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
        return Admin::form(LevelBase::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('level_bases', 'Level Base');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function levelbasesapi(Request $request)
      {

          $id = $request->get('id');
          $q= $request->get('q');

          if($id){
            return LevelBase::where('id', '=', "$id")->get(['id', 'english as text']);
          }

          if($q){
                //return Word::where('word', '=', "$q")->get(['id', 'word as text']);
                return LevelBase::where('level_bases', 'like', "%$q%")->paginate(null, ['id', 'level_bases as text']);
          }

          return LevelBase::where('level_bases', 'like', "%$q%")->paginate(null, ['id', 'level_bases as text']);

        //  return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
          //return WordSpeech::where('cixing', 'like', "%$q%")->paginate(null, ['id', 'cixing as text']);
}

}
