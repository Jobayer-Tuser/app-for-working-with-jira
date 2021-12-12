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

    public function index(Request $request, $key)
    {
        $value = $this->taskRepo->getAllTask($key, $request->assignee, $request->tastState, $request->spintName);
        $data = [
            'tasks'         => $value['tasks'],
            'tastState'     => $value['tastState'],
            'sprintName'    => $value['sprintName'],
            'projectKey'    => $value['projectKey'],
            'assignedPerson'=> $value['assignedPerson'],
        ];
        return view('pages.tasks.index', $data);
    }


    public function runCronJobForTask()
    {
        $this->taskRepo->updateAllDailyTask();
        $this->taskRepo->deleteCompleteTask();

        return redirect(route('task.list'));
    }
}
