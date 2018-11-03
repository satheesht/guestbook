<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 11:45 AM
 */

namespace Detectify\Alice;


class Login extends Alice
{
    protected $title = 'Detectify Guestbook';

    public function home(){
        $this->addCustomCss(['signin']);
        $this->renderView("loginForm");
    }

    public function register(){
        $this->addCustomCss(['register']);
        $this->renderView("registrationForm");
    }

    public function registerSubmit($payload)
    {

    }

    public static function get()
    {
        return new Login();
    }


}