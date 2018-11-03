<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 12:03 PM
 */

namespace Detectify\Exceptions;


class HtmlNotFoundException extends \Exception
{
    protected $message = 'HTML view is  not found';
}