<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('project_id', 127);
            $table->string('project_key', 127);
            $table->string('project_name', 127);
            $table->string('assignee_id', 127);
            $table->string('assignee', 127);
            $table->string('sprint_name', 127);
            $table->string('task_status', 127);
            $table->text('task_summary');
            $table->string('task_start_date')->nullable();
            $table->string('task_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_tasks');
    }
}
