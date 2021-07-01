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
        $response->getBody()->write("<table><tr><td>Starship: $r->model</td>");
        $response->getBody()->write("<td><a href='/model/$r->model'>View Details</a></td></tr></table>");
    }

    return $response;
});

$app->get('/model/{name}', function (Request $request, Response $response, $args){
    $name = $args['name'];

    $response->getBody()->write("<h1>$name</h1>");

    $api_key = file_get_contents('https://swapi.dev/api/starships/');
    $api_data = json_decode($api_key);

    $res = $api_data->results;

    foreach($res as $r) {
        if($r->model == $name) {
            foreach ($r as $key => $value) {
                // don't write array attribute values, we don't need them anyway
                if(gettype($value) == 'array')
                {}
                else {
                    $formatedKey = str_replace("_", " ", $key);
                    $response->getBody()->write(ucfirst($formatedKey) . ": " . $value . "<br>");
                }
            }
        }
    }
    return $response;
});



$app->run();
