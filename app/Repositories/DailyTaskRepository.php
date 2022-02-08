<?php

namespace App\Repositories;

use App\Models\Assignee;
use Illuminate\Support\Facades\DB;
use App\Models\DailyTask;
use App\Models\Group;
use App\Models\Project;


class DailyTaskRepository extends JiraApiRepository
{
    /**
     * Get the filter required value
     * @return array
     */
    public function getAllTask()
    {
        $data['groups'] = Group::select('name')->get();
        $data['projects'] = Project::select('project_name')->get();
        $data['taskStates'] = DB::table('task_state')->select('state_name')->where('state_status', 'Active')->get();
        return $data;
    }

    /**
     * Parse all project key from data and preapare full api to fetch all value from Jira Board
     * Update the old task and insert the new task to daily_task table
     *
     * @return void
     */
    public function updateAllDailyTask()
    {
        $projectKeys = Project::select('project_key')
                        ->whereNull('last_sync')
                        ->orWhere('project_status_on_pmo', 'Untracked')
                        ->take(1)
                        ->get();

        if ( ! isset($projectKeys) ) {
        return $projectKeys = Project::select('project_key')
                        ->orWhere('project_status_on_pmo', 'Untracked')
                        ->where('last_sync', 'SELECT MIN(last_sync)')
                        ->take(1)
                        ->get();

        }

        // $sql = "SELECT `project_key` FROM `projects` WHERE `last_sync` = (SELECT MIN(`last_sync`) FROM `projects`) OR `project_status_on_pmo` = 'Untracked' LIMIT 1";

        # Parse the full url to fetch every task for single project
        // $url = $this->finalUrl . 'TUTOR2';
        $url = $this->finalUrl . $projectKeys[0]->project_key;

        $response = $this->getJiraApiResponse($this->email, $this->password, $url);

        if (isset($response->errorMessages) && str_contains($response->errorMessages[0], "does not exist for the field 'project'")) {

            Project::where('project_key', $projectKeys[0]->project_key)->update(['last_sync' => now()->toDateTimeString()]);

        } else {

            foreach ($response->issues as $issue) {

                #get the active sprint value
                if (isset($issue->fields->customfield_10020) && !empty($issue->fields->customfield_10020)) {
                    foreach ($issue->fields->customfield_10020 as $key => $fields) {
                        if ($fields->state == 'active') {

                            $sprintName = $fields->name;
                            $state      = $fields->state;
                            $startDate  = $fields->startDate;
                            $endDate    = $fields->endDate;
                        }
                    }
                }
                $oldDailyTask = DailyTask::where('project_key', $issue->fields->project->key)->first();

                #get the old daily task value and update them
                if (isset($oldDailyTask) && !empty($oldDailyTask)) {

                    $oldDailyTask->project_id       = $issue->fields->project->id;
                    $oldDailyTask->project_key      = $issue->fields->project->key;
                    $oldDailyTask->project_name     = $issue->fields->project->name;
                    $oldDailyTask->sprint_name      = $sprintName ?? 'No Name';
                    $oldDailyTask->task_status      = $issue->fields->status->name;
                    $oldDailyTask->task_summary     = $issue->fields->summary;
                    $oldDailyTask->assignee_id      = $issue->fields->assignee->accountId ?? 'No ID';
                    $oldDailyTask->assignee         = $issue->fields->assignee->displayName ?? 'No One Assigned';
                    $oldDailyTask->task_start_date  = $startDate ?? null;
                    $oldDailyTask->task_end_date    = $endDate ?? null;
                    $oldDailyTask->updated_at       = now()->toDateTimeString();
                    $oldDailyTask->save();
                } else {

                    $newTask = new DailyTask();

                    $newTask->project_id        = $issue->fields->project->id;
                    $newTask->project_key       = $issue->fields->project->key;
                    $newTask->project_name      = $issue->fields->project->name;
                    $newTask->sprint_name       = $sprintName ?? 'No Name';
                    $newTask->task_status       = $issue->fields->status->name;
                    $newTask->task_summary      = $issue->fields->summary;
                    $newTask->assignee_id       = $issue->fields->assignee->accountId ?? 'No ID';
                    $newTask->assignee          = $issue->fields->assignee->displayName ?? 'No One Assigned';
                    $newTask->task_start_date   = $startDate ?? null;
                    $newTask->task_end_date     = $endDate ?? null;
                    $newTask->created_at        = now()->toDateTimeString();
                    $newTask->save();

                }

                Project::where('project_key', $projectKeys[0]->project_key)->update(['last_sync' => now()->toDateTimeString()]);
            }
        }
    }

