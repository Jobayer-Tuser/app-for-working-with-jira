<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function scopeSelectAll( $query )
    {
       return $query->select('id','project_id', 'project_key', 'project_name', 'project_type', 'project_status_on_pmo');
    }

    public function scopeSelectDistinct( $query )
    {
        return $query->select('project_type')->distinct();
    }
}
