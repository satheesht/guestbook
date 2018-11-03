<?php
/**
 * Created by Satheesh Thangavel.
 * Date: 11/2/18
 * Time: 3:54 PM
 */
namespace Detectify\Exceptions;

class CouldNotSetEnvException extends \Exception
{
    protected $message = "Couldn't set environment variables. Please check the file is exists, readable and valid";
    protected $code = 500;
}