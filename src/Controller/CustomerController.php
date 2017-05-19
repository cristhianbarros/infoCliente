<?php

namespace HandyCommerce\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use HandyCommerce\Model\Repository\CustomerRepository as customerRepository;
use HandyCommerce\Model\Customer as customer;

class CustomerController {

    protected $twig;

    public function __construct(\Slim\Views\Twig $twig) {
        $this->twig = $twig;
    }

    public function home(Request $request, Response $response) {
        $twig = $this->twig;
        return $twig->render($response, 'home/index.html', ["page" => "Customer"]);
    }

    public function all(Request $request, Response $response) {
        $twig = $this->twig;

        $customers = customerRepository::all();
        return $twig->render($response, '/customer/all.html', ["customers" => $customers]);
    }

    public function add(Request $request, Response $response) {
        $twig = $this->twig;

        $id = (int) $request->getAttribute('id');
        $customer = $id != '' && is_int($id) ? customerRepository::findById($id) : null;

        return $twig->render($response, '/customer/add.html', ["customer" => $customer]);
    }

    public function save(Request $request, Response $response) {
        $parameters = $request->getParsedBody();
        $arrayParameters = array();

        foreach ($parameters as $key => $param) {
            $arrayParameters[$key] = $param;
        }

        $id = isset($arrayParameters['id']) && $arrayParameters['id'] != '' ? $arrayParameters['id'] : null;
        $dni = $arrayParameters['dni'];
        $full_name = $arrayParameters['full_name'];
        $address = $arrayParameters['address'];
        $phone = $arrayParameters['phone'];
        $quota = $arrayParameters['quota'];
        $balance_quota = $arrayParameters['balance_quota'];
        $percentage_visit = $arrayParameters['percentage_visit'];
        $city_id = $arrayParameters['city'];

        $customer = new customer($id, $dni, $full_name, $address, $phone, $city_id, $quota, $balance_quota, $percentage_visit);

        return customerRepository::save($customer);
    }

    public function delete(Request $request, Response $response) {

        $id = !is_null($request->getAttribute('id')) ? (int) $request->getAttribute('id') : null;
        $customer = customerRepository::findById($id);
        $c = new customer($customer['id'], '', '', '', '', '', '', '', '');

        echo customerRepository::delete($c);
    }

}
