<?php

namespace App\Http\Controllers\Api;

use App\Models\WordReview;
use App\Models\WordRisk;
use App\Models\WordRemember;
use App\Models\WordBundle;
use App\Models\LevelBase;
use App\Models\AutoRecord;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\WordReviewTransformer;
use App\Transformers\WordRiskTransformer;
use App\Transformers\WordBundleTransformer;
use App\Transformers\LevelBaseTransformer;
use App\Http\Requests\Api\WordReviewRequest;


class WordReviewController extends Controller
{
    //

    public function show(Request $request)
    {
      $user_id = $request->input('user_id');
      $datastuf = strtotime(date('Y-m-d H:i:s'));
      $wordreviews= WordReview::where('user_id',$user_id)->where('remember_time','<',$datastuf)->paginate(5);

      //  return $this->response->item($root_obj->rootcixing()->get(), new RootCiXingTransformer())->setStatusCode(201);
    //  return $this->response->collection($wordreviews, new WordReviewTransformer());
    return $this->response->paginator($wordreviews, new WordReviewTransformer());

    }


    public function newbundle(Request $request)
    {
        $user_id = $request->input('user_id');
        $level_base_id = $request->input('level_base_id');



        $wordbundle = WordBundle::create([
            'level_base_id' => $level_base_id,
            'user_id' => $user_id,
            'maxsize' => 10

          //  'level_star'=>$level_star
      //      'version' => $crawl_version,
        ]);

        if($wordbundle){
          return $this->response->item($wordbundle, new WordBundleTransformer())->setStatusCode(201);
        }else{
          return $this->response->error('参数不正确', 422);
        }


    }

    public function deletebundle(Request $request)
    {
        $user_id = $request->input('user_id');
        $bundle_id = $request->input('bundle_id');

        $wordbundle =WordBundle::where('user_id', $user_id)->where('id', $bundle_id)->delete();

        return $this->response->noContent();
    }

    public function updatebundle(Request $request)
    {
        $user_id = $request->input('user_id');
        $bundle_id = $request->input('bundle_id');
        $maxsize = $request->input('maxsize');

        $wordbundle =WordBundle::where('user_id', $user_id)->where('id', $bundle_id)->first();
        if($wordbundle){
          if($maxsize>=30){
            $maxsize = 30;
          }else if($maxsize<=1){
            $maxsize =1;
          }
          $wordbundle->maxsize = $maxsize;
          $wordbundle->save();
        }else{
          return $this->response->error('没有找到正确的单词本', 422);
        }


        return $this->response->item($wordbundle, new WordBundleTransformer())->setStatusCode(201);
    }


    public function wordsetting(Request $request){
      $user_id = $request->input('user_id');


      $wordbundle =WordBundle::where('user_id', $user_id)->orderBy('updated_at','DESC')->first();

      if($wordbundle){
        return $this->response->item($wordbundle, new WordBundleTransformer())->setStatusCode(201);
      }else{
        return $this->response->error('没有找到正确的单词本', 422);
      }


    }


    public function wordrisklist(Request $request){
      $user_id = $request->input('user_id');


      $datastuf = strtotime(date('Y-m-d'));

      $wordrisk =WordRisk::where('user_id', $user_id)->paginate(30);


      return $this->response->paginator($wordrisk, new WordRiskTransformer());

    }


    public function bundlelist(){


      $levelbase =LevelBase::orderBy('updated_at','DESC')->get();

      return $this->response->item($levelbase, new LevelBaseTransformer());

    }

    public function wordreviewlist(Request $request){
      $user_id = $request->input('user_id');
      $datastuf = strtotime(date('Y-m-d'));

      $wordreview =WordReview::where('user_id', $user_id)->where('next_time', $datastuf)->orderBy('updated_at','DESC')->paginate(10);


      return $this->response->paginator($wordreview, new WordReviewTransformer());

    }


