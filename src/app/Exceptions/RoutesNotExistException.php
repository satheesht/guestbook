<?php
/**
 * Created by Satheesh Thangavel.
 * Date: 11/2/18
 * Time: 3:26 PM
 */
namespace Detectify\Exceptions;

class RoutesNotExistException extends \Exception
{
    protected $message = "Requested URI is not found";
    protected $code = 404;
}