<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../model/Database.php';
include_once '../controller/api/ArticleController.php';
 
$database = new Database();
$db = $database->getConnection();
 
$article = new ArticleController($db);
 
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->title)
    && !empty($data->content)
    && !empty($data->author_id)
    && !empty($data->category_id)) {

    $article->title = $data->title;
    $article->content = $data->content;
    $article->author_id = $data->author_id;
    $article->category_id = $data->category_id;
    
    if ($article->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Article has been created"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create article"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create article. Data is incomplete or invalid JSON format."));
}
