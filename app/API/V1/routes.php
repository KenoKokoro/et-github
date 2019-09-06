<?php

use ET\API\V1\Http\Controllers\GithubSearchController;
use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'search'], function(Router $router) {
    $router->get('github/keyword', GithubSearchController::class . '@keyword');
});
