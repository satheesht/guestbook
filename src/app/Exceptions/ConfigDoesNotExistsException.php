<?php
/**
 * Created by Satheesh Thangavel.
 * Date: 11/2/18
 * Time: 3:26 PM
 */
namespace Detectify\Exceptions;

class ConfigDoesNotExistsException extends \Exception
{
    protected $message = "Config file(config.json) doesn't exist. Please check its existence at /app/config.json";
    protected $code = 500;
}