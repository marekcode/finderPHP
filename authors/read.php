<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../model/Database.php';
include_once '../controller/api/CommentsController.php';

$database = new Database();
$db = $database->getConnection();
 
$author = new CommentsController($db);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$isProperUri = !((isset($uri[1]) && $uri[1] != 'authors')
    || (isset($uri[2]) && $uri[2] != 'read'));

if (!$isProperUri) {
    http_response_code(404);
    exit();
}
    
//TODO: dodac szukanie w read np ?author_id=3

$author->id = isset($uri[3]) ? $uri[3] : false; //(isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $author->read();

if ($result->num_rows > 0) {
    $itemRecords = array();
    $itemRecords["author"] = array();
	while ($item = $result->fetch_assoc()) {
        extract($item);
        $itemDetails = array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
			"created" => $created,
            "modified" => $modified
        );
        
        array_push($itemRecords["author"], $itemDetails);
    }
    http_response_code(200);
    echo json_encode($itemRecords);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No author found.")
    );
}
