<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailyTask extends Model
{
    use HasFactory;

    public function scopeGetTaskState( $query )
    {
        return DB::table('task_state')->select('state_name')->where('state_status', '=', 'active');
    }
}
