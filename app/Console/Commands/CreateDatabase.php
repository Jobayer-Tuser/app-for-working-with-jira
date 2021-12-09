<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:database {dbname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database';

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
        $this->fire();
        return Command::SUCCESS;
    }

    private function fire()
    {
        $dbname = $this->argument('dbname');
        $hasDb  = DB::table('INFORMATION_SCHEMA.SCHEMATA')->select('SCHEMA_NAME')->where('SCHEMA_NAME', $dbname)->first();
        if ( empty( $hasDb ) ) {
            DB::connection()->statement( "CREATE DATABASE $dbname" );
            $this->info("Database $dbname created");

        } else {
            $this->error("Database $dbname already exists");
        }
    }
}
