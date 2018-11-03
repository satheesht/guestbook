<?php
/**
 * Created by Satheesh Thangavel.
 * Date: 11/2/18
 * Time: 3:26 PM
 */
namespace Detectify\Exceptions;

class InvalidConfigException extends \Exception
{
    protected $message = "Config file(config.json) is invalid. Please check";
    protected $code = 500;
}