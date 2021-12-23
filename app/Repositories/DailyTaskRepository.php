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
    public function updateAllDailyTask() {

        $sql = " SELECT `project_key` from `projects` where `last_sync` <= DATE_SUB(NOW(), INTERVAL 5 MINUTE) ";
        $projectKeys = DB::select($sql);

        $$newTask = [];
        foreach ($projectKeys as $eachKey) {

            # Parse the full url to fetch every task for single project
            $url = $this->finalUrl . $eachKey->project_key;
            $response = $this->getJiraApiResponse($this->email, $this->password, $url);

            if (isset($response->issues)) {
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

                        $oldDailyTask->project_key      = $issue->fields->project->key;
                        $oldDailyTask->project_name     = $issue->fields->project->name;
                        $oldDailyTask->sprint_name      = $sprintName ?? 'No Name';
                        $oldDailyTask->task_status      = $issue->fields->status->name;
                        $oldDailyTask->task_summary     = $issue->fields->summary;
                        $oldDailyTask->assignee_id      = $issue->fields->assignee->accountId ?? 'No ID';
                        $oldDailyTask->assignee         = $issue->fields->assignee->displayName ?? 'No One Assigned';
                        $oldDailyTask->task_start_date  = $startDate ?? null;
                        $oldDailyTask->task_end_date    = $endDate ?? null;
                        $oldDailyTask->updated_at       = date('Y-m-d H:i:s');
                        $oldDailyTask->save();

                        Project::where('project_key', $eachKey->project_key )->update(['last_sync' => now()]);

                    } else {

                        $newTask [] = [
                            'project_id'        => $issue->fields->project->id,
                            'project_key'       => $issue->fields->project->key,
                            'project_name'      => $issue->fields->project->name,
                            'sprint_name'       => $sprintName ?? 'No Name',
                            'task_status'       => $issue->fields->status->name,
                            'task_summary'      => $issue->fields->summary,
                            'assignee_id'       => $issue->fields->assignee->accountId ?? 'No ID',
                            'assignee'          => $issue->fields->assignee->displayName ?? 'No One Assigned',
                            'task_start_date'   => $startDate ?? null,
                            'task_end_date'     => $endDate ?? null,
                            'created_at'        => now()->toDateTimeString(),
                        ];
                        Project::insert(['last_sync' => now()]);
                    }
                }
            }
        }
        DailyTask::insert($newTask);

    }

    /**
     * Delete the Completed Task from Database
     *
     * @return void
     */
    public function deleteCompleteTask()
    {
        DailyTask::where('task_status', '=', 'Done')->delete();
    }

    public function getDailyTaskReportViaAjaxCall( $group_name = null, $project_name = null, $project_status = null )
    {
        $taskAssignee = Assignee::join('daily_tasks', 'daily_tasks.assignee_id', '=', 'assignees.account_id')
                            ->distinct('assignees.assignee_name')
                            ->where('assignees.account_type', 'atlassian')
                            ->select('assignees.assignee_name', 'assignees.group_name', 'daily_tasks.task_summary', 'daily_tasks.sprint_name', 'daily_tasks.project_name')
                            ->get();

    }
}
