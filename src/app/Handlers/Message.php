<?php
/**
 * Created by Satheesh Thangavel
 * User: bml
 * Date: 11/3/18
 * Time: 12:13 PM
 */

namespace Detectify\Handlers;

use Detectify\Support\Request;
use Detectify\Support\Response;
use Detectify\Support\Session;

class Message extends Handler
{
    const MESSAGE = 'text';
    const ID_USER = 'id_user';

    /**
     * @param Request $request
     */
    public function newMessage(Request $request)
    {
        $data = [
            self::MESSAGE => $request->payload->message,
            self::ID_USER => Session::getUserId()
        ];
        if($this->notNullValidation($data, [self::MESSAGE, self::ID_USER])){
            $message = new \Detectify\Models\Message();
            if($message->create($data)){
                Response::json(self::SUCCESS, 200);
            }else{
                Response::json(self::SUCCESS_FALSE, 500);
            }
        }else{
            Response::json(self::SUCCESS_FALSE, 400);
        }
    }

    /**
     * @param Request $request
     */
    public function editMessage(Request $request)
    {
        $data = [
            self::MESSAGE   => $request->payload->message,
            self::ID_USER   => Session::getUserId(),
            "id"            => $request->payload->id
        ];
        if($this->notNullValidation($data, [self::MESSAGE, self::ID_USER, "id"])){
            $message = new \Detectify\Models\Message();
            if($message->editMessage($data)){
                Response::json(self::SUCCESS, 200);
            }else{
                Response::json(self::SUCCESS_FALSE, 500);
            }
        }else{
            Response::json(self::SUCCESS_FALSE, 400);
        }
    }

    /**
     * @param Request $request
     */
    public function deleteMessage(Request $request)
    {
        $data = [
            self::ID_USER   => Session::getUserId(),
            "id"            => $request->payload->id
        ];
        if($this->notNullValidation($data, [self::ID_USER, "id"])){
            $message = new \Detectify\Models\Message();
            if($message->deleteMessage($data)){
                $result = $message->getReplies(['id_message' => $request->payload->id]);
                Response::json($result);
            }else{
                Response::json(self::SUCCESS_FALSE, 500);
            }
        }else{
            Response::json(self::SUCCESS_FALSE, 400);
        }
    }

    /**
     * @param Request $request
     */
    public function replyMessage(Request $request)
    {
        $data = [
            self::MESSAGE   => $request->payload->message,
            self::ID_USER   => Session::getUserId(),
            "id_message"    => $request->payload->id
        ];

        if($this->notNullValidation($data, [self::ID_USER, "id_message", "text"])){
            $message = new \Detectify\Models\Message();
            if($message->replyMessage($data)){
                $result = $message->getReplies(['id_message' => $request->payload->id]);
                Response::json($result);
            }else{
                Response::json(self::SUCCESS_FALSE, 500);
            }
        }else{
            Response::json(self::SUCCESS_FALSE, 400);
        }
    }

    /**]
     * @param Request $request
     */
    public function getReplies(Request $request)
    {
        $data = [
            "id_message" => $request->payload->messageId
        ];
        if($this->notNullValidation($data, ["id_message"])) {
            $message = new \Detectify\Models\Message();
            $result = $message->getReplies($data);
            Response::json($result);
        }else{
            Response::json(self::SUCCESS_FALSE, 400);
        }
    }

}