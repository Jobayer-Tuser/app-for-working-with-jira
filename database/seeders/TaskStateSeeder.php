<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [ 'BACKLOG', 'IN DESIGN', 'IN DEVELOPMENT', 'RETURNED', 'IN TESTING', 'IN REVIEW', 'DONE' ];

        foreach ( $states AS $state ) {

            DB::table('task_state')->insert([
                'state_name'   => $state,
                'state_status' => 'Active',
                'created_at'   => date('Y-m-d H:i:s')
            ]);
        }
    }
}
