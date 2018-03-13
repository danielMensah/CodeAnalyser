<?php

use Slim\Http\Request;
use Slim\Http\Response;

header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../src/Controllers/EntryController.php';

// Routes

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Team Gamma!");

    return $this->renderer->render($response, 'index.phtml');
});

$app->post('/api/submitCode', function (Request $request, Response $response) {
    $codeAsArray = explode("\n", $request->getParsedBody()['text']);

    $controller = new EntryController('java');
    $response->getBody()->write($controller->codeReview($codeAsArray));

    return $response;
});

$app->post('/api/dummy/submitCode', function (Request $request, Response $response) {
    $dummyData = json_decode(file_get_contents(
        __DIR__ . '/../util/dummyData.json'), true);

    $response->getBody()->write(json_encode($dummyData));

    return $response;
});