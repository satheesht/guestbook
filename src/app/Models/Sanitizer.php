<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 6:34 PM
 */

namespace Detectify\Models;


class Sanitizer
{
    /**
     * Expects associative array
     * @param $link
     * @param $data
     * @return mixed
     */
    public function sanitizeFields($link, $data)
    {
        foreach($data as $field => $datum){
            $data[$field] = mysqli_real_escape_string($link, $data[$field]);
        }

        return $data;
    }
}