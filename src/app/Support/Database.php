<?php
/**
 * User: Satheesh Thangavel
 * Date: 10/31/18
 * Time: 4:22 PM
 */
namespace Detectify\Support;

use Detectify\Traits\Config;

class Database extends \mysqli{

    use Config;

    private static $instance = null ;

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