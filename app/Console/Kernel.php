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
        // $schedule->command('inspire')->hourly();
        $task = new DailyTaskRepository();
        $project = new DailyTaskRepository();

        $schedule->call(function ( $project, $task ) {

            $project->updateEveryProject();
            $task->updateAllDailyTask();
            $task->deleteCompleteTask();

        })->hourly();

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
