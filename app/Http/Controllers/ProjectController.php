<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\JiraApiController;

class ProjectController extends Controller
{
    //
    protected $jiraApi;

    public function __construct(JiraApiController $jiraApiController)
    {
        $this->jiraApi = $jiraApiController;
    }

    public function index()
    {
        $data['projects'] = $this->jiraApi->fetchAllProjectsFromDB();
        // return $this->jiraApi->insertDailyTask();

        return view('pages.project.index', $data);
    }
}
