<?php
require __DIR__ . "/bootstrap.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// if (!isset($_SERVER['REQUEST_URI']))
// {
//         $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
//         if (isset($_SERVER['QUERY_STRING'])) {
//             $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];
//         }
// }
 
// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri = explode('/', $uri);

// if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
//     header("HTTP/1.1 404 Not Found");
//     exit();
// }
 
// require PROJECT_ROOT_PATH . "/controller/api/UserController.php";
 
// $objFeedController = new UserController();
// $strMethodName = $uri[3] . 'Action';
// $objFeedController->{$strMethodName}();

print "sdsf";
