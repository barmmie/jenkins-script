<?php

namespace Cli;

class Job {

    private $name;
    private $status;
    private $connection;

    public function __construct(\PDO $connection)
    {

        $this->connection = $connection;
    }



    public function insert($array)
    {

        try {
            $query = $this->connection->prepare(
                'INSERT OR REPLACE INTO '.TABLE_NAME.' (name, status, time_checked) VALUES (?, ?, ?)');
            if($query) {
                $query->execute(array($array['name'], $array['status'], date("Y-m-d H:i:s")));

            } else {
                print "Error connecting into database".PHP_EOL;
            }

        } catch (\PDOException $e) {
            print "Error inserting job: {$this->name}".PHP_EOL;
        }

    }
}