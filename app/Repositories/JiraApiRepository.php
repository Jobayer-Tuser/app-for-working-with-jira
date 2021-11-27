<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Http\Controller\Controller;
use App\Interfaces\JiraApiRepositoryInterface;

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
        $this->requestUrl       = env('JIRA_API_REQUEST_URL') . $this->currentProjectId;
        $this->finalUrl         = $this->baseUrl . $this->requestUrl;
    }

    public function getAllJiraProjects()
    {
        $url = $this->baseUrl. 'project';
        return $response = $this->getJiraApiResponse( $this->email, $this->password, $url );

    }

    public function getProjectDetailsByKey()
    {
        $response = $this->getJiraApiResponse($this->email, $this->password, $this->finalUrl);

        
        foreach($response->issues AS $issues)
        {
            $requiredData = array(
                'project_name'        => $issues->fields->project->name,
                'sprint_name'         => $issues->fields->customfield_10020, // this field has multiple array need to check
                'task_current_status' => $issues->fields->status->name,
                'task_name'           => $issues->fields->summary,
                'asigned_person'      => $issues->fields->assignee->displayName ?? null,
                'task_start_date'     => $issues->fields->customfield_10020[1]->startDate ?? null,
                'tast_end_date'       => $issues->fields->customfield_10020[1]->endDate ?? null,
            );

            echo "<pre>";
            print_r( $requiredData  );
            echo "</pre>";
        }
    }


    public function getJiraApiResponse( $email, $password, $url )
    {
        $response = Http::withBasicAuth($email, $password)->get($url)->body();
        return json_decode($response);
    }
}
