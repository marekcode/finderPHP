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

        $title = '';
        $content = '';
        $author_id = '';
        $category_id = '';

        if (isset($this->title)) {
            $title = "title= ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->title)));
        }

        if (isset($this->content)) {
            $content = "content= ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->content)));
        }

        if (isset($this->author_id)) {
            $author_id = "author_id= ?, ";
            $types .= 'i';
            array_push($params, htmlspecialchars(strip_tags($this->author_id)));
        }

        if (isset($this->category_id)) {
            $category_id = "category_id= ?, ";
            $types .= 'i';
            array_push($params, htmlspecialchars(strip_tags($this->category_id)));
        }

        $types .= 'i';
        array_push($params, $this->id);

        $sql = "UPDATE " . $this->tableName . " SET " . $title . $content . $author_id . $category_id . "modified = now() WHERE id = ?";
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
