<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../model/Database.php';
include_once '../controller/api/AuthorController.php';
 
$database = new Database();
$db = $database->getConnection();
 
$author = new AuthorController($db);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$isProperUri = !((isset($uri[1]) && $uri[1] != 'authors')
    || (isset($uri[2]) && $uri[2] != 'update')
    || !isset($uri[3]));

if (!$isProperUri) {
    http_response_code(404);
    exit();
}
 
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->firstname)
    || !empty($data->lastname)) {
	
	$author->id = $uri[3];
	if (isset($data->firstname)) { $author->firstname = $data->firstname; }
    if (isset($data->lastname)) { $author->lastname = $data->lastname; }
	
	if ($author->update()) {
		http_response_code(200);
		echo json_encode(array("message" => "Author was updated."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Unable to update author."));
	}
} else {
	http_response_code(400);
    echo json_encode(array("message" => "Unable to update author. Data is incomplete or invalid JSON format."));
}
