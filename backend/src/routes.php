<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Team Gamma!");

    return $this->renderer->render($response, 'index.phtml');
});
