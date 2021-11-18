<?php

namespace App;

use App\Repositories;

class ZiraAPI {

    /**
     * All credential for zira api
     * 
     * https://joomshaperbangladesh.atlassian.net/rest/api/3/search?jql=project=COFR
     * 
     * Main credential
     * Email: 'nirjhor@joomshaper.com';
     * Pass : 'f24V97nmlmBsnH5reM0mD42E';
     * 
     * Alternate email password
     * Email : "nirjhor.anjum@gmail.com";
     * Pass : "CAA9OwwlCOxS2bkclNIr35A7";
     * 
     * */
    // private $repositories;

    // public function __construct(Repositories $repositories) {

    //     $this->repositories = $repositories;
    //     $this->repositories();

    //     Unirest\Request::auth( $this->email, $this->password);
    // }

    public function getProjectInfo($email, $password, $headers, $finalUrl) {

        $getResponse = new Repositories($email, $password, $headers, $finalUrl);
        $getResponse->parseAllData();
    }

}