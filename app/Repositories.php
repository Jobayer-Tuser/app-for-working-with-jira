<?php

namespace App;

use Unirest\Request as Request;

class Repositories {

    private $email; 
    private $password;
    private $headers;
    private $finalUrl;

    public function __construct($email, $password, $headers, $finalUrl) {
        
        $this->email    = $email;
        $this->password = $password;
        $this->headers  = $headers;
        $this->finalUrl = $finalUrl;

    }
    
    public function parseAllData() {

        
        Request::auth( $this->email, $this->password );

        $response = Request::get( $this->finalUrl, $this->headers );

        foreach($response->body->issues AS $issues)
        {
            // dump( $issues->fields->customfield_10020 );

            $requiredData = array(
                'project_name'        => $issues->fields->project->name,
                'sprint_name'         => $issues->fields->customfield_10020, // this field has multiple array need to check
                'task_current_status' => $issues->fields->status->name,
                'task_name'           => $issues->fields->summary,
                'asigned_person'      => $issues->fields->assignee->displayName,
                'task_start_date'     => $issues->fields->customfield_10020[0]->startDate,
                'tast_end_date'       => $issues->fields->customfield_10020[0]->endDate,
            );

            dump( $requiredData );
        }
    }
}