    public function viewupdate(Request $request){
      $user_id = $request->input('user_id');
      $word_id = $request->input('word_id');
      $datastuf = strtotime(date('Y-m-d H:i:s'));
      $datastuftoday = strtotime(date('Y-m-d'));

      $wordreview =WordReview::where('word_id',$word_id)->where('user_id',$user_id)->where('remember_time','<',$datastuf)->first();

      if($wordreview){
        switch ($wordreview->status)
        {
        case 1:
          //$datastuf = strtotime(date('+1 day'));
          $wordreview->status =2;
          $wordreview->remember_time = strtotime(date('Y-m-d',strtotime('+1 day'))); //一天后复习
          $wordreview->next_time = $datastuftoday;
          $wordreview->save();
          break;
        case 2:
        $wordreview->status =3;
          $wordreview->remember_time = strtotime(date('Y-m-d',strtotime('+1 day'))); //两天后复习
          $wordreview->next_time = $datastuftoday;
          $wordreview->save();
          break;
        case 3:
          $wordreview->status =4;
          $wordreview->remember_time = strtotime(date('Y-m-d',strtotime('+2 day'))); //四天后复习
          $wordreview->next_time = $datastuftoday;
          $wordreview->save();
            break;
        case 4:
          $wordreview->status =5;
          $wordreview->remember_time = strtotime(date('Y-m-d',strtotime('+3 day'))); //七天天后复习
          $wordreview->next_time = $datastuftoday;
          $wordreview->save();
              break;
        case 5:
          $wordreview->status =6;
          $wordreview->remember_time = strtotime(date('Y-m-d',strtotime('+8 day'))); //十五天后复习
          $wordreview->next_time = $datastuftoday;
          $wordreview->save();
              break;
        case 6:
              $wordremember =WordRemember::where('word_id',$word_id)->where('user_id',$user_id)->first();
              if($wordremember == false){
                      $wordremember = WordRemember::create([
                          'word_id' => $word_id,
                          'user_id' => $user_id

                        //  'level_star'=>$level_star
                    //      'version' => $crawl_version,
                      ]);

              }
              $wordreview->delete();

              break;
        default:
          break;
        }
        return $this->response->noContent()->setStatusCode(200);
      }else{
        return $this->response->error('不允许操作', 422);
      }


    }

    public function riskupdate(Request $request){
      $user_id = $request->input('user_id');
      $word_id = $request->input('word_id');
      $wordrisk = WordRisk::where('word_id',$word_id)->where('user_id',$user_id)->where('status',0)->first();

      $user = User::find($user_id);
      if($user->miniformid){
        $autorecord = AutoRecord::where('user_openid',$user->weapp_openid)->first();
        if($autorecord==false){
          $datastuf = strtotime('+1 hour');

          $template_id = 'vjl0mS58ggACnSdZhG2_6f43RFfED0uGaFJM4IJkJDM';
          $autorecord = AutoRecord::create([
              'user_openid' => $user->weapp_openid,
              'template_id' => $template_id,
              'miniformid' => $user->miniformid,
              'run_time' => strtotime('+1 hour')

            //  'level_star'=>$level_star
        //      'version' => $crawl_version,
          ]);
        }
      }


      if($wordrisk){

        $wordreview =WordReview::where('word_id',$wordrisk->word_id)->where('user_id',$wordrisk->user_id)->first();
        $datastuf = strtotime(date('+1 hour'));
        if($wordreview==false){
          $wordreview = WordReview::create([
              'word_id' => $word_id,
              'user_id' => $user_id,
              'status' => 1,
              'remember_time' => strtotime('+1 hour'), //当前时间一小时后
              'next_time' => strtotime(date('Y-m-d')) //一天后的凌晨开始

            //  'level_star'=>$level_star
        //      'version' => $crawl_version,
          ]);
        }
        $wordrisk->status = 1;
        $wordrisk->save();
        return $this->response->noContent()->setStatusCode(200);
      }else{
        return $this->response->error('操作不存在用户单词', 422);
      }

    }


}
