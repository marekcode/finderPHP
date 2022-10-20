<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../model/Database.php';
include_once '../controller/api/ArticleController.php';
 
$database = new Database();
$db = $database->getConnection();
 
$article = new ArticleController($db);
 
$data = json_decode(file_get_contents("php://input"));

// TODO: zrobic przez delete/id a nie przez { id: 6 }
if (!empty($data->id)) {
	$article->id = $data->id;
	
    if ($article->delete()) {
		http_response_code(200);
		echo json_encode(array("message" => "Item was deleted."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Unable to delete item."));
	}
} else {
	http_response_code(400);
    echo json_encode(array("message" => "Unable to delete items. Data is incomplete."));
}