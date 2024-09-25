<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); // Allows all origins. Replace '*' with specific origin if needed.
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow methods that are needed
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow headers that are needed\
require_once __DIR__ . '/../vendor/autoload.php';

require 'schema.php';
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    // Use the fully qualified name for the GraphQL class
    $r->addRoute('POST', '/learit/api/index.php', ['trying', 'handle']);
});


$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo("not found");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo("not allowed");
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        echo $handler($vars);
        break;
}
