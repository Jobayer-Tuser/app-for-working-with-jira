<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DailyTaskRepository;

use function GuzzleHttp\Promise\task;

class DailyTaskController extends Controller
{
    protected $taskRepo;

    public function __construct(DailyTaskRepository $dailyTaskRepository)
    {
        $this->taskRepo = $dailyTaskRepository;
    }

    public function index()
    {
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
        $tasks = $this->taskRepo->getDailyTaskReportViaAjaxCall( $request->group_name, $request->project_name, $request->project_status );
        // return $request;
        return response()->json($tasks);

    }

    private function exampletTaskList( $tasks )
    {
        $taskList = '';
        foreach ( $tasks as $eachTask ) {
            $taskList .=
            '<div class="card">
                <h1 class="card-title"> '. $eachTask['name'] .' </h1>';

                foreach ( $eachTask['details'] as $eachdetails ){

                    $taskList .='<div class="card-body">
                            <span class="badge bg-dark"> '. $eachdetails['title'] .' </span>
                            <span class="badge bg-dark"> '. $eachdetails['sprint'] .' </span>
                        </div>

                        <div class="px-3">
                            <ul class="list-unstyled">';

                            foreach ( $eachdetails['task'] as $task ){

                                $taskList .='<li class="">
                                                <div class="d-flex">
                                                    <div class="font-size-20 text-dark">
                                                        <i class="bx bx-down-arrow-circle d-block"></i>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-truncate text-muted font-size-14  description"> '. $task .' </p>
                                                    </div>
                                                </div>
                                            </li>';

                            }

                $taskList .=' </ul>
                                </div>
                                    <div class="px-5">
                            <hr class="hrClass" />
                        </div>';

                }

            $taskList .='</div>';
        }
        return $taskList;
    }

    public function taskArray()
    {
        return $this->taskRepo->structureArray();
    }

    public function loadTaskArray()
    {
        return $this->taskRepo->letsMergeArray();
        // return $this->taskRepo->loadTaskDetails();
        // return $this->taskRepo->getDailyTaskReportViaAjaxCall();

    }
}
