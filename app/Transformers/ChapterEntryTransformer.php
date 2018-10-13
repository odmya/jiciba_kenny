<?php

namespace App\Transformers;

use App\Models\ChapterEntry;
use App\Models\Chapter;
use League\Fractal\TransformerAbstract;

class ChapterEntryTransformer extends TransformerAbstract
{

    public function transform(Chapter $chapter)
    {

      $next_item ="";
      $prev_item ="";
      foreach($chapter->course->chapter as $key => $tmp_chapter){
    //  echo $tmp_chapter->id.":".$tmp_chapter->name."<br/>";
      if($tmp_chapter->id == $chapter->id){
        if(isset($chapter->course->chapter[$key-1])){
          $prev_item =$chapter->course->chapter[$key-1]->id;
        }
        if(isset($chapter->course->chapter[$key+1])){
          $next_item =$chapter->course->chapter[$key+1]->id;
        }
      }
      }


      if($chapter->lrc){
        $chapter_entry_array =array();
        $is_explain = $chapter->is_explain;
        $lrc_array =explode("\n",$chapter->lrc);
        foreach($lrc_array as $v){
          $tmp_array = array();
          $tmp_time = substr($v,1,strpos($v,"]")-1);
          $tmp_time_array =explode(":",$tmp_time);
          $second_time = $tmp_time_array[0]*60 + $tmp_time_array[1];
          $tmp_array['startTime'] = $second_time;
          $tmp_array['highlight'] =0;

          $tmp_english = substr($v,strpos($v,"]")+1);
          $tmp_english = str_replace("\r","",$tmp_english);
          $tmpstr_zh = "";
          $tmpstr_en = "";
          if($is_explain){
            $tmp_array['english'] ="";
            $tmp_array['chinese'] = $tmp_english;
          }else{
            if(strpos($tmp_english,"|")){
              $tmp_arr = explode("|",$tmp_english);
              $tmp_array['english'] = $tmp_arr[0];
              $tmp_array['chinese'] = $tmp_arr[1];

            }else{
              for($i=0; $i<strlen($tmp_english); $i++){
                 $value=ord(substr($tmp_english,$i,1));

                 if($value>127){
                     $tmpstr_zh .= substr($tmp_english,$i,2);

                     $tmp_array['english'] = substr($tmp_english,0,$i);
                     $tmp_array['chinese'] = substr($tmp_english,$i);
                     break;

                     $i++;
                 }else{
                     $tmpstr_en .= substr($tmp_english,$i,1);
                     $tmp_array['chinese'] ="";
                     $tmp_array['english'] = substr($tmp_english,0,$i);

                 }
               }
            }

           //$tmp_array['english'] = $tmpstr_en;
           //$tmp_array['chinese'] = $tmpstr_zh;

          }


         $chapter_entry_array[] = $tmp_array;



        }

        $chapter_entry =$chapter_entry_array;

        return [
            'id' => $chapter->id,
            'next_item' =>$next_item,
            'prev_item' =>$prev_item,
            'name' => $chapter->name,
            'course_name' => $chapter->course->name,
            'course_id' => $chapter->course->id,
            'chapter_list' => $chapter->course->chapter,
            'voice_path' => $chapter->voice_path,
            'chapter_entry' => $chapter_entry,
            'created_at' => $chapter->created_at->toDateTimeString(),
            'updated_at' => $chapter->updated_at->toDateTimeString(),
        ];
        //var_dump($chapter_entry);
         //die();
      }
        return [
            'id' => $chapter->id,
            'next_item' =>$next_item,
            'prev_item' =>$prev_item,
            'name' => $chapter->name,
            'course_name' => $chapter->course->name,
            'course_id' => $chapter->course->id,
            'chapter_list' => $chapter->course->chapter,
            'voice_path' => $chapter->voice_path,
            'chapter_entry' => $chapter->chapter_entry,
            'created_at' => $chapter->created_at->toDateTimeString(),
            'updated_at' => $chapter->updated_at->toDateTimeString(),
        ];
    }

}
