@extends('admin.default')
@section('title', '单词列表')

@section('content')
<div class="col-md-12">
  <h1>题目类型</h1>
  <div><a href="{{route('questiontype.create')}}">添加</a></div>
  <table class="table table-striped">
    <tr><td>ID</td><td>name</td></tr>
    @foreach ($questiontypes as $questiontype)
    <tr>
      <td>{{ $questiontype->id}}</td>
      <td>{{ $questiontype->name }}</td>

      <td ><a href="{{route('questiontype.edit',$questiontype->id)}}" class="btn btn-info">编辑</a>


        {!! Form::open(array('url' => route('questiontype.destroy',$questiontype->id),'method'=>'delete')) !!}
        {!! Form::submit('删除',array('class' => 'btn btn-info btn-danger')) !!}
        {!! Form::close()!!}

      </td>
    </tr>
    @endforeach
  </table>

  {!! $questiontypes->render() !!}
<div>

</div>
</div>
@stop
