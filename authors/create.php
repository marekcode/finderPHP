<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../model/Database.php';
include_once '../controller/api/AuthorController.php';
 
$database = new Database();
$db = $database->getConnection();
 
$author = new AuthorController($db);
 
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->firstname)
    && !empty($data->lastname)) {

    $author->firstname = $data->firstname;
    $author->lastname = $data->lastname;
    
    if ($author->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Author has been created"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create author"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create author. Data is incomplete or invalid JSON format."));
}
