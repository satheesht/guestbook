<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 6:23 PM
 */

namespace Detectify\Models;


use Detectify\Support\Database;

class User extends Sanitizer
{
    protected $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance();
    }

    /**
     * Creates a new user
     * @param $user
     * @return bool|\mysqli_result
     */
    public function create($user)
    {
        $user = $this->sanitizeFields($this->connection, $user);
        $query = $this->connection->buildQuery("insert","users", $user);
        return $this->connection->query($query);
    }

    /**
     * Checks user authentication
     * @param $user
     * @return bool
     */
    public function checkAuth($user)
    {
        $user = $this->sanitizeFields($this->connection, $user);
        $query = 'SELECT id FROM users WHERE email="'.$user['email'].'" AND password = "'.md5($user['password']).'"';
        $result = $this->connection->query($query);
        $row = $result->fetch_assoc();
        return $row['id'] ?? false;
    }
}