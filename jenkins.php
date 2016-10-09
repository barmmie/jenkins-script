#!/usr/bin/php
<?php

use Cli\JenkinServer;
use Cli\Job;
use Cli\SqliteDb;

define('TABLE_NAME', 'jenkins_jobs');

define('DEFAULT_SQLITE_DB_PATH', './jenkins.db');

define('DEFAULT_SERVER_URL', 'https://builds.apache.org/');


require "vendor/autoload.php";


$server = DEFAULT_SERVER_URL;
$db_path = DEFAULT_SQLITE_DB_PATH;

if(isset($argv[1])) {
    $server = $argv[1];
}

if(isset($argv[2])) {
    $db_path = $argv[2];
}

$jenkins = new JenkinServer($server);

$jenkins_jobs = $jenkins->getJobs();


if( count($jenkins_jobs) > 0) {

    $db = SqliteDb::instance($db_path);
    $conn = $db->getConnection();

    foreach ($jenkins_jobs as $jenkins_job) {

        $job = new Job($conn);
        
        $job->insert([
            'name' => $jenkins_job->name,
            'status' => $jenkins_job->status
        ]);

    }

}






