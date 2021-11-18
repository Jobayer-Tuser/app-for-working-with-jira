<?php

error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once './vendor/autoload.php';

use Jenssegers\Blade\Blade;
use App\Database;
use App\Repositories;
use App\ZiraAPI;

    
$email      = 'nirjhor@joomshaper.com'; 
$password   = 'f24V97nmlmBsnH5reM0mD42E';
$currentProjectId = "CF7";
$headers    = array('Accept' => 'application/json');
$baseUrl    = "https://ollyo.atlassian.net/rest/api/3/";
$requestUrl = "search?jql=project=". $currentProjectId;    
$finalUrl   = $baseUrl . $requestUrl;   

$ziraApi = new ZiraAPI();

// $ziraApi->getProjectInfo( $email, $password, $headers, $finalUrl);


$blade = new Blade('resource/views', 'resource/cache');

echo $blade->render('homepage', ['name' => 'John Doe']);

