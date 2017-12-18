<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use Log;
use Mail;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
            Log::error("Cron running " . date('H:i:s'));
            $order_data = DB::table('order_emails')->get();
            if ($order_data->toArray()) {
                foreach ($order_data as $value) {
                    $data = json_decode($value->order_data);
                    Log::error("Cron running " . $value->order_data);
                    Mail::send('auth.emails.status_invoice', $data, function($message) use ($data) {
                        $message->from('jerhica.pe@gmail.com', " Welcome To Autolighthouse");
                        $message->to($data['email'])->subject('Autolighthouse Store:New Order #' . $data['item_data']['id']);
                    });
                }
                DB::table('order_emails')->delete();
            }
        })->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }

}
