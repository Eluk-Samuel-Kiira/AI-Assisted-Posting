<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('process-email', 'Home::processEmail');
$routes->get('oauth2callback', 'Home::processEmail');




// login
$routes->get('auth/register', 'AuthController::register');
$routes->post('auth/register', 'AuthController::registerNewUser');
$routes->get('register/success', 'AuthController::registerSuccess');

$routes->get('auth/login', 'AuthController::login');
$routes->post('auth/login-link', 'AuthController::loginLogic');
$routes->get('login/success', 'AuthController::loginSuccess');

$routes->get('auth/verify/(:any)', 'AuthController::verify/$1');
$routes->get('auth/invalid-token', 'AuthController::invalidToken');
$routes->get('auth/logout', 'AuthController::logout');



// Protected routes (require authentication)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    
    // Job Parser Routes
    $routes->get('job-parser', 'JobParser::index');
    $routes->post('api/job-parser/process', 'JobParser::processJobDescription');


    $routes->get('job-postings', 'JobParser::getJobs');
    $routes->get('job-postings/view/(:num)', 'JobParser::view/$1');
    $routes->get('job-postings/delete/(:num)', 'JobParser::delete/$1');

    // Companies
    $routes->get('companies', 'CompanyController::index');
    $routes->get('companies/create', 'CompanyController::create');
    $routes->get('companies/edit/(:num)', 'CompanyController::edit/$1');
    $routes->post('companies/store', 'CompanyController::store');
    $routes->post('companies/update/(:num)', 'CompanyController::update/$1');
    $routes->get('companies/delete/(:num)', 'CompanyController::delete/$1');
    
});