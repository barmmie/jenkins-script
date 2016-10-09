<?php namespace Cli;
use PDO;


class SqliteDb
{
    private static $instance = NULL;
    private $db_path;
    private $db;

    private function __construct($db_path) {
        $this->db_path = $db_path;
        $this->init();
    }

    public static function instance($db_path){
        if( self::$instance == NULL) {
            self::$instance = new self($db_path);
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }


    /**
     * Initialize database. Create a new database if one does not already exist
     *
     */
    public function init()
    {

//        if (! file_exists($this->db_path) ){
//            touch($this->db_path);
//        }

        $this->db = new PDO("sqlite:$this->db_path");

        try {
            $this->db->exec('
            CREATE TABLE IF NOT EXISTS '.TABLE_NAME.' (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL , 
            status TEXT, 
            time_checked TIMESTAMP DEFAULT current_timestamp
            )');
        } catch(\PDOException $e) {
            die('Error setting up database: '. $e->getMessage());
        }
    }

    private function __clone() { }


}