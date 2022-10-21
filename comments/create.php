<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../model/Database.php';
include_once '../controller/api/CommentsController.php';
 
$database = new Database();
$db = $database->getConnection();
 
$comment = new CommentsController($db);
 
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name)
    && !empty($data->comment)
    && !empty($data->email)) {

    $comment->name = $data->name;
    $comment->comment = $data->comment;
    $comment->email = $data->email;
    if (isset($data->www)) { $comment->www = $data->www; }
    
    if ($comment->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Comment has been created"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create comment"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create comment. Data is incomplete."));
}
