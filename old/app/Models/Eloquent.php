<?php

namespace App\Models;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Eloquent {

    public $dbManager;
    public function __construct(){

        $this->dbManager = new Manager();

        $this->dbManager->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'plugin_dev',
            'username'  => 'tuser',
            'password'  => 'testPass!@#',
            // 'charset'   => 'utf8',
            // 'collation' => 'utf8_unicode_ci',
            // 'prefix'    => '',
        ]);
        
        // Set the event dispatcher used by Eloquent models... (optional)
        $this->dbManager->setEventDispatcher(new Dispatcher(new Container) );
        
        // Make this Capsule instance available globally via static methods... (optional)
        $this->dbManager->setAsGlobal();
        
        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->dbManager->bootEloquent();
    }
}

