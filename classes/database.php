<?php
class Database
{
    private $server_name = 'localhost';
    private $database_username = 'root';
    private $database_password = '';
    private $database_name = 'comment_system';
    private $connection = null;

    public function getPost($id)
    {
        $this->connection = new mysqli(
            $this->server_name,
            $this->database_username,
            $this->database_password,
            $this->database_name
        );
        $this->connection->set_charset('utf8');
        $sql = $this->connection->prepare(
            'SELECT * FROM `post` WHERE id=?'
        );
        $sql->bind_param('i', $id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
            $sql->close();
            $this->connection->close();
            return $post;
        }
        $sql->close();
        $this->connection->close();
        return false;
    }

    public function getComments($id)
    {
        $this->connection = new mysqli(
            $this->server_name,
            $this->database_username,
            $this->database_password,
            $this->database_name
        );
        $this->connection->set_charset('utf8');
        $sql = $this->connection->prepare(
            'SELECT 
            c.id id,
            c.comment `comment`,
            c.user_email email,
            c.user_name user_name,
            c.date `date`,
            c.parent_id parent_id,
            a.name admin_name
            FROM `comment` c 
            LEFT JOIN admin a 
            ON a.id = c.admin_id
            WHERE c.post_id=?
            ORDER BY date'
        );
        $sql->bind_param('i', $id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $comments = [];
            while ($row = $result->fetch_assoc()) {
                array_push($comments, $row);
            }
            $sql->close();
            $this->connection->close();
            return $comments;
        }
        $sql->close();
        $this->connection->close();
        return false;
    }

    public function insertComment($comment)
    {
        $this->connection = new mysqli(
            $this->server_name,
            $this->database_username,
            $this->database_password,
            $this->database_name
        );
        $this->connection->set_charset('utf8');
        $sql = $this->connection->prepare(
            'INSERT INTO `comment`(`comment`, `user_email`, `user_name`, `date`, `parent_id`, `status`, `admin_id`, `post_id`) VALUES (?,?,?,?,?,?,?,?)'
        );
        $sql->bind_param(
            'ssssiiii',
            $comment['comment'],
            $comment['user_email'],
            $comment['user_name'],
            $comment['date'],
            $comment['parent_id'],
            $comment['status'],
            $comment['admin_id'],
            $comment['post_id']
        );
        if ($sql->execute()) {
            $sql->close();
            $this->connection->close();
            return true;
        }

        $error = $this->connection->errno;
        $sql->close();
        $this->connection->close();
        return $error;
    }
}
