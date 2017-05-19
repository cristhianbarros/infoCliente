<?php

namespace HandyCommerce\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController {

    protected $twig;

    public function __construct(\Slim\Views\Twig $twig) {
        $this->twig = $twig;
    }

    public function home(Request $request, Response $response, $args) {
        $twig = $this->twig;
        return $twig->render($response, 'home/index.html', ["page" => "Home"]);
    }

}
