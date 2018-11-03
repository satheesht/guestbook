<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 11:30 AM
 */

namespace Detectify\Handlers;


class Handler
{

    const SUCCESS = [ "success" => true ];
    const SUCCESS_FALSE = [ "success" => false ];
    /**
     * @param $data
     * @param $fields
     * @return bool
     */
    public function notNullValidation($data, $fields)
    {
        foreach($fields as $field){
            if(empty($data[$field])){
                return false;
            }
        }
        return true;
    }
}