<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('process-email', 'Home::processEmail');
$routes->get('oauth2callback', 'Home::processEmail');


// Job Parser Routes
$routes->get('job-parser', 'JobParser::index');
$routes->post('api/job-parser/process', 'JobParser::processJobDescription');


// login
$routes->get('auth/register', 'AuthController::register');
$routes->post('auth/register', 'AuthController::registerNewUser');
$routes->get('register/success', 'AuthController::registerSuccess');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('login/success', 'AuthController::loginSuccess');

$routes->get('auth/verify/(:any)', 'AuthController::verify/$1');
$routes->get('auth/invalid-token', 'AuthController::invalidToken');
$routes->get('logout', 'AuthController::logout');



// Protected routes (require authentication)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    // Add more protected routes here
    // $routes->get('profile', 'ProfileController::index');
    // $routes->get('settings', 'SettingsController::index');
});