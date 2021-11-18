<?php

namespace App\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Database {

    protected $capsule;
    public function __construct(){

        $this->capsule = new Capsule();

        $this->capsule->addConnection([
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
        $this->capsule->setEventDispatcher(new Dispatcher(new Container) );
        
        // Make this Capsule instance available globally via static methods... (optional)
        $this->capsule->setAsGlobal();
        
        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->capsule->bootEloquent();
    }
}

