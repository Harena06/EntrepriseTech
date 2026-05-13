<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::form');
$routes->get('/bo/dashboard/general', 'BOController::general');
$routes->get('/rh/dashboard/general', 'RHController::general');
$routes->get('/index' , 'EmployeController::index');
$routes->post('/connexion', 'AuthController::login');
$routes->get('/deconnexion', 'AuthController::logout');

