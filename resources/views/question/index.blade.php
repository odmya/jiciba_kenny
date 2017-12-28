@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h1>题目例表</h1>
  <div><a href="{{route('question.create')}}">添加</a></div>
  <table class="table table-striped">
    <tr><td>ID</td><td>name</td><td>English</td><td>Chinese</td><td>提问中文</td><td>提问英文翻译</td><td>图片地址</td><td>正确答案ID</td><td>phranse list</td><td>音频地址</td><td>类型</td><td>排序</td><td>enable</td></tr>
    @foreach ($questions as $question)
    <tr>
      <td>{{ $question->id}}</td>
      <td><a href="{{route('questionadd',$question->id)}}">{{ $question->name }}</a></td>
      <td>{{ $question->description_en}}</td>
      <td>{{ $question->description_zh }}</td>
      <td>{{ $question->question_zh }}</td>
      <td>{{ $question->question_en }}</td>
      <td>{{ $question->image_url }}</td>
      <td>{{ $question->correctanswer['name']}}</td>
      <td>{{ $question->phrase_list }}</td>
      <td>{{ $question->audio_path }}</td>
      <td>{{ $question->questiontype->name }}</td>
      <td>{{ $question->sort }}</td>
      <td>{{ $question->enable }}</td>
      <td ><a href="{{route('question.edit',$question->id)}}" class="btn btn-info">编辑</a>


        {!! Form::open(array('url' => route('question.destroy',$question->id),'method'=>'delete')) !!}
        {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
        {!! Form::close()!!}

      </td>
    </tr>
    @endforeach
  </table>

  {!! $questions->render() !!}
<div>

</div>
</div>
@stop
