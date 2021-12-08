<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use App\Models\Project;
use DataTables;

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
        $status = $this->proRepo->updateProjectStautus( $request->status, $request->id );
        if ( $status > 0 ){
            return response()->json(['success'=>'Status change successfully.']);
        }
    }

    public function runCronJobForProject()
    {
        $this->proRepo->updateEveryProject();
    }

    public function show( Request $request )
    {
        if(request()->ajax()) {
            $data = Project::latest()->get();
            return DataTables::of($data)->make(true);
        }


        $value = $this->proRepo->fetchAllProjectsFromDB();
        $data  = [
            'projects'    => $value['projects'],
            'projectType' => $value['projectType'],
        ];

        return view('pages.project.show');
    }

    public function fetch(Request $request)
    {
        if($request->ajax())  {
            $data = Project::latest()->get();

            // if($request->from_date != '' && $request->to_date != '') {
            //     $data = Project::latest()->get();
            // } else {
            // }
            echo json_encode($data);
        }
    }
}
