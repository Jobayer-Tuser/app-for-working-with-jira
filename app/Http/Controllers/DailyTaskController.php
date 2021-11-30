<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyTask;

class DailyTaskController extends Controller
{

    public function index($key)
    {
        // return $key;

        $data['tasks'] = DailyTask::where('project_key', $key)->get();

        return view('pages.tasks.index', $data);
    }
}
