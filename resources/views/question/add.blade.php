@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">

  <div><a href="{{route('question.index')}}">返回</a></div>



  <table class="table table-striped">
    <tr><td>ID</td><td>name</td><td>english</td><td>chinese</td><td>image_url</td><td>audio_path</td></tr>
    @foreach ($answers as $id => $answer)
    <tr>
      <td>{{ $answer->id}}</td>
      <td>{{ $answer->name}}</td>
      <td>{{$answer->english}}</td>
      <td>{{ $answer->chinese}}</td>
      <td>{{ $answer->image_url}}</td>
      <td>{{ $answer->audio_path}}</td>
<td>
  {!! Form::open(array('url' => route('sectionadditemremove'),'method'=>'delete')) !!}

  {!! Form::hidden('question_id',$question->id) !!}
  {!! Form::hidden('answer_id',$answer->id) !!}

  {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
  {!! Form::close()!!}

</td>
    </tr>
    @endforeach
  </table>


{!!Form::open(array('route' => 'questionaddsave','method'=> "POST",'enctype'=>"multipart/form-data"))!!}

      <div class="form-group">
        <label for="name">词条</label>

        {!! Form::text('id',"") !!}
        {!! Form::hidden('question_id',$question->id) !!}
      </div>
{!! Form::submit('添加',array('class'=>'btn btn-primary')) !!}

{!! Form::close() !!}




</div>
@stop
