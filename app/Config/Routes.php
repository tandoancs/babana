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

// view
$routes->get('/', 'Home::index');
$routes->get('/views', 'Home::views');
// load data
$routes->get('/load', 'Home::load');
$routes->get('/detailLoad', 'Home::detailLoad');

// test
$routes->get('/testData', 'Home::testData');

// get data
$routes->get('/getOptionsOfOrderGrid', 'Home::getOptionsOfOrderGrid');
$routes->add('/getDataToAddForm', 'Home::getDataToAddForm');
$routes->add('/getDetailDataToAdd', 'Home::getDetailDataToAdd');
$routes->add('/getAreaId', 'Home::getAreaId');
$routes->add('/getFoodPrice', 'Home::getFoodPrice');

// save
$routes->add('/saveOrder', 'Home::saveOrder');
$routes->add('/saveMainOrder', 'Home::saveMainOrder');
$routes->add('/deleteMainOrder', 'Home::deleteMainOrder');
$routes->add('/saveDetail', 'Home::saveDetail');
$routes->add('/deleteDetail', 'Home::deleteDetail');


// print
$routes->add('/printer', 'Home::printer');

// master data
// area
$routes->add('/area', 'Home::area');
$routes->add('/saveArea', 'Home::saveArea');
$routes->add('/deleteArea', 'Home::deleteArea');

// table
$routes->add('/tableOrder', 'Home::tableOrder');
$routes->add('/saveTableOrder', 'Home::saveTableOrder');
$routes->add('/deleteTableOrder', 'Home::deleteTableOrder');

// food
$routes->add('/food', 'Home::food');
$routes->add('/saveFood', 'Home::saveFood');
$routes->add('/deleteFood', 'Home::deleteFood');

// promotion
$routes->add('/promotion', 'Home::promotion');
$routes->add('/savePromotion', 'Home::savePromotion');
$routes->add('/deletePromotion', 'Home::deletePromotion');


// import
$routes->add('/imports', 'Home::imports');










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

// $routes->get('/', 'Home::index');
// $routes->resource('products');