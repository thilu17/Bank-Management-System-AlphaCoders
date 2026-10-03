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
});