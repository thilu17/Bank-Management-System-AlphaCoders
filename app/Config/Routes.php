<?php

use CodeIgniter\Router\RouteCollection;

// Web Routes
$routes->get('/', 'Home::index');

// Authentication Web Routes
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::loginSubmit');
$routes->get('/signup', 'AuthController::signup');
$routes->post('/signup', 'AuthController::signupSubmit');
$routes->get('/logout', 'AuthController::logout');

// Protected Web Routes
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Loan Products Web Routes (Branch Manager & Super Admin)
$routes->group('loans/products', ['filter' => ['auth', 'role:Branch Manager,SUPER ADMIN']], static function ($routes) {
    $routes->get('/', 'LoanProductController::index');
    $routes->post('create', 'LoanProductController::create');
    $routes->post('update/(:num)', 'LoanProductController::update/$1');
    $routes->get('toggle/(:num)', 'LoanProductController::toggle/$1');
    $routes->get('delete/(:num)', 'LoanProductController::delete/$1');
});

// API Routes
$routes->group('api/v1', static function ($routes) {
    $routes->post('auth/login', 'Api\AuthApi::login');
    $routes->post('auth/signup', 'Api\AuthApi::signup');

    // FD Products: Branch Manager / Super Admin only
    $routes->group('fd-products', ['filter' => ['auth', 'role:Branch Manager,SUPER ADMIN']], static function ($routes) {
        $routes->get('/', 'Api\FdProductApi::index');
        $routes->post('/', 'Api\FdProductApi::create');
        $routes->put('(:num)', 'Api\FdProductApi::update/$1');
        $routes->patch('(:num)/toggle', 'Api\FdProductApi::toggle/$1');
    });

    // Loan Products: Branch Manager / Super Admin only
    $routes->group('loan-products', ['filter' => ['auth', 'role:Branch Manager,SUPER ADMIN']], static function ($routes) {
        $routes->get('/', 'Api\LoanProductApi::index');
        $routes->get('(:num)', 'Api\LoanProductApi::show/$1');
        $routes->post('/', 'Api\LoanProductApi::create');
        $routes->put('(:num)', 'Api\LoanProductApi::update/$1');
        $routes->patch('(:num)/toggle', 'Api\LoanProductApi::toggle/$1');
        $routes->delete('(:num)', 'Api\LoanProductApi::delete/$1');
    });
});