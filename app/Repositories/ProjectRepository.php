<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends JiraApiRepository
{

    /**
     * Get all project from DB
     */
    public function fetchAllProjectsFromDB()
    {
        // return $projects = $this->jiraRepo->getAllJiraProjects();
        // $this->insertAllProjectToDB();
        return Project::select('project_id', 'project_key', 'project_name', 'project_type', 'project_status_on_pmo')->get();
    }

    /**
     * Fetch All Jira Projects From Jira Borad Via API
     * And Update them to DB
     * @return array
     */
    public function updateEveryProject()
    {
        $url = $this->baseUrl . 'project';
        $projects = $this->getJiraApiResponse($this->email, $this->password, $url);

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

}
