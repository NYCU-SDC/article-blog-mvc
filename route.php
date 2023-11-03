<?php
require_once 'Mappers/Database.php';
require_once 'Mappers/ArticleMapper.php';
require_once 'Controllers/View.php';
require_once 'Controllers/ArticleController.php';

use Mappers\ArticleMapper;
use Mappers\Database;
use Controllers\View;
use Controllers\ArticleController;

$pdo = (new Database('localhost', 'kwei', 'kwei', 'kwei'))->getPdo();
$articleMapper = new ArticleMapper($pdo);
$view = new View();
$articleController = new ArticleController($articleMapper, $view);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$response = '';

if ($requestMethod == 'GET' && $requestUri == '/article_list') {
    $response = $articleController->index();
}

if ($requestMethod == 'GET' && preg_match('/^\/article\/(\d+)$/', $requestUri, $matches)) {
    $response = $articleController->show($matches[1]);
}

echo $response;
?>