<?php
// Routes
$app->get('/', "HomeController:home")->setName('home');

$app->get('/customers', "CustomerController:all")->setName('customers_all');
$app->get('/customer/add[/{id:[0-9]+}]', "CustomerController:add")->setName('customers_add');
$app->post('/customer/save', "CustomerController:save")->setName('customer_save');
$app->delete('/customer/delete/{id:[0-9]+}', "CustomerController:delete")->setName('customer_delete');

$app->get('/visit/add[/customer/{customer_id:[0-9]+}]', "VisitController:add")->setName('visits_add');
$app->get('/visits/customer/{customer_id:[0-9]+}', "VisitController:visitsByCustomer")->setName('visits_by_customer');
$app->post('/visit/save', "VisitController:save")->setName('visit_save');
$app->get('/visit/graphic', "VisitController:showGraphic")->setName('visit_graphic');

$app->get('/countries[/customer_country/{customer_country_id:[0-9]+}]', "CountryController:all")->setName('countries_all');

$app->get('/states', "StateController:all")->setName('state_all');
$app->get('/states/country/{country_id:[0-9]+}[/customer_state/{customer_state_id:[0-9]+}]', "StateController:statesByCountry")->setName('state_by_country');

$app->get('/cities', "CityController:all")->setName('cities_all');
$app->get('/cities/state/{state_id:[0-9]+}[/customer_city/{customer_city_id:[0-9]+}]', "CityController:citiesByState")->setName('city_by_cities');

$app->get('/sellers', "SellerController:all")->setName('sellers_all');

