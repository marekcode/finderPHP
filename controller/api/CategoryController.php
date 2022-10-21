<?php

include_once '../controller/api/BaseController.php';

class CategoryController extends BaseController
{
    private $tableName = 'categories';
    private $connection;

    public $name;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function create()
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
        
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->tableName . ' (name) VALUES (?)'
        );

        $stmt->bind_param("s", $this->name);
        
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

        $name = '';

        if (isset($this->name)) {
            $name = "name = ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->name)));
        }

        $types .= 'i';
        array_push($params, $this->id);

        $sql = "UPDATE " . $this->tableName . " SET " . $name . "modified = now() WHERE id = ?";
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