    /**
     * Delete the Completed Task from Database
     *
     * @return void
     */
    public function deleteCompleteTask()
    {
        DailyTask::where('task_status', 'Done')->delete();
    }

    public function getDailyTaskReportViaAjaxCall($group_name = null, $project_name = null, $project_status = null): array
    {
        return $this->finalTask($group_name, $project_name, $project_status);
    }

    public function assigneName()
    {
        return $assigne = Assignee::select('assignee_name', 'account_id')->where('account_type', 'atlassian')->distinct()->get();
    }

    public function projectDetails($assigneId)
    {
        return $projectName = DailyTask::select('project_name', 'project_id')
            ->where('assignee_id', $assigneId)
            ->distinct('project_name')
            ->get();
    }

    public function taskSummary($project_id)
    {
        return DailyTask::select('task_summary')
            ->where('project_id', $project_id)
            ->get();
    }

    public function sprintName($project_id)
    {
        return DailyTask::select('sprint_name')
            ->where('project_id', $project_id)
            ->distinct('sprint_name')
            ->get();
    }

    public function finalTask( $group_name = null, $project_name = null, $project_status = null): array
    {
        $array = [];
        $assignename = $this->assigneName();
        foreach ($assignename as $each) {

            $accountid      = $each->account_id;
            $projectDetail  = $this->projectDetails($accountid);
            $objToArray     = json_decode(json_encode($projectDetail), true);
            $projectId      = array_map(fn ($index) => $index['project_id'], $objToArray);
            $projectList    = array_map(fn ($index) => $this->taskSummary($index), $projectId);
            $sprintName     = array_map(fn ($index) => $this->sprintName($index), $projectId);

            $taskSum = array_map(fn ($index) => array_map(
                fn ($title) => $title['task_summary'],
                $index
            ), json_decode(json_encode($projectList), true));

            $sprName = array_map(fn ($index) => array_map(
                fn ($title) => $title['sprint_name'],
                $index
            ), json_decode(json_encode($sprintName), true));

            $title = array_map(fn ($index) => $index['project_name'], $objToArray);
            $sprint = array_map(fn ($index) => $index[0], $sprName);

            $array[] = [
                'name' => $each->assignee_name,
                'details' => $this->mergeProjectArray($title, $sprint, $taskSum)
            ];
        }
        return $array;
    }

    private function mergeProjectArray(array $title, array $sprint, array $task): array
    {
        $result = [];
        for ($i = 0, $j = count($title); $i < $j; $i++) {
            $result[$i] = [
                'title'     => $title[$i],
                'sprint'    => $sprint[$i],
                'task'      => $task[$i],
            ];
        }
        return $result;
    }

    public function structureArray()
    {
        return $this->finalTask();
    }

    public function loadTaskDetails()
    {
        return  DailyTask::join('assignees', 'assignees.account_id', '=', 'daily_tasks.assignee_id')
                        ->select('daily_tasks.task_summary', 'daily_tasks.assignee', 'daily_tasks.project_name', 'daily_tasks.sprint_name')
                        // ->distinct('assignee')
                        ->get();
    }

    public function letsMergeArray()
    {
        $array = [];
        $sum = [];
        return $taskDetails = $this->loadTaskDetails();
        foreach ( $taskDetails as $taskDetail) {
            $array['sum'] = $taskDetail->task_summary;
        }
        return $array;

        /*$array[] = [
            'name' => $taskDetail->assignee,
            'details' => $this->mergeProjectArray($taskDetail->project_name, $taskDetail->sprint_name, $taskDetail->task_summary)
        ];*/
    }
}
