<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 7:44 PM
 */

namespace Detectify\Support;


class Session
{
    private static $instance;

    private $sessionState = false;

    //12 hours session life
    private $sessionConfig = [
        'cookie_lifetime' => 43200
    ];

    /**
     * @return Session
     */
    public static function getInstance()
    {
        if ( !isset(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @return bool
     */
    public function startSession()
    {
        $this->sessionState = session_start($this->sessionConfig);

        return $this->sessionState;
    }

    /**
     * @return mixed
     */
    public static function getUserId()
    {
        return self::get("user");
    }

    /**
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * @param $name
     */
    public static function delete($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Checks if user logged in
     */
    public function isLoggedIn()
    {
        return !empty($_SESSION['user']) && !empty($_SESSION['email']);
    }
}