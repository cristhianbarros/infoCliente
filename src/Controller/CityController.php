<?php

namespace HandyCommerce\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use HandyCommerce\Model\Repository\CityRepository as cityRepo;

class CityController {

    protected $twig;

    public function __construct(\Slim\Views\Twig $twig) {
        $this->twig = $twig;
    }

    public function all(Request $request, Response $response, $args) {
        $twig = $this->twig;

        $cities = cityRepo::all();
        return $twig->render($response, 'city/all.html', ["cities" => $cities]);
    }

    public function citiesByState(Request $request, Response $response, $args) {
        $twig = $this->twig;

        $state_id = $request->getAttribute('state_id');
        $customer_city_id = $request->getAttribute('customer_city_id');
        $cities = cityRepo::findByState($state_id);

        return $twig->render($response, 'city/all.html', ["cities" => $cities, "customer_city_id" => $customer_city_id]);
    }

}
