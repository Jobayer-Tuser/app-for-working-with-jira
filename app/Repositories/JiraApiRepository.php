<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Interfaces\JiraApiRepositoryInterface;
use App\Models\DailyTask;
use App\Models\Project;
use Exception;

class JiraApiRepository implements JiraApiRepositoryInterface
{
    protected string $email;
    protected string $password;
    protected array $headers;
    protected string $requestUrl;
    protected string $baseUrl;

    /**
     * Initialize every API required parameter
     *
     * @return param
     */
    public function __construct()
    {
        $this->email      = env('JIRA_API_EMAIL');
        $this->baseUrl    = env('JIRA_API_BASE_URL');
        $this->headers    = array('Accept' => 'application/json');
        $this->password   = env('JIRA_API_PASS');
        $this->requestUrl = env('JIRA_API_REQUEST_URL');
        $this->finalUrl   = $this->baseUrl . $this->requestUrl;
    }

    /**
     * HTTP Auth function to perform the API curl operation and fetach all requested api value
     *
     * @return object
     */
    public function getJiraApiResponse($email, $password, $url)
    {
        try {

            $response = Http::withBasicAuth($email, $password)->get($url)->body();
            return json_decode($response);

        } catch( Exception $error ) {
            echo $error->getMessage();
        }
    }
}
