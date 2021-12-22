<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\DailyTask;
use App\Models\Project;


class DailyTaskRepository extends JiraApiRepository
{
    public function getAllTask($assignee = null, $tastState = null, $spintName = null )
    {
        $query = DailyTask::query();

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

        $newTask = [];
        $oldTask = [];
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
                        $oldTask [] = [
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
                            'updated_at'        => now()->toDateTimeString(),
                        ];

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
                    }
                }
            }
            // var_dump($newTask);
        }
        $chunk = array_chunk( $newTask, sizeof($newTask) );
        // var_dump($chunk); die;
        foreach ( $chunk as $eachChunk ){
            DailyTask::insert($eachChunk);
            // var_dump($each);
        }
        // die; some change
        // var_dump($oldTask);

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

    public function getProjectD()
    {
        # Parse the full url to fetch every task for single project
        $url = $this->finalUrl . 'CF7';
        return $response = $this->getJiraApiResponse($this->email, $this->password, $url);

    }
}
