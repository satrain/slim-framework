<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, false);

$app->get('/models', function(Request $request, Response $response, $args) {
    $api_key = file_get_contents('https://swapi.dev/api/starships/');
    $api_data = json_decode($api_key);

    $res = $api_data->results;

    foreach($res as $r) {
        $response->getBody()->write("Starship: $r->model");
        $response->getBody()->write("<a href='/model/$r->model'>View Details</a>");
    }

    return $response;
});

$app->get('/model/{name}', function (Request $request, Response $response, $args){
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});



$app->run();
