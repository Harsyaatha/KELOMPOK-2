<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('rute', 'Pencarian::index');
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/login', 'Admin\Auth::attempt');
$routes->get('admin/logout', 'Admin\Auth::logout');

$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    $routes->get('node', 'Admin\Node::index');
    $routes->get('node/create', 'Admin\Node::create');
    $routes->post('node/store', 'Admin\Node::store');
    $routes->get('node/edit/(:num)', 'Admin\Node::edit/$1');
    $routes->post('node/update/(:num)', 'Admin\Node::update/$1');
    $routes->post('node/delete/(:num)', 'Admin\Node::delete/$1');

    $routes->get('jarak', 'Admin\Jarak::index');
    $routes->get('jarak/create', 'Admin\Jarak::create');
    $routes->post('jarak/store', 'Admin\Jarak::store');
    $routes->get('jarak/edit/(:num)', 'Admin\Jarak::edit/$1');
    $routes->post('jarak/update/(:num)', 'Admin\Jarak::update/$1');
    $routes->post('jarak/delete/(:num)', 'Admin\Jarak::delete/$1');
});