<?php

namespace Blog;

class Application {

    protected $request;

    public function __construct() {
        $this->request = new \Library\Request();
    }

    public function run() {
        $router = new \Library\Router($this);
        $router->addRoute(new Route('Default', 'home', '#^(/home)?/$#'));
        $router->addRoute(new Route('Post', 'add', '#^/add/?$#'));
        $router->addRoute(new Route('Post', 'list', '#^/list/([1-9]{1,})/?$#'));
        $router->addRoute(new Route('Post', 'show', '#^/show-([1-9][0-9]{0,})/?$#', array('id')));
        $router->addRoute(new Route('Post', 'update', '#^/update-([1-9][0-9]{0,})/?$#', array('id')));

        $controller = $router->getController();

        $response = $controller->execute();
        $response->send();
    }

    public function get404ErrorController() {
        //header($this->request->getProtocol() . '404 Not Found', true);
        $controller = new Error\ErrorController(
                                                new Route('Default', 'show404', ''),
                                                $this->request,
                                                $this
                                                );
    }

    public function get503ErrorController() {
        //header($this->request->getProtocol() . '503 Service Unavailable', true);
        $controller = new Error\ErrorController(
                                                new Route('Default', 'show503', ''),
                                                $this->request,
                                                $this
                                                );
    }

    public function getRequest() {
        return $this->request;
    }

}
