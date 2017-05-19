<?php

// DIC configuration

$container = $app->getContainer();

// view renderer
//$container['renderer'] = function ($c) {
//    $settings = $c->get('settings')['renderer'];
//    return new Slim\Views\PhpRenderer($settings['template_path']);
//};
// Twig
$container['twig'] = function ($c) {

    $settings = $c->get('settings')['twig'];

    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

// Controllers
$container['HomeController'] = function($c) {
    $twig = $c['twig'];
    return new HandyCommerce\Controller\HomeController($twig);
};

$container['CustomerController'] = function($c) {
    $twig = $c['twig'];
    return new HandyCommerce\Controller\CustomerController($twig);
};

$container['VisitController'] = function($c) {
    $twig = $c['twig'];
    return new HandyCommerce\Controller\VisitController($twig);
};

$container['CountryController'] = function($c) {
    $twig = $c['twig'];
    return new HandyCommerce\Controller\CountryController($twig);
};

$container['StateController'] = function($c) {
    $twig = $c['twig'];
    return new HandyCommerce\Controller\StateController($twig);
};

$container['CityController'] = function($c) {
    $twig = $c['twig'];
    return new HandyCommerce\Controller\CityController($twig);
};

$container['SellerController'] = function($c) {
    $twig = $c['twig'];
    return new HandyCommerce\Controller\SellerController($twig);
};


// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
