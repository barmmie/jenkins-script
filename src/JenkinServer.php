<?php

namespace Cli;
/**
 * Created by PhpStorm.
 * User: barmmie
 * Date: 03/10/2016
 * Time: 9:28 PM
 */
class JenkinServer
{

    private $server_url;

    public function __construct($server_url)
    {
        $this->server_url = $this->formatServerUrl($server_url);
        $this->curl = curl_init();
        $this->setUp();
    }

    public function getJobs() {
        $jobs = [];
        $response = curl_exec($this->curl);

        if( !$response ){
            $error = curl_error($this->curl);
            $code = curl_errno($this->curl);
            die("Error connecting to {$this->server_url}. \n Error message: {$error}. \n Error code: {$code}");
        }

        $response = json_decode($response, true);

        $jobs_array = $response["jobs"];

        foreach ($jobs_array as $job_array) {
            array_push($jobs, $this->formatJob($job_array));
        }

        $this->tearDown();

        return $jobs;
    }

    private function formatJob($job) {
        $job_object = new \stdClass();
        $job_object->name = '';
        $job_object->status = '';

        if(array_key_exists('name', $job)) {
            $job_object->name = $job->name;
        }

        if(array_key_exists('lastBuild', $job) &&
            is_array($job['lastBuild']) &&
            array_key_exists('result', $job['lastBuild'])) {

            $job_object->status = $job['lastBuild']['result'];
        }

        return $job_object;
    }

    private function formatServerUrl($url)
    {
        $url = rtrim($url, '/');
        return "{$url}/api/json?tree=jobs[name,lastBuild[result]]";
    }

    private function setUp() {
        curl_setopt_array( $this->curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => true,
            CURLOPT_URL => $this->server_url,
            CURLOPT_SSL_VERIFYPEER => false
        ));
    }

    private function tearDown()
    {
        curl_close($this->curl);
    }
}