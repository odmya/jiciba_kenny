<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
          // 每周星期一13:00运行一次...
          $app = app('wechat.mini_program');
          $app->template_message->send([
          'touser' => 'octkF0YMdvEd3qIzNV3kvpJiVezA',
          'template_id' => 'vjl0mS58ggACnSdZhG2_6f43RFfED0uGaFJM4IJkJDM',
          'page' => 'index',
          'form_id' => 'form-id',
          'data' => [
              'keyword1' => '你需要及时复习',
              'keyword2' => '每天记单词',
              'keyword3' => '点击开始背单词',
              // ...
          ],
      ]);
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
