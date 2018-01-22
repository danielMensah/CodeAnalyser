<?php

use Slim\Http\Request;
use Slim\Http\Response;

header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../Controllers/CodeInspectorController.php';

// Routes

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Team Gamma!");

    return $this->renderer->render($response, 'index.phtml');
});

$app->post('/api/submitCode', function (Request $request, Response $response) {
    $code = $request->getParsedBody()['text'];

    $controller = new CodeInspectorController();
    $response->getBody()->write($controller->Inspector($code));

    return $response;
});