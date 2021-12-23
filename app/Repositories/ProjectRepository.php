<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Group;
use App\Models\Assignee;

class ProjectRepository extends JiraApiRepository
{

    /**
     * Get all project from DB
     */
    public function fetchAllProjectsFromDB( $project_type = '' )
    {
        #used eloquent scope
        $query = Project::query();

        if ( ! empty($project_type) ) {

            $query->where('project_type', $project_type);
        }
        $data['projects']    = $query->selectAll()->get();
        $data['projectType'] = Project::selectDistinct()->get();
        return $data;
    }

    /**
     * Fetch All Jira Projects From Jira Borad Via API
     * And Update them to DB
     * @return array
     */
    public function updateEveryProject()
    {
        $url      = $this->baseUrl . 'project/search';
        $projects = $this->getJiraApiResponse($this->email, $this->password, $url);

        foreach( $projects->values AS $eachProject) {
            $oldProject = Project::where('project_key', '=', $eachProject->key)->first();

            if ( isset($oldProject) && !empty($oldProject)) {

                $oldProject->project_id   = $eachProject->id;
                $oldProject->project_key  = $eachProject->key;
                $oldProject->project_name = $eachProject->name;
                $oldProject->project_type = isset($eachProject->projectCategory) ? $eachProject->projectCategory->name : null;
                $oldProject->updated_at   = now()->toDateTimeString();
                $oldProject->save();

            } else {

                $newproject = new Project();
                $newproject->project_id   = $eachProject->id;
                $newproject->project_key  = $eachProject->key;
                $newproject->project_name = $eachProject->name;
                $newproject->project_type = isset($eachProject->projectCategory) ? $eachProject->projectCategory->name : null;
                $newproject->created_at   = now()->toDateTimeString();
                $newproject->save();
            }

        }
    }

    public function updateProjectStautus($status, $id)
    {
        $projectState = Project::where('project_id', $id)->first();
        if ( $status == 'Tracked'){
            $projectState->project_status_on_pmo = 'Untracked';
        }
        if ( $status == 'Untracked') {
            $projectState->project_status_on_pmo = 'Tracked';
        }
        return $projectState->save();
    }

    public function updateEveryGroup()
    {
        $url  = $this->baseUrl . 'groups/picker';
        $resp = $this->getJiraApiResponse($this->email, $this->password, $url);

        $newgroup = [];
        foreach ($resp->groups as $group) {

            $oldGroupData = Group::where('group_id', $group->groupId)->first();

            if ( isset($oldGroupData) && ! empty($oldGroupData ) ) {
                $oldGroupData->name         = $group->name;
                $oldGroupData->group_id     = $group->groupId;
                $oldGroupData->updated_at   = now()->toDateTimeString();
                $oldGroupData->save();

            } else {
                $newgroup [] = [
                    'name'       => $group->name,
                    'group_id'   => $group->groupId,
                    'created_at' => now()->toDateTimeString(),
                ];
            }
        }
        Group::insert($newgroup);
    }



    public function updateEveryUser()
    {
        $url  = $this->baseUrl . 'users';
        $url  = $this->baseUrl . 'user/groups?accountId=5c728f65c82a9a36251e55cd';
        $url  = $this->baseUrl . 'users/search';

        $userResp = $this->getJiraApiResponse($this->email, $this->password, $url);
        $userInfo = [];
        foreach ( $userResp as $user ) {

            $url  = $this->baseUrl . 'user/groups?accountId='. $user->accountId;
            $groupResponse = $this->getJiraApiResponse($this->email, $this->password, $url);

            $oldAssignee = Assignee::where('account_id',  $user->accountId)->first();

            foreach ( $groupResponse as $group ) {

                if ( isset($oldAssignee) && !empty($oldAssignee) ){

                    $oldAssignee->group_name = $group->name;
                    $oldAssignee->account_id = $user->accountId;
                    $oldAssignee->assignee_name = $user->displayName;
                    $oldAssignee->email_id = isset($user->emailAddress) ? $user->emailAddress : 'No Email';
                    $oldAssignee->active_status = $user->active;
                    $oldAssignee->account_type = $user->accountType;
                    $oldAssignee->updated_at = now()->toDateTimeString();
                    $oldAssignee->save();

                } else {

                    $userInfo [] = [
                        'group_name' => $group->name,
                        'account_id' => $user->accountId,
                        'assignee_name' => $user->displayName,
                        'email_id' => isset($user->emailAddress) ? $user->emailAddress : 'No Email',
                        'active_status' => $user->active,
                        'account_type' => $user->accountType,
                        'created_at' => now()->toDateTimeString(),
                    ];
                }

            }
        }
        Assignee::insert($userInfo);
    }

    public function loadProjectVaiAajaxCall( $project_type )
    {
        $query = Project::query();
        if ( !empty( $project_type ) ) {
            $query->where('project_type', $project_type);
        }
        return $query->get();
    }

}
