<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DailyTaskRepository;

class DailyTaskController extends Controller
{
    protected $taskRepo;

    public function __construct(DailyTaskRepository $dailyTaskRepository)
    {
        $this->taskRepo = $dailyTaskRepository;
    }

    public function index()
    {
        // return $this->taskRepo->updateAllDailyTask();
        $value = $this->taskRepo->getAllTask();
        $data = [
            'groups'      => $value['groups'],
            'projects'    => $value['projects'],
            'taskStates'  => $value['taskStates'],
        ];
        return view('pages.tasks.index', $data);
    }

    public function filterTask(Request $request)
    {
        return $request;
        $tasks = $this->taskRepo->getDailyTaskReportViaAjaxCall( $request->group_name, $request->project_name, $request->project_status );
        return response()->json($tasks);
    }
}
