<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../model/Database.php';
include_once '../controller/api/ArticleController.php';
 
$database = new Database();
$db = $database->getConnection();
 
$article = new ArticleController($db);
 
$data = json_decode(file_get_contents("php://input"));

//TODO: czesciowy update
if (!empty($data->title)
    && !empty($data->content)
    && !empty($data->author_id)
    && !empty($data->category_id)) {
	
	$article->id = $data->id;
	$article->title = $data->title;
    $article->content = $data->content;
    $article->author_id = $data->author_id;
    $article->category_id = $data->category_id;
	
	if ($article->update()) {
		http_response_code(200);
		echo json_encode(array("message" => "Item was updated."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Unable to update items."));
	}
} else {
	http_response_code(400);
    echo json_encode(array("message" => "Unable to update items. Data is incomplete."));
}
