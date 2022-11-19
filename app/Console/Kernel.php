<?php

namespace App\Console;

use App\Console\Commands\SendMailToAll;
use App\Jobs\SendMail;
use App\Models\Email;
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
        SendMailToAll::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:send')->everyMinute()
            ->unlessBetween('22:00', '7:01')
            ->when(function () {
                $email = Email::where('done', 0)->first();
                if ($email) {
                    return true;
                } else {
                    return false;
                }
            });
//        $schedule->job(new SendMail())->everyTwoMinutes();
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return config('app.timezone');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
