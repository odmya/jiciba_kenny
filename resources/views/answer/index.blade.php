@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h1>答题选项例表</h1>
  <div><a href="{{route('answer.create')}}">添加</a></div>
  <table class="table table-striped">
    <tr><td>ID</td><td>name</td><td>English</td><td>Chinese</td><td>image_url</td><td>audio_path</td></tr>
    @foreach ($answers as $answer)
    <tr>
      <td>{{ $answer->id}}</td>
      <td>{{ $answer->name }}</td>
      <td>{{ $answer->english}}</td>
      <td>{{ $answer->chinese }}</td>
      <td>{{ $answer->image_url }}</td>
      <td>{{ $answer->audio_path }}</td>
      <td ><a href="{{route('answer.edit',$answer->id)}}" class="btn btn-info">编辑</a>


        {!! Form::open(array('url' => route('answer.destroy',$answer->id),'method'=>'delete')) !!}
        {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
        {!! Form::close()!!}

      </td>
    </tr>
    @endforeach
  </table>

  {!! $answers->render() !!}
<div>

</div>
</div>
@stop
