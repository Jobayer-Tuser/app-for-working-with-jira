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
        $value = $this->proRepo->fetchAllProjectsFromDB();
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
            if(!empty($request->filter_gender)) {

                // $data = DB::table('tbl_customer')
                //     ->select('CustomerName', 'Gender', 'Address', 'City', 'PostalCode', 'Country')
                //     ->where('Gender', $request->filter_gender)
                //     ->where('Country', $request->filter_country)
                //     ->get();
            } else {
                // $data = DB::table('tbl_customer')
                //     ->select('CustomerName', 'Gender', 'Address', 'City', 'PostalCode', 'Country')
                //     ->get();
            }
            return datatables()->of($data)->make(true);
        }
        $value = $this->proRepo->fetchAllProjectsFromDB();
        $data  = [
            'projects'    => $value['projects'],
            'projectType' => $value['projectType'],
        ];

        return view('pages.project.show');
    }
}
