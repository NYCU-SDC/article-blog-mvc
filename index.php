<?php
require_once 'route.php';
require_once 'Controllers/ArticleController.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$response = handleRequest($requestUri, $requestMethod, $articleController);
echo $response;