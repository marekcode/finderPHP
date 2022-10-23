<?php

include_once '../controller/api/BaseController.php';

class CommentsController extends BaseController
{
    private $tableName = 'comments';
    private $connection;

    public $article_id;
    public $name;
    public $comment;
    public $email;
    public $www;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function create()
    {
        $this->article_id = htmlspecialchars(strip_tags($this->article_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->comment = htmlspecialchars(strip_tags($this->comment));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->www = isset($this->www) ? htmlspecialchars(strip_tags($this->www)) : '';
        
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->tableName . ' (article_id, name, comment, email, www) VALUES (?,?,?,?,?)'
        );

        $stmt->bind_param("issss", $this->article_id, $this->name, $this->comment, $this->email, $this->www);
        
        return $stmt->execute();
    }

    public function read()
    {
	    if ($this->id) {
		    $stmt = $this->connection->prepare("SELECT * FROM " . $this->tableName . " WHERE id = ?");
		    $stmt->bind_param("i", $this->id);
	    } else {
		    $stmt = $this->connection->prepare("SELECT * FROM " . $this->tableName);
	    }
	    $stmt->execute();
	    
        return $stmt->get_result();
    }

    public function update()
    {
        $this->id = htmlspecialchars(strip_tags($this->id));

        $types = '';
        $params = array();

        $article_id = '';
        $name = '';
        $comment = '';
        $email = '';
        $www = '';

        if (isset($this->article_id)) {
            $article_id = "article_id = ?, ";
            $types .= 'i';
            array_push($params, htmlspecialchars(strip_tags($this->article_id)));
        }
        
        if (isset($this->name)) {
            $name = "name = ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->name)));
        }

        if (isset($this->comment)) {
            $comment = "comment = ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->comment)));
        }

        if (isset($this->email)) {
            $email = "email = ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->email)));
        }

        if (isset($this->www)) {
            $www = "www = ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->www)));
        }

        $types .= 'i';
        array_push($params, $this->id);

        $sql = "UPDATE " . $this->tableName . " SET " . $article_id . $name . $comment . $email . $www . "modified = now() WHERE id = ?";
	    $stmt = $this->connection->prepare($sql);

        //TODO: oddzielic powtarzajaca sie liste zmiennych do jednej funkcji i miejsca
	    $stmt->bind_param($types, ...$params);
	
        return $stmt->execute();
    }

    public function delete()
    {
	    $stmt = $this->connection->prepare("DELETE FROM " . $this->tableName . " WHERE id = ?");
		
	    $this->id = htmlspecialchars(strip_tags($this->id));
 
	    $stmt->bind_param("i", $this->id);
 
        return $stmt->execute();
    }
}
