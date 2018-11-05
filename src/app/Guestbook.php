<?php
/**
 * Created by Satheesh Thangavel.
 * Date: 11/2/18
 * Time: 3:07 PM
 *
 * This class to be the entry point to the Guestbook.
 */
namespace Detectify;

use Detectify\Support\Request;
use Detectify\Support\Response;
use Detectify\Support\RoutingManager;
use Detectify\Support\Session;
use Detectify\Traits\Config;
use Detectify\Traits\Env;

/**
 * The application class
 * @package Detectify
 */
class Guestbook
{
    use Env,Config;

    /**
     * Environment file path
     */
    const ENV_FILE_PATH = '../.env';

    /**
     * Guestbook constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Initialize the application
     */
    public function init()
    {
        try {
            $this->loadEnv(self::ENV_FILE_PATH);
            list( $handler, $action, $auth) = RoutingManager::get()->getHandler();
            if($auth){
                $session = Session::getInstance();
                $session -> startSession();
                if(!$session->isLoggedIn()){
                    return Response::redirect("/home");
                }
            }
            $this->run($handler, $action, RoutingManager::get()->request);
        }catch(\Exception $exception){
            Response::renderException($exception);
        }
    }

    /**
     * @param $handler
     * @param $action
     * @param Request $request
     */
    public function run($handler, $action, Request $request)
    {
        $class = $this->getHandlerClassName($handler);
        $handlerObject = new $class();
        $handlerObject->{$action}($request);
    }

    /**
     * Returns full class name (includes namespace)
     * @param $className
     * @return string
     */
    public function getHandlerClassName($className)
    {
        $namespace = "Detectify\Handlers";
        return $namespace.'\\'.$className;
    }
}