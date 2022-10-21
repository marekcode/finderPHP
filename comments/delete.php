<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../model/Database.php';
include_once '../controller/api/CommentsController.php';
 
$database = new Database();
$db = $database->getConnection();
 
$comment = new CommentsController($db);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$isProperUri = !((isset($uri[1]) && $uri[1] != 'comments')
    || (isset($uri[2]) && $uri[2] != 'delete')
    || !isset($uri[3]));

if (!$isProperUri) {
    http_response_code(404);
    exit();
}

$id = $uri[3];

if (!empty($id)) {
	$comment->id = $id;
	
    if ($comment->delete()) {
		http_response_code(200);
		echo json_encode(array("message" => "Comment was deleted."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Unable to delete comment."));
	}
} else {
	http_response_code(400);
    echo json_encode(array("message" => "Unable to delete comment. Data is incomplete or invalid JSON format."));
}