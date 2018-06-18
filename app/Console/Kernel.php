<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\AutoRecord;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];


    protected function sendmsg(){
      $datastuf = strtotime(date('Y-m-d H:i:s'));
      $autorecord = AutoRecord::where('run_time','<',$datastuf)->get();

    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

      $schedule->call(function () {
          // 每周星期一13:00运行一次...
      })->twiceDaily(6, 20);

      $schedule->call(function () {

        $app = app('wechat.mini_program'); // 小程序
        $datastuf = strtotime(date('Y-m-d H:i:s'));
        $autorecords = AutoRecord::where('run_time','<',$datastuf)->get();
        foreach($autorecords as $record){
          $app->template_message->send([
            'touser' => $record->user_openid,
            'template_id' => $record->template_id,
            'page' => 'pages/words/jidanci',
            'form_id' => $record->miniformid,
            'data' => [
                'keyword1' => '你需要及时复习',
                'keyword2' => '每天记单词',
                'keyword3' => '点击开始背单词',
                'keyword5' => '请及时复习单词',
                // ...
            ],
        ]);

        $record->delete();

        }

      })->hourly();
        // $schedule->command('inspire')
        //          ->hourly();
        //liyuping added 2018-4-20
      //  $schedule->command('inspire')->everyTenMinutes();

      //  $schedule->command('route:list')->dailyAt('02:00');

          //liyuping added 2018-4-20

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
