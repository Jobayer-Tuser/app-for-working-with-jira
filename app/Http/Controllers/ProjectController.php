<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use App\Models\Project;

class ProjectController extends Controller
{
    private $proRepo;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->proRepo = $projectRepository;
    }

    public function index(Request $request)
    {
        // return $this->proRepo->updateEveryProject();
        $value = $this->proRepo->fetchAllProjectsFromDB( $request->project_type );
        $data  = [
            'projects'    => $value['projects'],
            'projectType' => $value['projectType'],
        ];
        return view('pages.project.index', $data);
    }

    public function update(Request $request)
    {
        // return $request;
        $status = $this->proRepo->updateProjectStautus( $request->projectStat, $request->id );
        return response()->json($status);
    }

    public function getGroup()
    {
        return $this->proRepo->updateEveryGroup();
    }

    public function getUser()
    {
        return $this->proRepo->updateEveryUser();
    }

    public function loadProject( Request $request )
    {
        $project = $this->proRepo->loadProjectVaiAajaxCall($request->projectType);


        return response()->json($project);
    }
}
