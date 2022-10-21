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

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$isProperUri = !((isset($uri[1]) && $uri[1] != 'articles')
    || (isset($uri[2]) && $uri[2] != 'update')
    || !isset($uri[3]));

if (!$isProperUri) {
    http_response_code(404);
    exit();
}
 
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->title)
    || !empty($data->content)
    || !empty($data->author_id)
    || !empty($data->category_id)) {
	
	$article->id = $uri[3];
	if (isset($data->title)) { $article->title = $data->title; }
    if (isset($data->content)) { $article->content = $data->content; }
    if (isset($data->author_id)) { $article->author_id = $data->author_id; }
    if (isset($data->category_id)) { $article->category_id = $data->category_id; }
	
	if ($article->update()) {
		http_response_code(200);
		echo json_encode(array("message" => "Article was updated."));
	} else {
		http_response_code(503);
		echo json_encode(array("message" => "Unable to update article."));
	}
} else {
	http_response_code(400);
    echo json_encode(array("message" => "Unable to update article. Data is incomplete or invalid JSON format."));
}
