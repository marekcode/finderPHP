<?php

include_once '../controller/api/BaseController.php';

class ArticleController extends BaseController
{
    private $tableName = 'articles';
    private $connection;

    public $title;
    public $content;
    public $author_id;
    public $category_id;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function create()
    {
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->author_id = intval(htmlspecialchars(strip_tags($this->author_id)));
        $this->category_id = intval(htmlspecialchars(strip_tags($this->category_id)));
        
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->tableName . ' (title, content, author_id, category_id) VALUES (?,?,?,?)'
        );

        $stmt->bind_param("ssss", $this->title, $this->content, $this->author_id, $this->category_id);
        
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
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
	    $stmt = $this->connection->prepare("UPDATE " . $this->tableName . " SET title= ?, content = ?, author_id = ?, category_id = ?, modified = now() WHERE id = ?");
 
	    $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->author_id = intval(htmlspecialchars(strip_tags($this->author_id)));
        $this->category_id = intval(htmlspecialchars(strip_tags($this->category_id)));
        $this->id = htmlspecialchars(strip_tags($this->id));
 
        //TODO: oddzielic powtarzajaca sie liste zmiennych do jednej funkcji i miejsca
	    $stmt->bind_param(
            "ssiii",
            $this->title, $this->content, $this->author_id, $this->category_id, $this->id
        );
	
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }

    public function delete()
    {
	    $stmt = $this->connection->prepare("DELETE FROM " . $this->tableName . " WHERE id = ?");
		
	    $this->id = htmlspecialchars(strip_tags($this->id));
 
	    $stmt->bind_param("i", $this->id);
 
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
}
