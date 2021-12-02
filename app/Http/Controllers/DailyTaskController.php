<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DailyTask;

class DailyTaskController extends Controller
{

    public function index(Request $request, $key)
    {
        $query = DailyTask::where('project_key', $key);

        if($request->has('assignee')) {
            $query->where('assignee', $request->assignee);
        }
        if($request->has('tastState')){
            $query->where('task_status', $request->tastState);
        }
        if($request->has('spintName')){
            $query->where('sprint_name', $request->spintName);
        }

        $data['tasks']          = $query->get();
        $data['tastState']      = DB::table('task_state')->select('state_name')->where('state_status', '=', 'active')->get();
        $data['sprintName']     = $query->select('sprint_name')->distinct()->get();
        $data['projectKey']     = $key;
        $data['assignedPerson'] = $query->select('assignee')->distinct()->get();

        return view('pages.tasks.index', $data);
    }

}
