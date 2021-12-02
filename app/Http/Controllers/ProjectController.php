<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;

class ProjectController extends Controller
{

    private $proRepo;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->proRepo = $projectRepository;
    }

    public function index()
    {
        $data['projects'] = $this->proRepo->fetchAllProjectsFromDB();
        // return $this->jiraApi->updateDailyTask();

        return view('pages.project.index', $data);
    }

    public function runCronJobForProject()
    {
        $this->proRepo->updateEveryProject();
    }

}
