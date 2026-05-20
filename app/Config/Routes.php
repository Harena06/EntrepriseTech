<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::form');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/bo/dashboard/general', 'BOController::general');
$routes->get('/rh/dashboard/general', 'RHController::general');
$routes->post('/rh/conges/approuver/(:num)', 'RHController::approuver/$1');
$routes->post('/rh/conges/refuser/(:num)', 'RHController::refuser/$1');
$routes->get('/index' , 'EmployeController::index');
$routes->post('/connexion', 'AuthController::login');
$routes->get('/deconnexion', 'AuthController::logout');

// Employe
$routes->get('/conges', 'CongeController::mesDemandes');
$routes->post('/conges/demander', 'CongeController::demander');
$routes->post('/conges/annuler/(:num)', 'CongeController::annuler/$1');
$routes->get('/soldes', 'SoldeController::mesSoldes');
$routes->get('/nouvelle-Demande', 'CongeController::formulaireDemande');
$routes->get('/calendar', 'CalendarController::index');
// RH
$routes->get('/rh/demandes', 'RHController::demandesEnAttente');
$routes->post('/rh/conges/approuver/(:num)', 'RHController::approuver/$1');
$routes->post('/rh/conges/refuser/(:num)', 'RHController::refuser/$1');
$routes->get('/rh/conges/filtrer', 'RHController::filtrer');
$routes->get('/rh/soldes/(:num)', 'SoldeController::soldeEmploye/$1');

// Admin
$routes->get('/admin/employes', 'AdminController::employes');
$routes->post('/admin/employes/(:num)', 'AdminController::updateEmploye/$1');
$routes->get('/admin/departements', 'AdminController::departements');
$routes->post('/admin/departements', 'AdminController::createDepartement');
$routes->post('/admin/departements/(:num)', 'AdminController::updateDepartement/$1');
$routes->delete('/admin/departements/(:num)', 'AdminController::deleteDepartement/$1');
$routes->get('/admin/types-conges', 'AdminController::typesConges');
$routes->post('/admin/types-conges', 'AdminController::createTypeConge');
$routes->post('/admin/types-conges/(:num)', 'AdminController::updateTypeConge/$1');
$routes->delete('/admin/types-conges/(:num)', 'AdminController::deleteTypeConge/$1');

