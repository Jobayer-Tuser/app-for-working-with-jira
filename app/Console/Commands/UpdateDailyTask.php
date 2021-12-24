<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\DailyTaskRepository;
use Exception;

class UpdateDailyTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:dailytask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all JIRA task';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $task = new DailyTaskRepository();
        try {
            $task->updateAllDailyTask();
        } catch ( Exception $error ){
            echo $error->getMessage();
        }
    }
}
