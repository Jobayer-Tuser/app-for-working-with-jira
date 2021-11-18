<?php

error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once './vendor/autoload.php';
use App\Http\Controller\Controller;

    
$email      = 'nirjhor@joomshaper.com'; 
$password   = 'f24V97nmlmBsnH5reM0mD42E';
$currentProjectId = "CF7";
$headers    = array('Accept' => 'application/json');
$baseUrl    = "https://ollyo.atlassian.net/rest/api/3/";
$requestUrl = "search?jql=project=". $currentProjectId;    
$finalUrl   = $baseUrl . $requestUrl;   

$ctrl = new Controller;
dd($ctrl->getDataFromDB());

