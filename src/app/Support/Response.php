<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 10/31/18
 * Time: 4:56 PM
 */

namespace Detectify\Support;


class Response
{
    /**
     * @param @array $data
     * @param int $responseCode
     */
    public static function json(array $data,$responseCode = 200)
    {
        http_response_code($responseCode);
        echo json_encode($data);
    }

    /**
     * @param $data
     * @return bool
     */
    public static function isException($data)
    {
        return $data instanceof \Exception;
    }

    /**
     * @param \Exception $exception
     */
    public static function renderException($exception)
    {
        http_response_code($exception->getCode());
        echo $exception->getMessage();
    }

    /**
     * @param $path
     * @param int $responseCode
     */
    public static function redirect($path , $responseCode = 200)
    {
        http_response_code($responseCode);
        header("location: ".$path);
    }
}