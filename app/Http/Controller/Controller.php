<?php

namespace App\Http\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use Jenssegers\Blade\Blade;
use App\Http\Api\JiraApiController;
use App\Models\Database;

class Controller extends Database {

    private $db;
    private $blade;
    private $jira;

    public function __construct() {

        $this->db    = new Database();
        $this->jira  = new JiraApiController();
        $this->blade = new Blade('resource/views', 'resource/cache');    
    }
    
    
    public function getDataFromJira($email, $password, $headers, $finalUrl) {
        
        $this->jira->getProjectInfo( $email, $password, $headers, $finalUrl);
    }
    public function getDataFromDB() {

        return $result = Capsule::select('select * from try_users');

        echo $blade->render('homepage', ['name' => $result]);
    }


    
}