<?php

namespace Library;

class Application {

    protected $request;

    public function __construct() {
        $this->request = new Request();
    }

    public function run() {
        $router = new Router($this);
        \Blog\fillRouter($router);

        try {
            $controller = $router->getController();
        } catch (Exceptions\NoSuchRouteException $e) {
            $controller = $this->get404ErrorController();
        }

        $response = $controller->action();
        $response->send();
    }

    public function get404ErrorController() {
        return new ErrorController(new Route('Error', 'show404', ''), $this);
    }

    public function get503ErrorController() {
        return new ErrorController(new Route('Error', 'show503', ''), $this);
    }

    public function getRequest() {
        return $this->request;
    }

}
