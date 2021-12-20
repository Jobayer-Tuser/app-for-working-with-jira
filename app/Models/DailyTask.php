<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = ['project_id',  'project_key',  'project_name',  'sprint_name',  'task_status',  'task_summary',  'assignee_id',  'assignee',  'task_start_date',  'task_end_date',  'created_at', 'updated_at'];

    public function scopeGetTaskState( $query )
    {
        return DB::table('task_state')->select('state_name')->where('state_status', '=', 'active');
    }
}
