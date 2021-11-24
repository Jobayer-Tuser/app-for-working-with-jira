<?php
require_once './vendor/autoload.php';
require_once './database/CreateUsersTable.php';
use App\Http\Controller\Controller;
 
// spl_autoload_register( function( $class ) {
//     $classPath = './database/'. $class . '.php';
//     if ( ! class_exists( $classPath ) ) {
//         require_once( $classPath );
//     }
// });
    
$email      = 'nirjhor@joomshaper.com'; 
$password   = 'f24V97nmlmBsnH5reM0mD42E';
$currentProjectId = "CF7";
$headers    = array('Accept' => 'application/json');
$baseUrl    = "https://ollyo.atlassian.net/rest/api/3/";
$requestUrl = "search?jql=project=". $currentProjectId;    
$finalUrl   = $baseUrl . $requestUrl;   

$ctrl = new Controller();
$ctrl->getDataFromDB();

$createUser = new CreateUsersTable();

try{
    // $createUser->up();
    
} catch (\Exception $error){
    echo "Error: ".$error->getMessage();
}

