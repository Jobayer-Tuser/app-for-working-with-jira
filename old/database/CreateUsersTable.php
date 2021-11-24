<?php

use App\Models\Eloquent;
use Illuminate\Database\Capsule\Manager;

class CreateUsersTable extends Eloquent {

    public function up(){

        Manager::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('userimage')->nullable();
            $table->string('api_key')->nullable()->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down() {
        Manager::schema()->dropIfExists('users');
    }
}