<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Interfaces\JiraApiRepositoryInterface;
use App\Models\DailyTask;
use App\Models\Project;

class JiraApiRepository implements JiraApiRepositoryInterface
{
    private $email;
    private $password;
    private $headers;
    private $requestUrl;
    private $baseUrl;
    private $currentProjectId;

    public function __construct()
    {
        $this->email            = env('JIRA_API_EMAIL');
        $this->baseUrl          = env('JIRA_API_BASE_URL');
        $this->headers          = array('Accept' => 'application/json');
        $this->password         = env('JIRA_API_PASS');
        $this->currentProjectId = "CF7";
        $this->requestUrl       = env('JIRA_API_REQUEST_URL');
        $this->finalUrl         = $this->baseUrl . $this->requestUrl;
    }

    public function getAllJiraProjects()
    {
        $url = $this->baseUrl. 'project';
        return $response = $this->getJiraApiResponse( $this->email, $this->password, $url );
    }

    public function getProjectDetails()
    {
        $projectKeys = Project::select('project_key')->get();

        foreach ( $projectKeys as $eachKey) {
            $url = $this->finalUrl . $eachKey->project_key;
             $response = $this->getJiraApiResponse($this->email, $this->password, $url);

            // return $response->issues;
            if (isset($response->issues)){
                foreach($response->issues AS $issue)
                {
                    if (isset($issue->fields->customfield_10020) && ! empty($issue->fields->customfield_10020))
                    {
                        foreach ( $issue->fields->customfield_10020 as $key => $fields){
                            if ($fields->state == 'active'){

                                $sprintName = $fields->name;
                                $state      = $fields->state;
                                $startDate  = $fields->startDate;
                                $endDate    = $fields->endDate;
                            }
                        }
                    }

                    $dailyTask = new DailyTask();
                    $dailyTask->project_id      = $issue->fields->project->id;
                    $dailyTask->project_key     = $issue->fields->project->key;
                    $dailyTask->project_name    = $issue->fields->project->name;
                    $dailyTask->sprint_name     = $sprintName ?? 'No Name';
                    $dailyTask->task_status     = $issue->fields->status->name;
                    $dailyTask->task_summary    = $issue->fields->summary;
                    $dailyTask->assignee        = $issue->fields->assignee->displayName ?? 'No One Assigned';
                    $dailyTask->task_start_date = $startDate ?? null;
                    $dailyTask->task_end_date   = $endDate ?? null;
                    $dailyTask->created_at      = date('Y-m-d H:i:s');
                    $dailyTask->save();

                }
            }
        }

    }


    public function getJiraApiResponse( $email, $password, $url )
    {
        $response = Http::withBasicAuth($email, $password)->get($url)->body();
        return json_decode($response);
    }
}
