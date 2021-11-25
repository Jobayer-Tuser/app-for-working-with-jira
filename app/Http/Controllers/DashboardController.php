<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $email      = 'nirjhor@joomshaper.com';
        $password   = 'f24V97nmlmBsnH5reM0mD42E';
        $currentProjectId = "CF7";
        $headers    = array('Accept' => 'application/json');
        $baseUrl    = "https://ollyo.atlassian.net/rest/api/3/";
        $requestUrl = "search?jql=project=". $currentProjectId;
        $finalUrl   = $baseUrl . $requestUrl;

        $email = "nirjhor@joomshaper.com";
        $password = "f24V97nmlmBsnH5reM0mD42E";
        $url = "https://ollyo.atlassian.net/rest/api/3/search?jql=project=CF7";

        $response = Http::withBasicAuth($email, $password)->get($url)->body();
        $response = json_decode($response);

        foreach($response->issues AS $issues)
        {
            $requiredData = array(
                'project_name'        => $issues->fields->project->name,
                'sprint_name'         => $issues->fields->customfield_10020, // this field has multiple array need to check
                'task_current_status' => $issues->fields->status->name,
                'task_name'           => $issues->fields->summary,
                'asigned_person'      => $issues->fields->assignee->displayName ?? null,
                'task_start_date'     => $issues->fields->customfield_10020[1]->startDate ?? null,
                'tast_end_date'       => $issues->fields->customfield_10020[1]->endDate ?? null,
            );

            echo "<pre>";
            print_r( $requiredData  );
            echo "</pre>";
        }
        return view('projects.layouts.master');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
