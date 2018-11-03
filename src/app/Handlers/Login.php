<?php
/**
 * Created by Satheesh Thangavel
 * User: bml
 * Date: 11/3/18
 * Time: 12:13 PM
 */

namespace Detectify\Handlers;

use Detectify\Models\User;
use Detectify\Support\Request;
use Detectify\Support\Response;
use Detectify\Support\Session;

class Login extends Handler
{
    const FIRST_NAME = 'firstname';
    const LAST_NAME = 'lastname';
    const PASSWORD = 'password';
    const EMAIL = 'email';

    /**
     * @param Request $payload
     */
    public function home(Request $payload){
        \Detectify\Alice\Login::get()->home();
    }

    /**
     * @param Request $request
     */
    public function auth(Request $request)
    {
        $data = [
            self::PASSWORD => $request->payload->password,
            self::EMAIL    => $request->payload->identifier
        ];
        if($this->notNullValidation($data, [self::PASSWORD, self::EMAIL])){
            $user = new User();
            if($id_user = $user->checkAuth($data)){
                //Set session
                $session = Session::getInstance();
                $session -> startSession();
                $session -> set(self::EMAIL,$data[self::EMAIL]);
                $session -> set("user", $id_user);
                Response::redirect('/dashboard');

            }else{
                Response::json(self::SUCCESS_FALSE, 401);
            }
        }else{
            Response::json(self::SUCCESS_FALSE, 400);
        }
    }

    /**
     * @param Request $request
     */
    public function register(Request $request)
    {
        if($request->method == 'post'){ /** Register new user */
            $data = [
                self::FIRST_NAME => $request->payload->firstname ?? null,
                self::LAST_NAME  => $request->payload->lastname ?? null,
                self::PASSWORD   => $request->payload->password ?? null,
                self::EMAIL      => $this->validateEmail($request->payload->email)?$request->payload->email:null
            ];

            if($this->notNullValidation($data, [self::FIRST_NAME, self::LAST_NAME, self::PASSWORD, self::EMAIL])){
                $data[self::PASSWORD] = md5($data[self::PASSWORD]);
                $user = new User();
                $success = $user->create($data);
            }else{
                $success = false;
            }

            if($success){
                Response::json(self::SUCCESS);
            }else{
                Response::json(self::SUCCESS_FALSE, 400);
            }
        }else{ /** Server registration form */
            \Detectify\Alice\Login::get()->register();
        }

    }

    public function logout(Request $request)
    {
        session_start();
        session_destroy();
        Response::redirect("/home");
    }

    /**
     * @param $email
     * @return mixed
     */
    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}