@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h1>句子例表</h1>
  <div><a href="{{route('phrase.create')}}">添加</a></div>
  <table class="table table-striped">
    <tr><td>ID</td><td>English</td><td>Chinese</td><td>慢速</td><td>中速</td><td>快速</td><td>默认URL</td><td>操作</td></tr>
    @foreach ($phrases as $phrase)
    <tr>
      <td>{{ $phrase->id}}</td>
      <td>{{ $phrase->english}}</td>
      <td>{{ $phrase->chinese }}</td>
      <td>{{ $phrase->s_url }}</td>
      <td>{{ $phrase->n_url }}</td>
      <td>{{ $phrase->f_url }}</td>
      <td>{{ $phrase->default_url }}</td>
      <td ><a href="{{route('phrase.edit',$phrase->id)}}" class="btn btn-info">编辑</a>


        {!! Form::open(array('url' => route('phrase.destroy',$phrase->id),'method'=>'delete')) !!}
        {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
        {!! Form::close()!!}

      </td>
    </tr>
    @endforeach
  </table>

  {!! $phrases->render() !!}
<div>

</div>
</div>
@stop
