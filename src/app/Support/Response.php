<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 10/31/18
 * Time: 4:56 PM
 */

namespace Detectify\Support;

/**
 * Essentially this class should be called for any type of response returned to the caller
 * Class Response
 * @package Detectify\Support
 */
class Response
{
    /**
     * Print json
     * @param @array $data
     * @param int $responseCode
     */
    public static function json(array $data,$responseCode = 200)
    {
        http_response_code($responseCode);
        echo json_encode($data);
    }

    /**
     * Checks if the object is an exception
     * @param $data
     * @return bool
     */
    public static function isException($data)
    {
        return $data instanceof \Exception;
    }

    /**
     * Intended to render exception with some nice UI
     * @param \Exception $exception
     */
    public static function renderException($exception)
    {
        http_response_code($exception->getCode());
        echo $exception->getMessage();
    }

    /**
     * Redirects requests
     * @param $path
     * @param int $responseCode
     */
    public static function redirect($path , $responseCode = 200)
    {
        http_response_code($responseCode);
        header("location: ".$path);
    }
}