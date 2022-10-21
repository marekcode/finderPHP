<?php

include_once '../controller/api/BaseController.php';

class AuthorController extends BaseController
{
    private $tableName = 'authors';
    private $connection;

    public $firstname;
    public $lastname;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function create()
    {
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->tableName . ' (firstname, lastname) VALUES (?,?)'
        );

        $stmt->bind_param("ss", $this->firstname, $this->lastname);
        
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

        $firstname = '';
        $lastname = '';

        if (isset($this->firstname)) {
            $firstname = "firstname = ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->firstname)));
        }

        if (isset($this->lastname)) {
            $lastname = "lastname = ?, ";
            $types .= 's';
            array_push($params, htmlspecialchars(strip_tags($this->lastname)));
        }

        $types .= 'i';
        array_push($params, $this->id);

        $sql = "UPDATE " . $this->tableName . " SET " . $firstname . $lastname . "modified = now() WHERE id = ?";
	    $stmt = $this->connection->prepare($sql);

        var_dump($sql);
        var_dump($types);
        var_dump($params);

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
