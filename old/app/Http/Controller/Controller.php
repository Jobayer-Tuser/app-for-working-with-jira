<?php

namespace App\Http\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use Jenssegers\Blade\Blade;
use App\Http\Api\JiraApiController;
use App\Models\Eloquent;

class Controller extends Eloquent {

    private $db;
    private $blade;
    private $jira;

    public function __construct() {

        $this->db    = new Eloquent();
        $this->jira  = new JiraApiController();
        $this->blade = new Blade('resource/views', 'resource/cache');    
    }
    
    
    public function getDataFromJira($email, $password, $headers, $finalUrl) {
        
        $this->jira->getProjectInfo( $email, $password, $headers, $finalUrl);
    }
    public function getDataFromDB() {

        $result = Capsule::select('select * from try_users');
        // $result2 = Capsule::select('db.try_users.select()');

        echo $this->blade->render('homepage', ['data' => $result]);
    }

    public function insertProjectInfo() {
        #INSERT INTO tbl_name (a,b,c) VALUES(1,2,3), (4,5,6), (7,8,9);
        $sql = "INSERT INTO `daily_tasks` ( `project_id`, `project_key`, `project_name`, `sprint_name`, `task_status`, `task_summary`, `assignee`, `task_start_date`, `task_end_date`, `created_at` ) VALUES ()";
        $sql = "INSERT INTO `projects` ( `project_id`, `project_key`, `project_name`, `project_status_on_pmo`) VALUES()";
    }


    
}