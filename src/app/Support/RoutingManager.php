<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/2/18
 * Time: 5:40 PM
 */

namespace Detectify\Support;

use Detectify\Exceptions\RoutesNotExistException;
use Detectify\Traits\Config;

/**
 * Responsible for request handling and returns handler to the app class
 * Class RoutingManager
 * @package Detectify\Support
 */
class RoutingManager
{
    use Config;

    protected $routes;

    /**
     * Request object
     * @var Request
     */
    public $request;

    /**
     * These are the available verbs.
     * Add more when you try to add new endpoints
     * @var array
     */
    protected $allowedHttpVerbs = [
        "get",
        "post",
        "delete",
        "put"
    ];

    /**
     * Request http verb
     * @var
     */
    protected $reqMethod;

    /**
     * RoutingManager constructor.
     */
    public function __construct()
    {
        $this->loadRequestObject();
        try {
            $this->parseRoutes($this->getRoutes());
        }catch(\Exception $exception) {
            Response::renderException($exception);
        }
    }

    /**
     * Call this method to get singleton
     *
     * @return RoutingManager|null
     */
    public static function get()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new RoutingManager();
        }
        return $instance;
    }

    /**
     * Raw routes, parse it to route property
     * @param $rawRoutes
     * @throws RoutesNotExistException
     */
    private function parseRoutes($rawRoutes)
    {
        if(!empty($rawRoutes)) {
            $configRoutes = $this->config->routes;
            foreach ($this->allowedHttpVerbs as $verb) {
                foreach($configRoutes->{$verb} as $data){
                    $this->routes[$verb][$data->uri] = [$data->handler, $data->action, $data->auth];
                }
            }
        }else{
            $this->throw404();
        }
    }

    /**
     * Constructs request object
     */
    public function loadRequestObject()
    {
        $reqLocalObject = new Request();
        $reqLocalObject->method = strtolower($_SERVER['REQUEST_METHOD']);
        list($uri, $query) = explode("?",$_SERVER['REQUEST_URI']);
        $reqLocalObject->uri = $this->removeTrailingSlash($uri);
        $reqLocalObject->payload = $this->getPayload();
        $this->request = $reqLocalObject;
    }

    /**
     * Returns Handler
     * @return mixed
     * @throws RoutesNotExistException
     */
    public function getHandler()
    {
        $this->reqMethod    = $this->request->method;
        $requestUri         = $this->request->uri;
        $handler            = $this->routes[$this->reqMethod][$requestUri];
        if(empty($handler)){
            $this->throw404();
        }
        return $handler;
    }

    /**
     * Parse payload
     * @return mixed|object
     */
    public function getPayload()
    {
        if(in_array($this->reqMethod,['get','delete'])){
            return (object) $_REQUEST;
        }else{
            $request_body = json_decode(file_get_contents('php://input'));
            if(empty($request_body)){
                return (object) $_REQUEST;
            }
            return $request_body;
        }
    }

    /**
     * 404 thrower
     * @throws RoutesNotExistException
     */
    private function throw404(){
        throw new RoutesNotExistException();
    }

    /**
     * removes trailing slash from request URI
     * @param $string
     * @return bool|string
     */
    public function removeTrailingSlash($string)
    {
        if(substr($string, -1) == '/') {
            return substr($string, 0, -1);
        }else{
            return $string;
        }
    }
}