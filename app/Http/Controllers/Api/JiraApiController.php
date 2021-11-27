<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\JiraApiRepository;
use App\Models\Project;

class JiraApiController extends Controller
{

    private $jiraRepo;

    public function __construct(JiraApiRepository $jiraApiRepository)
    {
        $this->jiraRepo = $jiraApiRepository;
    }

    public function fetchAllProjectsFromDB()
    {
        // return $projects = $this->jiraRepo->getAllJiraProjects();
        $this->insertAllProjectToDB();
        return Project::all();
    }

    public function insertAllProjectToDB()
    {
        $projects = $this->jiraRepo->getAllJiraProjects();
        foreach( $projects AS $eachProject) {

            $getProjectKey = Project::where('project_key', '=', $eachProject->key)->first();

            if ($getProjectKey) {

                $getProjectKey->project_id   = $eachProject->id;
                $getProjectKey->project_key  = $eachProject->key;
                $getProjectKey->project_name = $eachProject->name;
                $getProjectKey->project_type = isset($eachProject->projectCategory) ? $eachProject->projectCategory->name : null;
                $getProjectKey->updated_at   = date('Y-m-d H:i:s');
                $getProjectKey->save();

            } else {

                $project = new Project();
                $project->project_id   = $eachProject->id;
                $project->project_key  = $eachProject->key;
                $project->project_name = $eachProject->name;
                $project->project_type = isset($eachProject->projectCategory) ? $eachProject->projectCategory->name : null;
                $project->created_at   = date('Y-m-d H:i:s');
                $project->save();
            }

        }

    }

    public function insertDailyTask()
    {
        
    }
}
