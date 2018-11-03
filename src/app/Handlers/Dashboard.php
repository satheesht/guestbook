<?php
/**
 * Created by Satheesh Thangavel
 * User: bml
 * Date: 11/3/18
 * Time: 12:13 PM
 */

namespace Detectify\Handlers;

use Detectify\Support\Request;

class Dashboard extends Handler
{
    const MESSAGE = 'text';
    const ID_USER = 'id_user';

    /**
     * @param Request $request
     */
    public function home(Request $request)
    {
        $message = new \Detectify\Models\Message();
        $messages = $message->getAll();
        \Detectify\Alice\Dashboard::get()->home($messages);
    }
}