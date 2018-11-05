<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 7:44 PM
 */

namespace Detectify\Support;

/**
 * All session related actions handled here
 * Class Session
 * @package Detectify\Support
 */
class Session
{
    /**
     * Current instance
     * @var
     */
    private static $instance;

    /**
     * Current session state
     * @var bool
     */
    private $sessionState = false;

    /**
     * Session lifetime config
     * @var array
     */
    private $sessionConfig = [
        'cookie_lifetime' => 43200
    ];

    /**
     * Returns instance of session
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
     * Starts a session
     * @return bool
     */
    public function startSession()
    {
        $this->sessionState = session_start($this->sessionConfig);

        return $this->sessionState;
    }

    /**
     * Returns user id (means the user logged in : which is ensured from
     * Login controller, Auth action)
     * @return mixed
     */
    public static function getUserId()
    {
        return self::get("user");
    }

    /**
     * Sets a value to session
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Returns a value from session by name
     * @param $name
     * @return mixed
     */
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * Removes a value from session
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

    /**
     * Destroy the session
     */
    public function destroy()
    {
        $this->startSession();
        session_destroy();
    }
}