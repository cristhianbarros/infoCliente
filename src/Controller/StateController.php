<?php

namespace HandyCommerce\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use HandyCommerce\Model\Repository\StateRepository as stateRepo;

class StateController {

    protected $twig;

    public function __construct(\Slim\Views\Twig $twig) {
        $this->twig = $twig;
    }

    public function all(Request $request, Response $response, $args) {
        $twig = $this->twig;
        
        $states = stateRepo::all();
        return $twig->render($response, 'state/all.html', ["states" => $states]);
    }

    public function statesByCountry(Request $request, Response $response, $args) {
        $twig = $this->twig;

        $country_id = $request->getAttribute('country_id');
        $customer_state_id = $request->getAttribute('customer_state_id');
        $states = stateRepo::findByCountry($country_id);

        return $twig->render($response, 'state/all.html', ["states" => $states, "customer_state_id" => $customer_state_id]);
    }

}
