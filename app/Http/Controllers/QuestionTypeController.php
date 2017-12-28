<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QuestionType;
use Auth;

class QuestionTypeController extends Controller
{
    //

    public function index()
    {
      if(Auth::user()->is_admin){
        $questiontypes = QuestionType::orderBy('created_at', 'desc')
                           ->paginate(30);
        return view('questiontype.index', compact('questiontypes'));
      }else{
        return redirect('login');
      }


    }





    public function destroy(QuestionType $questiontype, Request $request){

      if(Auth::user()->is_admin){
        $question->delete();
        return redirect(route('questiontype.index'));
      }else{
        return redirect('login');
      }
    }


      public function create()
        {
            return view('questiontype.create');
        }

        public function show(QuestionType $questiontype)
        {
          //  $this->authorize('update', $phrase);
            return view('question.show', compact('questiontype'));
        }



        public function store(Request $request)
      {

        $this->validate($request, [
         'name' => 'required|max:255',
       ]);


        $questiontype = QuestionType::create([
            'name' => $request->name,

        ]);

          return redirect(route('questiontype.index'));
      }



      public function update(QuestionType $questiontype, Request $request)
        {
            $this->validate($request, [
                'name' => 'required',
            ]);
            $data = [];
            $data['name'] = $request->name;

            $questiontype->update($data);

            session()->flash('success', '修改成功');

            return redirect()->route('questiontype.index');
        }



        public function edit(QuestionType $questiontype)
        {
            return view('questiontype.edit', compact('questiontype'));
        }





}
