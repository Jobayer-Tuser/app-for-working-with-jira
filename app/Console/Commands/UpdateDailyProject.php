<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ProjectRepository;

class UpdateDailyProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:dailyproject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all JIRA project';

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
        $updateProject = new ProjectRepository();
        try {
            $updateProject->updateEveryProject();
            $updateProject->updateEveryGroup();
            $updateProject->updateEveryUser();

        } catch( \Exception $error ) {
            echo $error->getMessage();
        }

    }
}
