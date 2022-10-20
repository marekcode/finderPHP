<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../model/Database.php';
include_once '../controller/api/ArticleController.php';

$database = new Database();
$db = $database->getConnection();
 
$article = new ArticleController($db);

//TODO: zmienic format ?id=3 na /3
//TODO: dodac szukanie w read np ?author_id=3
$article->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $article->read();

if ($result->num_rows > 0) {
    $itemRecords = array();
    $itemRecords["article"] = array();
	while ($item = $result->fetch_assoc()) {
        extract($item);
        $itemDetails = array(
            "id" => $id,
            "title" => $title,
            "content" => $content,
			"author_id" => $author_id,
            "category_id" => $category_id,
			"created" => $created,
            "modified" => $modified
        );
        
        array_push($itemRecords["article"], $itemDetails);
    }
    http_response_code(200);
    echo json_encode($itemRecords);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No item found.")
    );
}
