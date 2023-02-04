<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('inv', ['namespace' => 'App\Modules\Inv\Controllers'], function($subroutes){

    /*** Route for Dashboard ***/
    $subroutes->add('dashboard', 'Dashboard::index');

});
