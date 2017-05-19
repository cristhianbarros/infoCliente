<?php

namespace HandyCommerce\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use HandyCommerce\Model\Repository\VisitRepository as visitRepo;
use HandyCommerce\Model\Repository\CustomerRepository as customerRepo;
use HandyCommerce\Model\Visit as visit;
use HandyCommerce\Model\Customer as customer;
use HandyCommerce\Model\Seller as seller;

class VisitController {

    protected $twig;

    public function __construct(\Slim\Views\Twig $twig) {
        $this->twig = $twig;
    }

    public function add(Request $request, Response $response) {
        $twig = $this->twig;

        $customer_id = $request->getAttribute('customer_id');
        $customer = customerRepo::findById($customer_id);

        return $twig->render($response, '/visit/add.html', ["customer" => $customer]);
    }

    public function all(Request $request, Response $response) {
        $twig = $this->twig;
        return $twig->render($response, '/visit/all.html');
    }

    public function save(Request $request, Response $response) {
        $parameters = $request->getParsedBody();
        $arrayParameters = array();

        foreach ($parameters as $key => $param) {
            $arrayParameters[$key] = $param;
        }

        $id = isset($arrayParameters['id']) && $arrayParameters['id'] != '' ? $arrayParameters['id'] : null;
        $customer_id = isset($arrayParameters['customer']) && $arrayParameters['customer'] != '' ? $arrayParameters['customer'] : null;
        $date = $arrayParameters['date'];
        $net_value = $arrayParameters['net_value'];
        $visit_value = $arrayParameters['visit_value'];
        $comments = $arrayParameters['comments'];
        $seller_id = $arrayParameters['seller'];

        $balance_quota = customerRepo::checkBalanceQuota($customer_id);

        if ($balance_quota['balance_quota'] > 0 && $balance_quota['balance_quota'] >= $visit_value) {
            $visit = new visit($id, $date, $net_value, $visit_value, $comments, $customer_id, $seller_id);
            return visitRepo::save($visit);
        } else if ($balance_quota['balance_quota'] < $visit_value) {
            return "Lo sentimos, pero el saldo ($balance_quota[balance_quota]) que dispones es menor del valor de la visita ($visit_value).";
        }
    }

    public function visitsByCustomer(Request $request, Response $response) {
        $twig = $this->twig;

        $customer_id = $request->getAttribute('customer_id');

        $visits = visitRepo::visitsByCustomer($customer_id);

        return $twig->render($response, '/visit/customer_visits.html', ["visits" => $visits]);
    }
    
    public function showGraphic(Request $request, Response $response)  {
        
        $twig = $this->twig;
        $data = visitRepo::getDataVisitsGraphic();

        return $twig->render($response, '/visit/graphic.xhtml', ["data" => $data]);
        
    }

}
