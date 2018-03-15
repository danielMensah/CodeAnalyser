<?php

use Slim\Http\Request;
use Slim\Http\Response;

header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../src/Controllers/EntryController.php';
require_once __DIR__ . '/../src/Models/ResponseModel.php';

// Routes

$app->post('/api/submitCode', function (Request $request, Response $response) {
    if (!strlen(trim($request->getParsedBody()['text']))) {
        $responseModel = new ResponseModel();

        $responseModel->setResponse("Invalid code! You may have submitted an empty field or an invalid Java code.");
        $responseModel->setErrorLine("");
        $responseModel->setValid(false);
        $response->getBody()->write(json_encode(dismount($responseModel)));

        return $response;
    }

    $codeAsArray = explode("\n", $request->getParsedBody()['text']);
    $readabilityType = $request->getQueryParams()['readabilityType'];

    $controller = new EntryController('java');
    $response->getBody()->write($controller->codeReview($codeAsArray, $readabilityType));

    return $response;
});

//$app->post('/api/dummy/submitCode', function (Request $request, Response $response) {
//    $dummyData = json_decode(file_get_contents(
//        __DIR__ . '/../util/dummyData.json'), true);
//
//    $response->getBody()->write(json_encode($dummyData));
//
//    return $response;
//});