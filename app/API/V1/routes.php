<?php

use ET\API\V1\Http\Controllers\SearchController;
use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('search', SearchController::class . '@search');
