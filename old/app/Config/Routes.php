<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

$routes->get('/', 'VisitorManage::index');
$routes->get('/login', 'VisitorManage::index');
$routes->post('/login', 'VisitorManage::login');
$routes->post('/register', 'VisitorManage::register');
$routes->get('/logout', 'VisitorManage::logout');

$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

$routes->group('/', ['filter' => 'MemberAuthFilter'], function ($routes) {
    $routes->get('/home', 'frontside\MemberManage::index');

    $routes->get('/personal', 'frontside\MemberManage::personalinfo');
    $routes->get('/personal/(:uuid)', 'frontside\MemberManage::personal/$1');
    $routes->get('/personal/(:uuid)/edit', 'frontside\MemberManage::renderUpdatePage/$1');
    $routes->put('/personal/(:uuid)', 'frontside\MemberManage::update/$1');
    $routes->delete('/personal/(:uuid)', 'frontside\MemberManage::delete/$1');

    $routes->get('/cards', 'frontside\Cards::index');
    $routes->get('/cards/new', 'frontside\Cards::renderCreatePage');
    $routes->post('/cards', 'frontside\Cards::create');
    $routes->get('/cards/(:uuid)', 'frontside\Cards::perCard/$1');
    $routes->get('/cards/(:uuid)/edit', 'frontside\Cards::renderUpdatePage/$1');
    $routes->put('/cards/(:uuid)', 'frontside\Cards::update/$1');
    $routes->delete('/cards/(:uuid)', 'frontside\Cards::delete/$1');

    $routes->post('/dictionary', 'frontside\Dictionary::index');

    $routes->get('/quizlets', 'Quizlets::index');
    $routes->get('/quizlets/new', 'Quizlets::renderCreatePage');
    $routes->post('/quizlets/new', 'Quizlets::createQuiz');
    $routes->get('/quizlets/quizzing', 'Quizlets::renderQuizzingPage');
    $routes->post('/quizlets/quizzing', 'Quizlets::store');

    $routes->get('/statistics', 'Statistics::index');
    $routes->post('/statistics', 'Statistics::changeDaily');

    $routes->get('/achievement', 'Achievements::index');
});

$routes->group('/', ['filter' => 'ManagerAuthFilter'], function ($routes) {
    $routes->get('/backstage', 'backstage\ManagerManage::index');

    $routes->get('/managerinfo', 'backstage\ManagerManage::managerinfo');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
