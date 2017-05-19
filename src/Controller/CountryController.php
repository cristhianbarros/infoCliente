<?php

namespace HandyCommerce\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use HandyCommerce\Model\Repository\CountryRepository as countryRepository;

class CountryController {

    protected $twig;

    public function __construct(\Slim\Views\Twig $twig) {
        $this->twig = $twig;
    }

    public function all(Request $request, Response $response, $args) {
        $twig = $this->twig;

        $customer_country_id = $request->getAttribute('customer_country_id');
        $countries = countryRepository::all();

        return $twig->render($response, 'country/all.html', ["countries" => $countries, "customer_country_id"=>$customer_country_id]);
    }

}
