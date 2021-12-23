<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Scope that get all project data from DB
     * @param query
     * @return array
     */
    public function scopeSelectAll( $query )
    {
       return $query->select('id','project_id', 'project_key', 'project_name', 'project_type', 'project_status_on_pmo');
    }

    /**
     * Get all unique project type from DB
     * @param query
     * @return array
     */
    public function scopeSelectDistinct( $query )
    {
        return $query->select('project_type')->distinct();
    }
}
