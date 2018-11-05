<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 3:56 PM
 */

namespace Detectify\Support;

/**
 * Intend to scale further. Essentially, used to transfer request data between classes
 * Class Request
 * @package Detectify\Support
 */
class Request
{
    public $method;
    public $payload;
    public $uri;
}