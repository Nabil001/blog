<?php

namespace Library;

class Application {

    protected $request;

    public function __construct() {
        $this->request = new Request();
    }

    public function run() {
        $router = new Router($this);
        $router->addRoute(new Route('Default', 'home', '#^/(home)?/?$#'));
        $router->addRoute(new Route('Post', 'add', '#^/add/?$#'));
        $router->addRoute(new Route('Post', 'list', '#^/list-([1-9][0-9]{0,})(-5|-10)?/?$#', array('page', 'limit')));
        $router->addRoute(new Route('Post', 'show', '#^/show-([1-9][0-9]{0,})/?$#', array('id')));
        $router->addRoute(new Route('Post', 'update', '#^/update-([1-9][0-9]{0,})/?$#', array('id')));

        try {
            $controller = $router->getController();
        } catch (Exceptions\NoSuchRouteException $e) {
            $controller = $this->get404ErrorController();
        }

        $response = $controller->action();
        $response->send();
    }

    public function get404ErrorController() {
        //header($this->request->getProtocol() . '404 Not Found', true);
        return new ErrorController(new Route('Error', 'show404', ''), $this);
    }

    public function get503ErrorController() {
        //header($this->request->getProtocol() . '503 Service Unavailable', true);
        return new ErrorController(new \Library\Route('Error', 'show503', ''), $this);
    }

    public function getRequest() {
        return $this->request;
    }

}
