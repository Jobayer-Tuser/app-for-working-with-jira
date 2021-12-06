<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\DailyTask;
use App\Models\Project;


class DailyTaskRepository extends JiraApiRepository
{
    public function getAllTask( $key, $assignee = null, $tastState = null, $spintName = null )
    {
        $query = DailyTask::where('project_key', $key);

        if( isset($assignee) ) {
            $query->where('assignee', $assignee);
        }
        if( isset($tastState) ) {
            $query->where('task_status', $tastState);
        }
        if( isset($spintName) ) {
            $query->where('sprint_name', $spintName);
        }

        $data['tasks']          = $query->get();
        $data['tastState']      = DailyTask::getTaskState()->get();
        $data['sprintName']     = $query->select('sprint_name')->distinct()->get();
        $data['projectKey']     = $key;
        $data['assignedPerson'] = $query->select('assignee')->distinct()->get();

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
        #parse all project key from database
        $projectKeys = Project::select('project_key')->get();

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
                    $oldDailyTask = DailyTask::where('project_key', '=', $issue->fields->project->key)->first();

                    #get the old daily task value and update them
                    if ($oldDailyTask) {

                        $oldDailyTask->project_id      = $issue->fields->project->id;
                        $oldDailyTask->project_key     = $issue->fields->project->key;
                        $oldDailyTask->project_name    = $issue->fields->project->name;
                        $oldDailyTask->sprint_name     = $sprintName ?? 'No Name';
                        $oldDailyTask->task_status     = $issue->fields->status->name;
                        $oldDailyTask->task_summary    = $issue->fields->summary;
                        $oldDailyTask->assignee        = $issue->fields->assignee->displayName ?? 'No One Assigned';
                        $oldDailyTask->task_start_date = $startDate ?? null;
                        $oldDailyTask->task_end_date   = $endDate ?? null;
                        $oldDailyTask->created_at      = date('Y-m-d H:i:s');
                        $oldDailyTask->save();
                    } else {

                        # insert tha new daily task data daily_task table
                        $dailyTask = new DailyTask();
                        $dailyTask->assignee        = $issue->fields->assignee->displayName ?? 'No One Assigned';
                        $dailyTask->project_id      = $issue->fields->project->id;
                        $dailyTask->project_key     = $issue->fields->project->key;
                        $dailyTask->sprint_name     = $sprintName ?? 'No Name';
                        $dailyTask->task_status     = $issue->fields->status->name;
                        $dailyTask->project_name    = $issue->fields->project->name;
                        $dailyTask->task_summary    = $issue->fields->summary;
                        $dailyTask->task_start_date = $startDate ?? null;
                        $dailyTask->task_end_date   = $endDate ?? null;
                        $dailyTask->created_at      = date('Y-m-d H:i:s');
                        $dailyTask->save();
                    }
                }
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
        DailyTask::where('task_status', '=', 'Done')->destroy();
    }
}
