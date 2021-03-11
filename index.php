<?php

declare(strict_types=1);

use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\RouteGroup;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;

require 'vendor/autoload.php';

/**
 * In this file we have the the routing configuration where we can
 * manage all the endpoints that we need to manage.
 * For test you can run command $ php -S 127.0.0.1:8080
 */

/*
 * Configure the router using a json strategy
 */
$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE);

$router = new Router();

$responseFactory = new ResponseFactory();
$jsonStrategy = new JsonStrategy($responseFactory);
$router->setStrategy($jsonStrategy);

/*
 * simple endpoints
 */
$router->group('/api', static function (RouteGroup $route) {
    /*
     * For test use: curl -vv 'http://localhost:8080/api/get'
     */
    $route->get('/get', 'App\Controller\ApiController::get');

    /*
    * For test use: curl -vv -X POST 'http://localhost:8080/api/post'
    */
    $route->post('/post', 'App\Controller\ApiController::post');
});

/*
 * endpoints with parameters
 */
$router->group('/api/params', static function (RouteGroup $route) {
    /*
     * For test use: curl -vv 'http://localhost:8080/api/params/get?param1=myTest'
     */
    $route->get('/get', 'App\Controller\ApiController::getWithParams');

    /*
     * For test use: curl -vv -X POST 'http://localhost:8080/api/params/post' --data 'param1=myTest'
     */
    $route->post('/post', 'App\Controller\ApiController::postWithParams');
});

/*
 * emit the response. Without this lines the endpoints will not return nothing
 */
$resp = $router->dispatch($request);
(new SapiEmitter())->emit($resp);
