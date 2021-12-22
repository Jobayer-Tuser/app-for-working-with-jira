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
            // return $eachProject;
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
        // $projectState = $projectState[0];
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
        // Group::whereNotNull('id')->delete();
        foreach ($resp->groups as $group) {

            $oldGroupData = Group::where('group_id', $group->groupId)->first();

            if ( isset($ollGroupData) && !empty($oldGroupData) ) {
                $ollGroupData->name = $group->name;
                $ollGroupData->group_id = $group->groupId;
                $ollGroupData->updated_at = now()->toDateTimeString();
                $ollGroupData->save();

            } else {

                $newgroup [] = [
                    'name'      => $group->name,
                    'group_id'  => $group->groupId,
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
        // $url  = $this->baseUrl . 'user?accountId=5c728f65c82a9a36251e55cd';
        //https://ollyo.atlassian.net/rest/api/2/user/groups?accountId=5c728f65c82a9a36251e55cd'

        // return $userResp = $this->getJiraApiResponse($this->email, $this->password, $url);

        $userResp = $this->getJiraApiResponse($this->email, $this->password, $url);
        $userInfo = [];
        foreach ( $userResp as $user ) {

            $url  = $this->baseUrl . 'user/groups?accountId='. $user->accountId;
            $groupResponse = $this->getJiraApiResponse($this->email, $this->password, $url);

            $oldAssignee = Assignee::where('account_id',  $user->accountId)->first();

            $userGroup = [];
            foreach ( $groupResponse as $group ) {

                $userGroup [] = $group->name;

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
            // var_dump($userGroup);
            // return $userGroup;

        }
        // var_dump($userInfo);
        Assignee::insert($userInfo);
    }

}
