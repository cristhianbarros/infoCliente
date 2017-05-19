<?php

namespace HandyCommerce\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use HandyCommerce\Model\Repository\SellerRepository as sellerRepo;

class SellerController {

    protected $twig;

    public function __construct(\Slim\Views\Twig $twig) {
        $this->twig = $twig;
    }

    public function all(Request $request, Response $response, $args) {
        $twig = $this->twig;
        $sellers = sellerRepo::all();
        
        return $twig->render($response, 'seller/all.html', ["sellers" => $sellers]);
    }

}
