<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Repositories\DailyTaskRepository;
use App\Repositories\ProjectRepository;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Console\Commands\CreateDatabase::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:dailyproject')
                ->everyMinute()
                ->appendOutputTo('scheduler.log');

        $schedule->command('update:dailytask')->everyFiveMinutes();
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimeZone()
    {
        return 'Asia/Dhaka';
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
