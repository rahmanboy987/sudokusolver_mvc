<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::index');
$routes->get('/solve/(:num)', 'Home::solve/$1');
$routes->get('/solved', 'Home::solved');
