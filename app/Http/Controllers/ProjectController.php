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

    public function index(Request $request)
    {
        $value = $this->proRepo->fetchAllProjectsFromDB( $request->project_type );
        $data  = [
            'projects'    => $value['projects'],
            'projectType' => $value['projectType'],
        ];
        return view('pages.project.index', $data);
    }

    public function update(Request $request)
    {
        $status = $this->proRepo->updateProjectStautus( $request->project_status, $request->project_id );
        if ( $status > 0 ){
            return redirect(route('project.list'));
        }
    }

    public function runCronJobForProject()
    {
        $this->proRepo->updateEveryProject();
        return redirect(route('project.list'));
    }

    public function getGroup()
    {
        return $this->proRepo->getAllGroup();
    }

    public function getUser()
    {
        return $this->proRepo->getUser();
    }
}
