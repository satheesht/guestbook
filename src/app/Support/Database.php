<?php
/**
 * User: Satheesh Thangavel
 * Date: 10/31/18
 * Time: 4:22 PM
 */
namespace Detectify\Support;

use Detectify\Traits\Config;

/**
 * Role of this class is just extend MySQLi and connect to the
 * Guestbook database as soon as the caller creates an instance
 *
 * NOTE: This is an singleton means, it will not try to connect to database more than once
 * in the entire life cycle of a single request
 *
 * Class Database
 * @package Detectify\Support
 */
class Database extends \mysqli{

    use Config;

    /**
     * Current instance is stored
     * @var null
     */
    private static $instance = null ;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        try {
            $this->loadConfig();
            $host     = $this->config->database->host;
            $username = $this->config->database->username;
            $password = $this->config->database->password;
            $port     = $this->config->database->port;
            $database = $this->config->database->database;
            parent::__construct($host, $username, $password, $database, $port);
        }catch(\Exception $exception){
            Response::renderException($exception);
        }
    }

    /**
     * Gives instancees of this Database class ensures  it's singleton
     * @return Database|null
     */
    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance ;
    }

    /**
     * This function meant to buid query based on type passed to it.
     * Intend to scale further, for now, only supports insert query
     * @param $type
     * @param $table
     * @param $data
     * @return null|string
     */
    public function buildQuery($type, $table, $data)
    {
        $query = null;
        switch($type){
            case "insert":
                $query = 'INSERT INTO '.$table.'('.implode(',',array_keys($data)).')VALUES("'.implode('","',array_values($data)).'")';
        }

        return $query;
    }
}