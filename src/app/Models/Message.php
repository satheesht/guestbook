<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 6:23 PM
 */

namespace Detectify\Models;


use Detectify\Support\Database;

class Message extends Sanitizer
{
    protected $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance();
    }

    /**
     * Creates a new message
     * @param $message
     * @return bool|\mysqli_result
     */
    public function create($message)
    {
        $message = $this->sanitizeFields($this->connection, $message);
        $query = $this->connection->buildQuery("insert","messages", $message);
        return $this->connection->query($query);
    }

    public function editMessage($data)
    {
        $data = $this->sanitizeFields($this->connection, $data);
        $query = 'UPDATE messages SET text = "'.$data['text'].'" WHERE id_user="'.$data['id_user'].'" AND id="'.$data['id'].'"';
        return $this->connection->query($query);
    }

    public function deleteMessage($data)
    {
        $data = $this->sanitizeFields($this->connection, $data);
        $query = 'DELETE FROM messages WHERE id_user="'.$data['id_user'].'" AND id="'.$data['id'].'"';
        return $this->connection->query($query);
    }

    public function replyMessage($data)
    {
        $data = $this->sanitizeFields($this->connection, $data);
        $query = $this->connection->buildQuery('insert','message_replies', $data);
        return $this->connection->query($query);
    }

    public function getAll()
    {
        $query = 'SELECT a.text,a.id,b.firstname,b.lastname FROM messages a LEFT JOIN users b ON a.id_user=b.id';
        $result = $this->connection->query($query);
        return $result->fetch_all();
    }

    public function getReplies($data)
    {
        $data = $this->sanitizeFields($this->connection, $data);
        $query = 'SELECT a.text,a.id,b.firstname,b.lastname FROM message_replies a LEFT JOIN users b ON a.id_user=b.id WHERE a.id_message="'.$data['id_message'].'"';
        $result = $this->connection->query($query);
        return $result->fetch_all();

    }
}