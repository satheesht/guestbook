<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 11:45 AM
 */

namespace Detectify\Alice;


class Dashboard extends Alice
{
    protected $title = 'Detectify Guestbook';

    public function home($messages)
    {
        $this->addCustomCss(['dashboard']);
        $this->addCustomJs(['dashboard']);
        $messageHtml = $this->getHtml('message');
        $html = null;
        foreach($messages as $message){
            $html.=$this->applyData($messageHtml,[
                "firstname" => ucfirst($message[2]),
                "lastname"  => ucfirst($message[3]),
                "message"   => $message[0],
                "messageId" => $message[1]
            ]);
        }
        $dashboardHtml = $this->getHtml("dashboard");
        $finalHtml = $this->applyData($dashboardHtml, [
            "messages" => $html
        ]);
        $this->renderHtml($finalHtml);
    }

    public static function get()
    {
        return new Dashboard();
    }
}