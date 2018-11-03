<?php
/**
 * Created by Satheesh Thangavel.
 * User: bml
 * Date: 11/2/18
 * Time: 3:34 PM
 */

Trait Utilities{
    function isValidJson( $jsonString ){
        return ( json_decode( $jsonString , true ) == NULL ) ? false : true ; // Yes! thats it.
    }
}
