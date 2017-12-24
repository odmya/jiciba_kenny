<div class="col-xs-12">
  <footer class="footer">
    <nav>

        <div class="navbar navbar-default navbar-fixed-bottom">



          <button type="button" id="startRecord" data-loading-text="Loading..." class="btn btn-primary col-xs-6" autocomplete="off">录音开始</button>
           <button type="button" id="stopRecord" data-loading-text="Loading..." class="btn btn-primary col-xs-6" autocomplete="off">录音结束</button>




           {!!Form::open(array('url' => $nextpageurl,'method'=> "get"))!!}


           @foreach ($phrasesections as $id => $phrase)


           {!! Form::hidden('page',$nextpage) !!}
           {!! Form::hidden('phrase_id',$phrase->id) !!}

           {!! Form::hidden('media_serverid',"",array("id"=>"media_serverid")) !!}

           @endforeach


                     <button type="submit" class="btn col-xs-12">添加</button>
           {!! Form::close() !!}


        </div>

      </nav>
  </footer>
</div>
